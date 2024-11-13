<?php

namespace Modules\Product\Collections;

use Illuminate\Support\Collection;
use Modules\Product\Dto\CartItem;
use Modules\Product\Dto\Product;
use Modules\Product\Models\Product as EloquentProduct;

class CartItemCollection
{
    /**
     * @param  \Illuminate\Support\Collection<CartItem>  $items
     */
    public function __construct(
        protected Collection $items
    ) {}

    public static function fromCheckoutData(array $data): CartItemCollection
    {

        $cartItems = collect($data)->map(function (int $quantity, string $id) {
            return new CartItem(
                Product::fromEloquentModel(EloquentProduct::find($id)),
                $quantity
            );
        });

        return new self($cartItems);
    }

    public static function fromProduct(Product $product, int $quantity = 1): CartItemCollection
    {
        return new self(collect([
            new CartItem($product, $quantity),
        ]));
    }

    public function totalInCents(): int
    {
        return $this->items->sum(fn (CartItem $cartItem) => $cartItem->quantity * $cartItem->product->priceInCents);
    }

    /**
     * @return \Illuminate\Support\Collection<CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
