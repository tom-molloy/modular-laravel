<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Database\Factories\OrderLineFactory;
use Modules\Product\Models\Product;

/**
 * @property string $id
 * @property string $product_id
 * @property string $order_id
 * @property int $total_in_cents
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Order\Models\Order|null $order
 * @property-read Product|null $product
 *
 * @mixin \Eloquent
 */
class OrderLine extends Model
{
    /** @use HasFactory<OrderLineFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'product_id',
        'order_id',
        'total_in_cents',
        'quantity',
    ];

    protected static function newFactory(): OrderLineFactory
    {
        return new OrderLineFactory;
    }

    /**
     * @return BelongsTo<Product, self>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<Order, self>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
