<?php

namespace Modules\Order\Models;

use Database\Factories\OrderLineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /** @use HasFactory<OrderLineFactory> */
    use HasFactory;
}
