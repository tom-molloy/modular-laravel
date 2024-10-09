<?php

declare(strict_types=1);

namespace Modules\Order;

use Modules\Order\Models\Order;

readonly class OrderDto
{
    /**
     * @param  OrderLineDto[]  $orderLines
     */
    public function __construct(
        public string $id,
        public int $totalInCents,
        public string $localisedTotal,
        public string $url,
        public array $orderLines
    ) {}

    public static function fromEloquentModel(Order $order): self
    {
        return new self(
            $order->id,
            $order->total_in_cents,
            $order->localisedTotal(),
            $order->url(),
            OrderLineDto::fromEloquentCollection($order->lines)
        );
    }
}
