<?php

declare(strict_types=1);

namespace Modules\Product;

use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

readonly class CartItemCollection
{
    /**
     * @param  Collection<array-key,CartItem>  $items
     */
    public function __construct(
        public Collection $items,
    ) {}

    /**
     * @param  array<array-key,array<string,string|int>>  $data
     */
    public static function fromCheckoutData(array $data): CartItemCollection
    {
        $cartItems = collect($data)->map(fn (array $product): \Modules\Product\CartItem => new CartItem(
            ProductDto::fromEloquentModel(Product::query()->findOrFail((string) $product['id'])),
            (int) $product['quantity']
        ));

        return new self($cartItems);
    }

    public function totalInCents(): int
    {
        return $this->items->sum(
            fn (CartItem $cartItem): int => $cartItem->productDto->priceInCents * $cartItem->quanity
        );
    }

    /**
     * @return Collection<array-key,CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
