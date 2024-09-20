<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Database\Factories\OrderFactory;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    use HasUuids;

    protected static function newFactory(): OrderFactory
    {
        return new OrderFactory;
    }
}
