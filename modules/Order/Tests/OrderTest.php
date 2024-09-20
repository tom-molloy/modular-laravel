<?php

declare(strict_types=1);

namespace Modules\Order\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Order\Models\Order;

final class OrderTest extends OrderTestCase
{
    use DatabaseMigrations;

    public function testItCreatesAnOrder(): void
    {
        $order = Order::factory()->create();

        $this->assertNotNull($order);
    }
}
