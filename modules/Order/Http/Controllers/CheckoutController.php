<?php

declare(strict_types=1);

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Order\Actions\PurchaseItems;
use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class CheckoutController
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected PurchaseItems $purchaseItems
    ) {}

    public function __invoke(CheckoutRequest $checkoutRequest): JsonResponse
    {
        $cartItemCollection = CartItemCollection::fromCheckoutData((array) $checkoutRequest->input('products'));

        try {
            $order = $this->purchaseItems->handle(
                $cartItemCollection,
                PayBuddy::make(),
                $checkoutRequest->string('payment_token')->value(),
            );
        } catch (PaymentFailedException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment',
            ]);
        }

        return response()->json([
            'order_url' => $order->url(),
        ], 201);
    }
}
