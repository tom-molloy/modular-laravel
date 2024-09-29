<?php

declare(strict_types=1);

namespace Modules\Payment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;
use Modules\Payment\Database\Factories\PaymentFactory;

/**
 * @property string $id
 * @property int $total_in_cents
 * @property string $status
 * @property string $payment_gateway
 * @property string $payment_id
 * @property int $user_id
 * @property string $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Order|null $order
 * @property-read User|null $user
 *
 * @mixin \Eloquent
 */
class Payment extends Model
{
    protected $fillable = [
        'total_in_cents',
        'status',
        'payment_gateway',
        'payment_id',
        'user_id',
        'order_id',
    ];

    /**
     * @use HasFactory<PaymentFactory>
     */
    use HasFactory;

    use HasUuids;

    /**
     * @return BelongsTo<User,$this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Order,$this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
