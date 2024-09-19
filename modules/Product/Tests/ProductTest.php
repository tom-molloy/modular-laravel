<?php

declare(strict_types=1);

namespace Modules\Product\Tests;

use Illuminate\Foundation\Testing\TestCase;
use Modules\Product\Models\Product;

final class ProductTest extends TestCase
{
    public function testItCreatesAnOrder(): void
    {
        new Product;

        $this->assertTrue(true);
    }
}
