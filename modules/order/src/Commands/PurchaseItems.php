<?php

namespace Modules\Order\Commands;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Checkout\OrderStarted;
use Modules\Order\Dto\Order;
use Modules\Order\Dto\PendingPayment;
use Modules\Order\Models\Order as EloquentOrder;
use Modules\Product\Collections\CartItemCollection;

class PurchaseItems
{
    public function __construct(
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events
    ) {}

    public function handle(CartItemCollection $items, PendingPayment $pendingPayment, Authenticatable $user): Order
    {
        $order = $this->databaseManager->transaction(function () use ($user, $items): Order {
            $order = EloquentOrder::startForUser($user->id);
            $order->addLinesFromCartItems($items);
            $order->start();

            return Order::fromEloquentModel($order);
        });

        $this->events->dispatch(
            new OrderStarted($order, $user, $pendingPayment)
        );

        return $order;
    }
}
