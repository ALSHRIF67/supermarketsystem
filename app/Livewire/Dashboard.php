<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Supplier;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalSales' => Sale::whereDate('created_at', today())->sum('payable_amount'),
            'totalOrders' => Sale::whereDate('created_at', today())->count(),
            'lowStockCount' => Product::lowStock()->count(),
            'expiringSoonCount' => Product::expiringSoon()->count(),
            'topProducts' => Product::withCount('category')->orderBy('stock_quantity', 'desc')->take(5)->get(), // Placeholder logic
        ])->layout('layouts.app');
    }
}
