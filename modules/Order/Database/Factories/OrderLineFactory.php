<?php

declare(strict_types=1);

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\OrderLine;

/**
 * @extends Factory<OrderLine>
 */
class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
