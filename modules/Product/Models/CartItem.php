<?php

declare(strict_types=1);

namespace Modules\Product\Models;

use Database\Factories\CartItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /** @use HasFactory<CartItemFactory> */
    use HasFactory;
}
