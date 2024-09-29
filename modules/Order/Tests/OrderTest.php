<?php

declare(strict_types=1);

namespace Modules\Order\Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Order\Models\Order;

final class OrderTest extends OrderTestCase
{
    use DatabaseMigrations;

    public function testItCreatesAnOrder(): void
    {
        $user = User::factory()->createOne();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total_in_cents' => 1000,
            'status' => 'paid',
        ]);

        $this->assertNotNull($order);
    }
}
