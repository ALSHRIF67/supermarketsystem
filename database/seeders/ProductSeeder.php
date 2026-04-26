<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fruits = Category::create(['name' => 'Fruits', 'description' => 'Fresh fruits']);
        $dairy = Category::create(['name' => 'Dairy', 'description' => 'Milk and cheese']);
        $bakery = Category::create(['name' => 'Bakery', 'description' => 'Bread and pastries']);

        Product::create([
            'category_id' => $fruits->id,
            'name' => 'Apple',
            'slug' => 'apple',
            'barcode' => '1234567890',
            'purchase_price' => 0.5,
            'sale_price' => 1.0,
            'stock_quantity' => 100,
            'low_stock_threshold' => 10,
        ]);

        Product::create([
            'category_id' => $dairy->id,
            'name' => 'Milk 1L',
            'slug' => 'milk-1l',
            'barcode' => '0987654321',
            'purchase_price' => 0.8,
            'sale_price' => 1.5,
            'stock_quantity' => 50,
            'low_stock_threshold' => 5,
            'expiry_date' => now()->addMonths(2),
        ]);

        Product::create([
            'category_id' => $bakery->id,
            'name' => 'Croissant',
            'slug' => 'croissant',
            'barcode' => '1122334455',
            'purchase_price' => 0.4,
            'sale_price' => 1.2,
            'stock_quantity' => 30,
            'low_stock_threshold' => 10,
        ]);
    }
}
