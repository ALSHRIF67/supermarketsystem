<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->filled('start_date') ? $request->start_date : today()->startOfMonth();
        $endDate = $request->filled('end_date') ? $request->end_date : today()->endOfDay();

        $totalSales = Sale::whereBetween('created_at', [$startDate, $endDate])->sum('payable_amount');
        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');
        $netProfit = $totalSales - $totalExpenses;

        $dailySales = Sale::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(payable_amount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.name', 
                'products.barcode',
                DB::raw('SUM(sale_items.quantity) as sold_count'), 
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->whereBetween('sale_items.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.barcode')
            ->orderBy('sold_count', 'desc')
            ->take(10)
            ->get();

        $lowStockProducts = Product::lowStock()->get();
        
        return view('reports.index', compact('totalSales', 'totalExpenses', 'netProfit', 'dailySales', 'topProducts', 'lowStockProducts', 'startDate', 'endDate'));
    }
}
