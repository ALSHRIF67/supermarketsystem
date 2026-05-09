@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">التقارير والتحليلات</h2>
            <p class="text-sm text-slate-500">نظرة شاملة على الأداء المالي للسوبر ماركت</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors no-print">
                تصدير PDF
            </button>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">إجمالي الإيرادات</p>
            <h3 class="text-2xl font-bold text-slate-900">${{ number_format($totalSales, 2) }}</h3>
            <div class="mt-4 flex items-center gap-1 text-xs text-emerald-600 font-bold">
                <span>↑ 12%</span>
                <span class="text-slate-400 font-medium">مقارنة بالشهر الماضي</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">إجمالي المصروفات</p>
            <h3 class="text-2xl font-bold text-slate-900">${{ number_format($totalExpenses, 2) }}</h3>
            <div class="mt-4 flex items-center gap-1 text-xs text-rose-600 font-bold">
                <span>↑ 5%</span>
                <span class="text-slate-400 font-medium">مقارنة بالشهر الماضي</span>
            </div>
        </div>

        <div class="bg-indigo-600 p-6 rounded-3xl shadow-lg shadow-indigo-100 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 text-white rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <p class="text-sm font-medium text-indigo-100 mb-1">صافي الربح</p>
            <h3 class="text-3xl font-black">${{ number_format($totalSales - $totalExpenses, 2) }}</h3>
            <p class="mt-4 text-xs text-indigo-200">إجمالي الأرباح بعد خصم المصروفات</p>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Selling Products -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-900">الأكثر مبيعاً</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">المنتج</th>
                            <th class="px-6 py-4 font-bold text-center">الكمية</th>
                            <th class="px-6 py-4 font-bold text-left">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($topProducts as $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-slate-600">{{ (int)$product->sold_count }}</td>
                            <td class="px-6 py-4 text-left text-sm font-bold text-indigo-600">${{ number_format($product->sold_count * $product->sale_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alert List -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">تنبيهات المخزون المنخفض</h3>
                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-xs font-bold rounded-lg">{{ $lowStockProducts->count() }} منتج</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">المنتج</th>
                            <th class="px-6 py-4 font-bold text-center">المتوفر</th>
                            <th class="px-6 py-4 font-bold text-center">الحد</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($lowStockProducts as $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-rose-600">{{ $product->stock_quantity }}</td>
                            <td class="px-6 py-4 text-center text-sm text-slate-400">{{ $product->low_stock_threshold }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
