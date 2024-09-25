<?php

declare(strict_types=1);

namespace Modules\Product\Warehouse;

use Modules\Product\Models\Product;

readonly class ProductStockManager
{
    public function decrement(string $productId, int $amount): void
    {
        Product::query()->find($productId)?->decrement('stock', $amount);
    }
}
