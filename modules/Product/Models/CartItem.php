<?php

declare(strict_types=1);

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Database\Factories\CartItemFactory;

/**
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Modules\Product\Database\Factories\CartItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 *
 * @mixin \Eloquent
 */
class CartItem extends Model
{
    /** @use HasFactory<CartItemFactory> */
    use HasFactory;

    use HasUuids;

    protected static function newFactory(): CartItemFactory
    {
        return new CartItemFactory;
    }
}
