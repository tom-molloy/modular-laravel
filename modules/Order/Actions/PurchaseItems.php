<?php

declare(strict_types=1);

namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Models\Order;
use Modules\Order\OrderDto;
use Modules\Order\PendingPayment;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\User\UserDto;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreatePaymentForOrder $createPaymentForOrder,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $dispatcher
    ) {}

    public function handle(
        CartItemCollection $cartItemCollection,
        PendingPayment $pendingPayment,
        UserDto $userDto
    ): OrderDto {
        $orderTotal = $cartItemCollection->totalInCents();

        $order = $this->databaseManager->transaction(
            function () use ($orderTotal, $cartItemCollection, $pendingPayment, $userDto): OrderDto {

                $order = Order::startForUser($userDto->id);
                $order->addLinesFromCartItems($cartItemCollection);
                $order->fullfill();

                $this->createPaymentForOrder->handle(
                    $order->id,
                    $userDto->id,
                    $orderTotal,
                    $pendingPayment->paymentGateway,
                    $pendingPayment->paymentToken
                );

                return OrderDto::fromEloquentModel($order);
            }
        );

        $this->dispatcher->dispatch(
            new OrderFulfilled(
                $order,
                $userDto
            )
        );

        return $order;
    }
}
