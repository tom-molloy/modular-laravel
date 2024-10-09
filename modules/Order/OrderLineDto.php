<?php

declare(strict_types=1);

namespace Modules\Order;

use Illuminate\Database\Eloquent\Collection;
use Modules\Order\Models\OrderLine;

readonly class OrderLineDto
{
    public function __construct(
        public string $productId,
        public int $productPriceInCents,
        public int $quantity
    ) {}

    public static function fromEloquentModel(OrderLine $orderLine): self
    {
        return new self(
            $orderLine->product_id,
            $orderLine->total_in_cents,
            $orderLine->quantity
        );
    }

    /**
     * @param  Collection<array-key,OrderLine>  $orderLines
     * @return OrderLineDto[]
     */
    public static function fromEloquentCollection(Collection $orderLines): array
    {
        return $orderLines->map(fn (OrderLine $orderLine): \Modules\Order\OrderLineDto => self::fromEloquentModel($orderLine))->all();
    }
}
