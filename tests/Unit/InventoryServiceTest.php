<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\StockMovement;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected InventoryService $service;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new InventoryService();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_stock_in_product()
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);
        $warehouse = Warehouse::factory()->create();
        $quantity = 100;

        $this->service->stockIn($product->id, $warehouse->id, $quantity);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $quantity,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'type' => 'in',
            'quantity' => $quantity,
        ]);

        $this->assertEquals($quantity, $product->fresh()->stock_quantity);
    }

    /** @test */
    public function it_can_stock_out_product()
    {
        $product = Product::factory()->create(['stock_quantity' => 100]);
        $warehouse = Warehouse::factory()->create();
        Inventory::create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 100
        ]);

        $this->service->stockOut($product->id, $warehouse->id, 40);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 60,
        ]);

        $this->assertEquals(60, $product->fresh()->stock_quantity);
    }

    /** @test */
    public function it_prevents_stock_out_beyond_available_quantity()
    {
        $product = Product::factory()->create(['stock_quantity' => 50]);
        $warehouse = Warehouse::factory()->create();
        Inventory::create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => 50
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("الكمية غير كافية");

        $this->service->stockOut($product->id, $warehouse->id, 60);
    }

    /** @test */
    public function it_can_transfer_stock_between_warehouses()
    {
        $product = Product::factory()->create(['stock_quantity' => 100]);
        $warehouseA = Warehouse::factory()->create(['name' => 'Source']);
        $warehouseB = Warehouse::factory()->create(['name' => 'Destination']);

        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouseA->id, 'quantity' => 100]);
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouseB->id, 'quantity' => 0]);

        $this->service->transfer($product->id, $warehouseA->id, $warehouseB->id, 30);

        $this->assertEquals(70, Inventory::where('product_id', $product->id)->where('warehouse_id', $warehouseA->id)->first()->quantity);
        $this->assertEquals(30, Inventory::where('product_id', $product->id)->where('warehouse_id', $warehouseB->id)->first()->quantity);
        
        // Ensure total product stock remains same
        $this->assertEquals(100, $product->fresh()->stock_quantity);

        // Check movements
        $this->assertCount(2, StockMovement::all());
    }

    /** @test */
    public function it_can_adjust_stock_quantity()
    {
        $product = Product::factory()->create(['stock_quantity' => 50]);
        $warehouse = Warehouse::factory()->create();
        Inventory::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'quantity' => 50]);

        $this->service->adjustment($product->id, $warehouse->id, 80);

        $this->assertEquals(80, Inventory::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->first()->quantity);
        $this->assertEquals(80, $product->fresh()->stock_quantity);

        $this->assertDatabaseHas('stock_movements', [
            'type' => 'adjustment',
            'quantity' => 30, // 80 - 50
        ]);
    }

    /** @test */
    public function every_operation_records_a_movement()
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $this->service->stockIn($product->id, $warehouse->id, 10);
        $this->service->adjustment($product->id, $warehouse->id, 20);
        $this->service->stockOut($product->id, $warehouse->id, 5);

        $this->assertCount(3, StockMovement::all());
    }

    /** @test */
    public function it_updates_global_product_stock_quantity()
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);
        $warehouse = Warehouse::factory()->create();

        $this->service->stockIn($product->id, $warehouse->id, 50);
        $this->assertEquals(50, $product->fresh()->stock_quantity);

        $this->service->stockOut($product->id, $warehouse->id, 20);
        $this->assertEquals(30, $product->fresh()->stock_quantity);
    }
}
