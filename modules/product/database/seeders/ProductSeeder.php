<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Modules\Product\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Umbrella', 'price_in_cents' => 1200],
                ['name' => 'Raincoat', 'price_in_cents' => 8000],
                ['name' => 'Gumboots', 'price_in_cents' => 4500],
            ))
            ->create();
    }
}
