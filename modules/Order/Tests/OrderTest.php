<?php

declare(strict_types=1);

namespace Modules\Order\Tests;

use Modules\Order\Models\Order;

final class OrderTest extends OrderTestCase
{
    public function testItCreatesAnOrder(): void
    {
        new Order;

        $this->assertTrue(true);
    }
}
