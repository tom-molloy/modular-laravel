<?php

namespace Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Order\Tests\OrderTestCase;

class GetOrdersTest extends OrderTestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/orders');

        $response->assertStatus(200);

        $response->assertViewIs('order::index');
    }
}
