<?php

declare(strict_types=1);

namespace Modules\Order\Events;

use Modules\Product\CartItemCollection;

class OrderFulfilled
{
    public function __construct(
        public string $orderId,
        public int $totalInCents,
        public string $localisedTotal,
        public CartItemCollection $cartItemCollection,
        public int $userId,
        public string $userEmail
    ) {}
}
