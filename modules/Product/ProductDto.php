<?php

declare(strict_types=1);

namespace Modules\Product;

use Modules\Product\Models\Product;

readonly class ProductDto
{
    public function __construct(
        public string $id,
        public int $priceInCents,
        public int $unitsInStock
    ) {}

    public static function fromEloquentModel(Product $product): ProductDto
    {
        return new ProductDto(
            id: $product->id,
            priceInCents: $product->price_in_cents,
            unitsInStock: $product->stock
        );
    }
}
