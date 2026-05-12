<div class="flex flex-col gap-10 animate-slide-up" wire:poll.30s>
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">أهلاً بك، {{ auth()->user()->name }} 👋</h2>
            <p class="text-slate-500 font-medium">إليك ملخص شامل لأداء السوبر ماركت لهذا اليوم.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-2xl shadow-sm text-slate-600">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-sm font-bold">{{ now()->translatedFormat('l، d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Sales -->
        <div class="premium-card p-6 overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">إجمالي المبيعات اليوم</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-slate-900">{{ number_format($totalSales, 2) }}</h3>
                    <span class="text-xs font-bold text-slate-500 uppercase">ج.س</span>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="premium-card p-6 overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">عدد الطلبات</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $totalOrders }}</h3>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="premium-card p-6 overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-200 mb-5 {{ $lowStockCount > 0 ? 'animate-pulse' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">نواقص المخزون</p>
                <h3 class="text-3xl font-black {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $lowStockCount }}</h3>
            </div>
        </div>

        <!-- Expiring -->
        <div class="premium-card p-6 overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">منتجات تنتهي قريباً</p>
                <h3 class="text-3xl font-black {{ $expiringSoonCount > 0 ? 'text-amber-600' : 'text-slate-900' }}">{{ $expiringSoonCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Tables & Insights Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Top Products Table -->
        <div class="lg:col-span-2 premium-card overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-black text-slate-900 text-lg">المنتجات الأكثر مبيعاً</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">أفضل 5 منتجات مبيعاً لهذا الشهر</p>
                </div>
                <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm">تقارير كاملة</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right modern-table">
                    <thead>
                        <tr>
                            <th class="px-8 py-4">المنتج</th>
                            <th class="px-8 py-4 text-center">القسم</th>
                            <th class="px-8 py-4 text-center">الكمية المباعة</th>
                            <th class="px-8 py-4 text-left">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($topProducts as $product)
                        <tr class="group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $product->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: {{ $product->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider rounded-lg">{{ $product->category->name }}</span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-sm font-black text-slate-900 bg-slate-50 px-3 py-1 rounded-full">{{ (int)$product->sold_count }}</span>
                            </td>
                            <td class="px-8 py-5 text-left">
                                <p class="text-sm font-black text-emerald-600">{{ number_format($product->sold_count * $product->sale_price, 2) }}</p>
                                <p class="text-[10px] text-slate-400 font-bold">ج.س</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Insights -->
        <div class="flex flex-col gap-6">
            <div class="premium-card p-8 bg-slate-900 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:rotate-12 transition-transform duration-700">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        نصيحة ذكية
                    </div>
                    <h3 class="text-2xl font-black mb-4 leading-tight">حسّن مبيعاتك اليوم!</h3>
                    <p class="text-slate-400 font-medium text-sm leading-relaxed mb-8">
                        تأكد من مراجعة نواقص المخزون بانتظام لتجنب انقطاع المنتجات الأساسية. التقارير تشير إلى زيادة الطلب على قسم الألبان في عطلة نهاية الأسبوع.
                    </p>
                    <button class="w-full py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-black rounded-2xl transition-all shadow-xl shadow-emerald-900/50 flex items-center justify-center gap-2 group">
                        تحليل المخزون
                        <svg class="w-4 h-4 group-hover:translate-x-[-4px] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </button>
                </div>
            </div>

            <div class="premium-card p-6 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">حالة النظام</p>
                    <p class="text-sm font-black text-slate-900">آمن ومستقر</p>
                </div>
            </div>
        </div>
    </div>
</div>
