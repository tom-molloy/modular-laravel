<?php

declare(strict_types=1);

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddy;
use Modules\Product\Models\Product;

class CheckoutController
{
    public function __invoke(CheckoutRequest $checkoutRequest, Guard $guard): JsonResponse
    {
        $productsInput = (array) $checkoutRequest->input('products');

        /** @var array<string, int> */
        $productQuantities = array_column($productsInput, 'quantity', 'id');

        $products = Product::query()->whereIn('id', array_column($productsInput, 'id'))
            ->get();

        $orderTotal = $products->sum(
            fn (Product $product): int => $product->price_in_cents * $productQuantities[$product->id]
        );

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

        foreach ($products as $product) {
            $order->lines()->create([
                'product_id' => $product->id,
                'total_in_cents' => $product->price_in_cents,
                'quantity' => $productQuantities[$product->id],
            ]);
        }

        return response()->json([
            'order_url' => $order->url(),
        ], 201);
    }
}
