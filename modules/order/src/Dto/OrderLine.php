<?php

namespace Modules\Order\Dto;

use Illuminate\Database\Eloquent\Collection;
use Modules\Order\Models\OrderLine as EloquentOrderLine;

readonly class OrderLine
{
    public function __construct(
        public int $productId,
        public int $productPriceInCents,
        public int $quantity
    ) {}

    public static function fromEloquentModel(EloquentOrderLine $orderLine): self
    {
        return new self($orderLine->product_id, $orderLine->product_price_in_cents, $orderLine->quantity);
    }

    /**
     * @return \Modules\Order\DTOs\OrderLineDto[]
     */
    public static function fromEloquentCollection(Collection $orderLines): array
    {
        return $orderLines->map(fn (EloquentOrderLine $orderLine) => self::fromEloquentModel($orderLine))->all();
    }
}
