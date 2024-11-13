<?php

namespace Modules\Order\Dto;

use Modules\Order\Models\Order as EloquentOrder;

readonly class Order
{
    /**
     * @param  OrderLine[]  $lines
     */
    public function __construct(
        public int $id,
        public int $totalInCents,
        public string $localizedTotal,
        public string $url,
        public array $lines
    ) {}

    public static function fromEloquentModel(EloquentOrder $order): self
    {
        return new self(
            $order->id,
            $order->total_in_cents,
            $order->localizedTotal(),
            $order->url(),
            OrderLine::fromEloquentCollection($order->lines)
        );
    }
}
