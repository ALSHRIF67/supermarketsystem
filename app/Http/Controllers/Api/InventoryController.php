<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use Exception;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function stockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->inventoryService->stockIn(
                $request->product_id,
                $request->warehouse_id,
                $request->quantity,
                $request->reference,
                $request->notes
            );
            return response()->json(['message' => 'تم توريد المخزون بنجاح']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function stockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->inventoryService->stockOut(
                $request->product_id,
                $request->warehouse_id,
                $request->quantity,
                $request->reference,
                $request->notes
            );
            return response()->json(['message' => 'تم صرف المخزون بنجاح']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
        ]);

        try {
            $this->inventoryService->transfer(
                $request->product_id,
                $request->from_warehouse_id,
                $request->to_warehouse_id,
                $request->quantity,
                $request->reference
            );
            return response()->json(['message' => 'تم التحويل بنجاح']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function adjustment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->inventoryService->adjustment(
                $request->product_id,
                $request->warehouse_id,
                $request->quantity,
                $request->reference,
                $request->notes
            );
            return response()->json(['message' => 'تم الجرد بنجاح']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
