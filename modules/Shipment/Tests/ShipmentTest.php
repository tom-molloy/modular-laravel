<?php

declare(strict_types=1);

namespace Modules\Shipment\Tests;

use Modules\Shipment\Models\Shipment;

final class ShipmentTest extends ShipmentTestCase
{
    public function testItCreatesAnOrder(): void
    {
        new Shipment;

        $this->assertTrue(true);
    }
}
