<?php

declare(strict_types=1);

namespace Modules\Shipment\Models;

use Database\Factories\ShipmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /** @use HasFactory<ShipmentFactory> */
    use HasFactory;
}
