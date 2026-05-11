<?php

namespace Database\Factories;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'warehouse_id' => \App\Models\Warehouse::factory(),
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['in', 'out', 'transfer_in', 'transfer_out', 'adjustment']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'balance_after' => $this->faker->numberBetween(100, 1000),
            'reference' => 'REF-' . $this->faker->unique()->numberBetween(1000, 9999),
        ];
    }
}
