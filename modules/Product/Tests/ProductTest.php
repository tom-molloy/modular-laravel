<?php

declare(strict_types=1);

namespace Modules\Product\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Product\Models\Product;

final class ProductTest extends ProductTestCase
{
    use DatabaseMigrations;

    public function testItCreatesAProduct(): void
    {
        $product = Product::factory()->create();

        $this->assertNotNull($product);
    }
}
