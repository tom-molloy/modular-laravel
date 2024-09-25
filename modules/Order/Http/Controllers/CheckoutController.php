<?php

declare(strict_types=1);

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class CheckoutController
{
    public function __construct(
        protected ProductStockManager $productStockManager
    ) {}

    public function __invoke(CheckoutRequest $checkoutRequest, Guard $guard): JsonResponse
    {
        $cartItemCollection = CartItemCollection::fromCheckoutData((array) $checkoutRequest->input('products'));

        $orderTotal = $cartItemCollection->totalInCents();

        $payBuddy = PayBuddy::make();
        try {
            $charge = $payBuddy->charge(
                $checkoutRequest->string('payment_token')->value(),
                $orderTotal,
                'Modularization'
            );
        } catch (\Exception) {
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment',
            ]);
        }

        $order = Order::query()->create([
            'payment_id' => $charge['id'],
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'total_in_cents' => $orderTotal,
            'user_id' => $guard->user()?->getAuthIdentifier(),
        ]);

        foreach ($cartItemCollection->items() as $cartItem) {
            $this->productStockManager->decrement(
                $cartItem->productDto->id,
                $cartItem->quanity
            );

            $order->lines()->create([
                'product_id' => $cartItem->productDto->id,
                'total_in_cents' => $cartItem->productDto->priceInCents,
                'quantity' => $cartItem->quanity,
            ]);
        }

        return response()->json([
            'order_url' => $order->url(),
        ], 201);
    }
}
