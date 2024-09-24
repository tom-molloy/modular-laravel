<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\Database\Factories\OrderFactory;

/**
 * @property string $id
 * @property int $user_id
 * @property int $total_in_cents
 * @property string $status
 * @property string $payment_gateway
 * @property string $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Order\Models\OrderLine> $lines
 * @property-read User|null $user
 *
 * @method static \Modules\Order\Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<Order> newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<Order> newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<Order> query()
 *
 * @mixin \Eloquent
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'user_id',
        'payment_id',
        'status',
        'total_in_cents',
        'payment_gateway',
    ];

    public function url(): string
    {
        return "order/{$this->id}";
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<OrderLine, $this>
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    protected static function newFactory(): OrderFactory
    {
        return new OrderFactory;
    }
}
