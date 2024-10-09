<?php

declare(strict_types=1);

namespace Modules\Product\Events;

use Modules\Order\Events\OrderFulfilled;
use Modules\Product\Warehouse\ProductStockManager;

class DecreaseProductStock
{
    public function __construct(
        protected ProductStockManager $productStockManager,
    ) {}

    public function handle(OrderFulfilled $orderFulfilled): void
    {
        foreach ($orderFulfilled->orderDto->orderLines as $orderLine) {
            $this->productStockManager->decrement(
                $orderLine->productId,
                $orderLine->quantity
            );
        }
    }
}
