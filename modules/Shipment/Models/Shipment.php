<?php

declare(strict_types=1);

namespace Modules\Shipment\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Database\Factories\ShipmentFactory;

class Shipment extends Model
{
    /** @use HasFactory<ShipmentFactory> */
    use HasFactory;

    use HasUuids;

    protected static function newFactory(): ShipmentFactory
    {
        return new ShipmentFactory;
    }
}
