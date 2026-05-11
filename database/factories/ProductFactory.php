<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'category_id' => \App\Models\Category::factory() ?? 1,
            'barcode' => $this->faker->unique()->ean13(),
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'sale_price' => $this->faker->randomFloat(2, 110, 200),
            'stock_quantity' => 0, // Starts at 0, updated via movements
            'low_stock_threshold' => 10,
            'is_active' => true,
        ];
    }
}
