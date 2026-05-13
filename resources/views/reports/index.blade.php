@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">التقارير والتحليلات</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                نظرة استراتيجية شاملة على الأداء المالي وحركة المخزون
            </p>
        </div>
        <div class="flex items-center gap-3 no-print">
            <button onclick="window.print()" class="h-11 px-6 bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-200 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm flex items-center gap-2 group active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                تصدير التقرير (PDF)
            </button>
        </div>
    </div>

    <!-- Financial Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Revenue Card -->
        <div class="premium-card p-6 md:p-8 bg-white group hover:border-emerald-200 transition-all border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">إجمالي الإيرادات</span>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 leading-none">{{ number_format($totalSales, 2) }} <span class="text-xs">ج.س</span></h3>
                </div>
            </div>
            <div class="flex items-center gap-2 py-2 px-3 bg-emerald-50/50 rounded-lg border border-emerald-100/50">
                <span class="text-[10px] font-black text-emerald-600">↑ 12.5%</span>
                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">نمو المبيعات الشهري</span>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="premium-card p-6 md:p-8 bg-white group hover:border-rose-200 transition-all border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">إجمالي المصروفات</span>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 leading-none">{{ number_format($totalExpenses, 2) }} <span class="text-xs">ج.س</span></h3>
                </div>
            </div>
            <div class="flex items-center gap-2 py-2 px-3 bg-rose-50/50 rounded-lg border border-rose-100/50">
                <span class="text-[10px] font-black text-rose-600">↑ 5.2%</span>
                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">معدل الانفاق التشغيلي</span>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="premium-card p-6 md:p-8 bg-slate-900 relative overflow-hidden group shadow-xl shadow-slate-900/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16 animate-pulse"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-white backdrop-blur-md border border-white/10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h2a2 2 0 002-2zM9 19h6m-6 0l6-6m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest block mb-1">صافي الربح</span>
                        <h3 class="text-3xl md:text-4xl font-black text-white leading-none tracking-tight">{{ number_format($totalSales - $totalExpenses, 2) }} <span class="text-xs">ج.س</span></h3>
                    </div>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">العائد الحقيقي بعد خصم التكاليف التشغيلية</p>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Products -->
        <div class="flex flex-col space-y-4">
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 tracking-tight text-lg">الأكثر مبيعاً</h3>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">أفضل 10 منتجات</span>
            </div>
            
            <div class="flex-1">
                <!-- Desktop Table -->
                <div class="hidden md:block premium-table-container">
                    <table class="premium-table w-full">
                        <thead>
                            <tr>
                                <th class="w-[50%]">المنتج</th>
                                <th class="w-[20%] text-center">الكمية</th>
                                <th class="w-[30%] text-left">الإيرادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr class="group">
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 group-hover:text-emerald-600 transition-colors">{{ $product->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex px-3 py-1 bg-slate-50 border border-slate-100 rounded-lg text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                        {{ (int)$product->sold_count }} وحدة
                                    </span>
                                </td>
                                <td class="text-left">
                                    <span class="text-base font-black text-emerald-600 tracking-tight">{{ number_format($product->total_revenue, 2) }}</span>
                                    <span class="text-[10px] font-black text-emerald-400">ج.س</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-3">
                    @foreach($topProducts as $product)
                    <div class="premium-card p-4 bg-white border-slate-100 flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <span class="block text-sm font-black text-slate-900 leading-tight">{{ $product->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                        </div>
                        <div class="text-left shrink-0">
                            <span class="block text-sm font-black text-emerald-600">{{ number_format($product->total_revenue, 2) }}</span>
                            <span class="text-[9px] font-black text-emerald-400 uppercase">{{ (int)$product->sold_count }} وحدة</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="flex flex-col space-y-4">
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm text-rose-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-900 tracking-tight text-lg">تحذيرات المخزون</h3>
                </div>
                <span class="px-3 py-1 bg-rose-500 text-white text-[9px] font-black rounded-lg uppercase tracking-widest shadow-lg shadow-rose-200 animate-pulse">{{ $lowStockProducts->count() }} تنبيه</span>
            </div>

            <div class="flex-1">
                @if($lowStockProducts->isNotEmpty())
                    <!-- Desktop Table -->
                    <div class="hidden md:block premium-table-container">
                        <table class="premium-table w-full">
                            <thead>
                                <tr>
                                    <th class="w-[50%]">المنتج</th>
                                    <th class="w-[30%] text-center">الرصيد الحالي</th>
                                    <th class="w-[20%] text-center">الحد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                <tr class="group">
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-900 leading-tight group-hover:text-rose-600 transition-colors">{{ $product->name }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex flex-col items-center gap-1.5">
                                            <span class="text-sm font-black text-rose-600">{{ $product->stock_quantity }}</span>
                                            <div class="w-20 h-1.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/50">
                                                <div class="h-full bg-rose-500" style="width: {{ ($product->stock_quantity / max(1, $product->low_stock_threshold)) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs font-black text-slate-500 bg-slate-50 border border-slate-100 px-3 py-1 rounded-lg">{{ $product->low_stock_threshold }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-3">
                        @foreach($lowStockProducts as $product)
                        <div class="premium-card p-4 bg-white border-slate-100">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="block text-sm font-black text-slate-900 leading-tight">{{ $product->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->barcode }}</span>
                                </div>
                                <div class="text-left">
                                    <span class="block text-sm font-black text-rose-600">{{ $product->stock_quantity }} وحدة</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">الحد: {{ $product->low_stock_threshold }}</span>
                                </div>
                            </div>
                            <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden border border-slate-100">
                                <div class="h-full bg-rose-500" style="width: {{ ($product->stock_quantity / max(1, $product->low_stock_threshold)) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="premium-card p-12 md:p-16 flex flex-col items-center justify-center text-center bg-white border-slate-100">
                        <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 text-emerald-500 border border-emerald-100">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 italic">المخزون سليم تماماً</h4>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-2">لا توجد أصناف تحت حد الأمان في الوقت الحالي</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
