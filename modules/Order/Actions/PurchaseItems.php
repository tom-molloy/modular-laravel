<?php

declare(strict_types=1);

namespace Modules\Order\Actions;

use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderFulfilled;
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
        protected DatabaseManager $databaseManager,
        protected Dispatcher $dispatcher
    ) {}

    public function handle(
        CartItemCollection $cartItemCollection,
        PayBuddy $payBuddy,
        string $paymentToken,
    ): Order {
        /** @var User $user */
        $user = $this->guard->user();
        $orderTotal = $cartItemCollection->totalInCents();

        $order = $this->databaseManager->transaction(
            function () use ($orderTotal, $cartItemCollection, $payBuddy, $paymentToken, $user): Order {

                $order = Order::startForUser($user->id);
                $order->addLinesFromCartItems($cartItemCollection);
                $order->fullfill();

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

        $this->dispatcher->dispatch(
            new OrderFulfilled(
                $order->id,
                $order->total_in_cents,
                $order->localisedTotal(),
                $cartItemCollection,
                $user->id,
                $user->email
            )
        );

        return $order;
    }
}
