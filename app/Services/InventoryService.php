<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Stock In: Add quantity to a warehouse
     */
    public function stockIn($productId, $warehouseId, $quantity, $reference = null, $notes = null)
    {
        if ($quantity <= 0) {
            throw new Exception("الكمية يجب أن تكون أكبر من الصفر.");
        }

        return DB::transaction(function () use ($productId, $warehouseId, $quantity, $reference, $notes) {
            $inventory = Inventory::firstOrCreate(
                ['product_id' => $productId, 'warehouse_id' => $warehouseId],
                ['quantity' => 0]
            );

            $inventory->increment('quantity', $quantity);

            // Update global product stock for convenience (optional based on architecture)
            $product = Product::find($productId);
            $product->increment('stock_quantity', $quantity);

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'user_id' => auth()->id(),
                'type' => 'in',
                'quantity' => $quantity,
                'balance_after' => $inventory->quantity,
                'reference' => $reference,
                'notes' => $notes,
            ]);
        });
    }

    /**
     * Stock Out: Deduct quantity from a warehouse
     */
    public function stockOut($productId, $warehouseId, $quantity, $reference = null, $notes = null)
    {
        if ($quantity <= 0) {
            throw new Exception("الكمية يجب أن تكون أكبر من الصفر.");
        }

        return DB::transaction(function () use ($productId, $warehouseId, $quantity, $reference, $notes) {
            $inventory = Inventory::where('product_id', $productId)
                ->where('warehouse_id', $warehouseId)
                ->first();

            if (!$inventory || $inventory->quantity < $quantity) {
                throw new Exception("الكمية غير كافية في المخزن المحدد.");
            }

            $inventory->decrement('quantity', $quantity);

            // Update global product stock
            $product = Product::find($productId);
            $product->decrement('stock_quantity', $quantity);

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'user_id' => auth()->id(),
                'type' => 'out',
                'quantity' => -$quantity,
                'balance_after' => $inventory->quantity,
                'reference' => $reference,
                'notes' => $notes,
            ]);
        });
    }

    /**
     * Transfer between warehouses
     */
    public function transfer($productId, $fromWarehouseId, $toWarehouseId, $quantity, $reference = null)
    {
        return DB::transaction(function () use ($productId, $fromWarehouseId, $toWarehouseId, $quantity, $reference) {
            $this->stockOut($productId, $fromWarehouseId, $quantity, $reference, "تحويل إلى مخزن ID: $toWarehouseId");
            $this->stockIn($productId, $toWarehouseId, $quantity, $reference, "تحويل من مخزن ID: $fromWarehouseId");
            
            // Note: In transfer, global stock_quantity doesn't change because stockOut decrements and stockIn increments it.
        });
    }

    /**
     * Adjustment: Set quantity manually
     */
    public function adjustment($productId, $warehouseId, $newQuantity, $reference = null, $notes = null)
    {
        return DB::transaction(function () use ($productId, $warehouseId, $newQuantity, $reference, $notes) {
            $inventory = Inventory::firstOrCreate(
                ['product_id' => $productId, 'warehouse_id' => $warehouseId],
                ['quantity' => 0]
            );

            $oldQuantity = $inventory->quantity;
            $diff = $newQuantity - $oldQuantity;
            
            $inventory->update(['quantity' => $newQuantity]);

            // Update global product stock
            $product = Product::find($productId);
            $product->increment('stock_quantity', $diff);

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => $diff,
                'balance_after' => $newQuantity,
                'reference' => $reference,
                'notes' => $notes,
            ]);
        });
    }
}
