<?php

namespace Modules\Product\Dto;

readonly class CartItem
{
    public function __construct(
        public Product $product,
        public int $quantity
    ) {}
}
