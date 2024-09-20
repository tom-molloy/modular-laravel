<?php

declare(strict_types=1);

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Database\Factories\ProductFactory;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'name',
        'price_in_cents',
        'stock',
    ];

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory;
    }
}
