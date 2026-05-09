<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
        }

        if ($request->status == 'low_stock') {
            $query->lowStock();
        }

        $products = $query->latest()->paginate(10);

        return view('inventory.index', compact('products'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|in:add,set',
        ]);

        if ($request->type == 'add') {
            $product->increment('stock_quantity', $request->quantity);
        } else {
            $product->update(['stock_quantity' => $request->quantity]);
        }

        return back()->with('success', 'Stock updated successfully.');
    }
}
