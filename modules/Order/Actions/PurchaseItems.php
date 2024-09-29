<?php

declare(strict_types=1);

namespace Modules\Order\Actions;

use Illuminate\Contracts\Auth\Guard;
use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected Guard $guard
    ) {}

    public function handle(
        CartItemCollection $cartItemCollection,
        PayBuddy $payBuddy,
        string $paymentToken,
    ): Order {
        $orderTotal = $cartItemCollection->totalInCents();
        try {
            $charge = $payBuddy->charge(
                $paymentToken,
                $orderTotal,
                'Modularization'
            );
        } catch (\Exception) {
            throw PaymentFailedException::dueToInvalidToken();
        }

        $order = Order::query()->create([
            'payment_id' => $charge['id'],
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'total_in_cents' => $orderTotal,
            'user_id' => $this->guard->user()?->getAuthIdentifier(),
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

        $order->payments()->create([
            'total_in_cents' => $orderTotal,
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'payment_id' => $charge['id'],
            'user_id' => $this->guard->user()?->getAuthIdentifier(),
        ]);

        return $order;
    }
}
