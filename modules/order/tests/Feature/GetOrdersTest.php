<?php

namespace Modules\Order\Tests\Feature;

use Modules\Order\Tests\OrderTestCase;

class GetOrdersTest extends OrderTestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/orders');

        $response->assertStatus(200);

        $response->assertContent('Ok');

    }
}
