<?php

declare(strict_types=1);

namespace Modules\Product;

readonly class CartItem
{
    public function __construct(
        public ProductDto $productDto,
        public int $quanity
    ) {}
}
