<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalSales' => Sale::whereDate('created_at', today())->sum('payable_amount'),
            'totalOrders' => Sale::whereDate('created_at', today())->count(),
            'lowStockCount' => Product::lowStock()->count(),
            'expiringSoonCount' => Product::expiringSoon()->count(),
            'topProducts' => Product::with('category')
                ->withCount(['saleItems as sold_count' => function($query) {
                    $query->select(DB::raw('sum(quantity)'));
                }])
                ->orderBy('sold_count', 'desc')
                ->take(5)
                ->get(),
        ])->layout('layouts.app');
    }
}
