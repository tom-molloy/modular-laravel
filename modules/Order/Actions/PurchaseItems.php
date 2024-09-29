<?php

declare(strict_types=1);

namespace Modules\Order\Actions;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrder $createPaymentForOrder,
        protected Guard $guard,
        protected DatabaseManager $databaseManager
    ) {}

    public function handle(
        CartItemCollection $cartItemCollection,
        PayBuddy $payBuddy,
        string $paymentToken,
    ): Order {
        $orderTotal = $cartItemCollection->totalInCents();

        return $this->databaseManager->transaction(
            function () use ($orderTotal, $cartItemCollection, $payBuddy, $paymentToken) {
                $order = Order::query()->create([
                    'status' => 'paid',
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

                $this->createPaymentForOrder->handle(
                    $order->id,
                    $this->guard->user()?->getAuthIdentifier(),
                    $orderTotal,
                    $payBuddy,
                    $paymentToken
                );

                return $order;
            }
        );
    }
}
