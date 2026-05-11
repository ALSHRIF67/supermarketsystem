<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function test_it_can_stock_in_via_api()
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $data = [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 50,
            'reference' => 'IN-123',
            'notes' => 'Initial stock'
        ];

        $response = $this->postJson('/api/inventory/stock-in', $data);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'تم توريد المخزون بنجاح']);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 50,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'type' => 'in',
            'quantity' => 50,
        ]);
    }

    /** @test */
    public function test_it_can_stock_out_via_api()
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'quantity' => 100]);

        $data = [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 30,
        ];

        $response = $this->postJson('/api/inventory/stock-out', $data);

        $response->assertStatus(200);
        $this->assertEquals(70, Inventory::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->first()->quantity);
    }

    /** @test */
    public function test_it_fails_stock_out_if_quantity_is_insufficient()
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'quantity' => 10]);

        $data = [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 20,
        ];

        $response = $this->postJson('/api/inventory/stock-out', $data);

        $response->assertStatus(400)
                 ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_transfer_stock_via_api()
    {
        $product = Product::factory()->create();
        $warehouseA = Warehouse::factory()->create();
        $warehouseB = Warehouse::factory()->create();
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouseA->id, 'quantity' => 100]);

        $data = [
            'product_id' => $product->id,
            'from_warehouse_id' => $warehouseA->id,
            'to_warehouse_id' => $warehouseB->id,
            'quantity' => 40,
        ];

        $response = $this->postJson('/api/inventory/transfer', $data);

        $response->assertStatus(200);
        $this->assertEquals(60, Inventory::where('product_id', $product->id)->where('warehouse_id' , $warehouseA->id)->first()->quantity);
        $this->assertEquals(40, Inventory::where('product_id', $product->id)->where('warehouse_id' , $warehouseB->id)->first()->quantity);
    }

    /** @test */
    public function test_it_can_adjust_stock_via_api()
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'quantity' => 50]);

        $data = [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 75,
        ];

        $response = $this->postJson('/api/inventory/adjustment', $data);

        $response->assertStatus(200);
        $this->assertEquals(75, Inventory::where('product_id', $product->id)->where('warehouse_id' , $warehouse->id)->first()->quantity);
    }
}
