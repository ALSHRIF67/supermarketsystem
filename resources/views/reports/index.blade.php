@extends('layouts.app')

@section('content')
<div class="space-y-10 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">التقارير والتحليلات</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                نظرة استراتيجية شاملة على الأداء المالي وحركة المخزون
            </p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                تصدير التقرير (PDF)
            </button>
        </div>
    </div>

    <!-- Financial Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Revenue Card -->
        <div class="premium-card p-8 bg-white group hover:border-emerald-200 transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">إجمالي الإيرادات</span>
                    <h3 class="text-3xl font-black text-slate-900 leading-none">${{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
            <div class="flex items-center gap-2 py-3 px-4 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
                <span class="text-xs font-black text-emerald-600">↑ 12.5%</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">نمو المبيعات الشهري</span>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="premium-card p-8 bg-white group hover:border-rose-200 transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">إجمالي المصروفات</span>
                    <h3 class="text-3xl font-black text-slate-900 leading-none">${{ number_format($totalExpenses, 2) }}</h3>
                </div>
            </div>
            <div class="flex items-center gap-2 py-3 px-4 bg-rose-50/50 rounded-xl border border-rose-100/50">
                <span class="text-xs font-black text-rose-600">↑ 5.2%</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">معدل الانفاق التشغيلي</span>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="premium-card p-8 bg-slate-900 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-white backdrop-blur-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-1">صافي الربح</span>
                        <h3 class="text-4xl font-black text-white leading-none">${{ number_format($totalSales - $totalExpenses, 2) }}</h3>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">العائد الحقيقي بعد خصم التكاليف التشغيلية</p>
            </div>
        </div>
    </div>

    <!-- Analytics Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Top Products -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-tight text-lg">المنتجات الأكثر مبيعاً</h3>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">أفضل 10 منتجات</span>
            </div>
            
            <div class="premium-table-container">
                <div class="overflow-x-auto">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-left">الإيرادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900">{{ $product->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-xl text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                        {{ (int)$product->sold_count }} وحدة
                                    </span>
                                </td>
                                <td class="text-left">
                                    <span class="text-base font-black text-emerald-600 tracking-tight">${{ number_format($product->total_revenue, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-200 shadow-sm text-rose-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 uppercase tracking-tight text-lg">تحذيرات المخزون</h3>
                </div>
                <span class="px-4 py-1.5 bg-rose-500 text-white text-[10px] font-black rounded-xl uppercase tracking-widest shadow-lg shadow-rose-200">{{ $lowStockProducts->count() }} تنبيه</span>
            </div>

            <div class="premium-table-container">
                @if($lowStockProducts->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">الرصيد</th>
                                <th class="text-center">حد الأمان</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                            <tr>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 leading-tight">{{ $product->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col items-center gap-1.5">
                                        <span class="text-sm font-black text-rose-600">{{ $product->stock_quantity }}</span>
                                        <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/50">
                                            <div class="h-full bg-rose-500" style="width: {{ ($product->stock_quantity / max(1, $product->low_stock_threshold)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="text-xs font-black text-slate-400 bg-slate-50 border border-slate-100 px-3 py-1 rounded-lg">{{ $product->low_stock_threshold }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="premium-card p-16 flex flex-col items-center justify-center text-center bg-white border-dashed border-2 border-emerald-100">
                        <div class="w-20 h-20 bg-emerald-50 rounded-[2rem] flex items-center justify-center mb-6 text-emerald-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900">المخزون سليم تماماً</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">لا توجد أصناف تحت حد الأمان في الوقت الحالي</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>@endsection
