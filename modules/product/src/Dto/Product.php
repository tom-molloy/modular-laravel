<?php

namespace Modules\Product\Dto;

use Modules\Product\Models\Product as EloquentProduct;

readonly class Product
{
    public function __construct(
        public string $id,
        public int $priceInCents,
        public int $unitsInStock
    ) {}

    public static function fromEloquentModel(EloquentProduct $product): Product
    {
        return new Product(
            id: $product->id,
            priceInCents: $product->price_in_cents,
            unitsInStock: $product->stock
        );
    }
}
