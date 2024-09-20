<?php

declare(strict_types=1);

namespace Modules\Shipment\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Shipment\Models\Shipment;

final class ShipmentTest extends ShipmentTestCase
{
    use DatabaseMigrations;

    public function testItCreatesAShipment(): void
    {
        $shipment = Shipment::factory()->create();

        $this->assertNotNull($shipment);
    }
}
