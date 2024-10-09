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
use Modules\Payment\Models\Payment;
use Modules\Product\CartItemCollection;

/**
 * @property string $id
 * @property int $user_id
 * @property int $total_in_cents
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Order\Models\OrderLine> $lines
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Payment> $payments
 * @property-read User|null $user
 *
 * @mixin \Eloquent
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    use HasUuids;

    const string PENDING = 'PENDING';

    const string COMPLETED = 'COMPLETED';

    protected $fillable = [
        'user_id',
        'status',
        'total_in_cents',
    ];

    public function url(): string
    {
        return route('order::orders.show', $this);
    }

    public function localisedTotal(): string
    {
        return strval($this->total_in_cents / 100);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<OrderLine>
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    /**
     * @return HasMany<Payment>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public static function startForUser(int $userId): self
    {
        return new self([
            'user_id' => $userId,
            'status' => self::PENDING,
        ]);
    }

    public function addLinesFromCartItems(CartItemCollection $cartItemCollection): void
    {
        foreach ($cartItemCollection->items() as $cartItem) {
            $this->lines->push(new OrderLine([
                'product_id' => $cartItem->productDto->id,
                'total_in_cents' => $cartItem->productDto->priceInCents,
                'quantity' => $cartItem->quanity,
            ]));
        }

        $this->total_in_cents = $this->lines->sum(fn (OrderLine $orderLine) => $orderLine->total_in_cents);
    }

    public function fullfill(): void
    {
        $this->status = self::COMPLETED;

        $this->save();
        $this->lines()->saveMany($this->lines);
    }

    protected static function newFactory(): OrderFactory
    {
        return new OrderFactory;
    }
}
