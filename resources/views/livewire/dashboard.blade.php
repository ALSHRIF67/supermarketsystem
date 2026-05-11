<div class="flex flex-col gap-8" wire:poll.30s>
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">أهلاً بك، {{ auth()->user()->name }} 👋</h2>
            <p class="text-slate-500">إليك ملخص أداء السوبر ماركت لهذا اليوم</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-600 shadow-sm">
                {{ now()->format('Y-m-d') }}
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">اليوم</span>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">إجمالي المبيعات</p>
            <h3 class="text-2xl font-bold text-slate-900">${{ number_format($totalSales, 2) }}</h3>
        </div>

        <!-- Orders -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">طلب</span>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">عدد الطلبات</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</h3>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-lg">تنبيه</span>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">نواقص المخزون</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $lowStockCount }}</h3>
        </div>

        <!-- Expiring -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">قريباً</span>
            </div>
            <p class="text-sm font-medium text-slate-500 mb-1">منتجات قاربت الانتهاء</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $expiringSoonCount }}</h3>
        </div>
    </div>

    <!-- Charts / Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Top Products -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">المنتجات الأكثر مبيعاً</h3>
                <a href="{{ route('reports.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">المنتج</th>
                            <th class="px-6 py-4 font-bold text-center">القسم</th>
                            <th class="px-6 py-4 font-bold text-center">الكمية المباعة</th>
                            <th class="px-6 py-4 font-bold text-left">الإيرادات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($topProducts as $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-900">{{ $product->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">{{ $product->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-slate-900">{{ (int)$product->sold_count }}</td>
                            <td class="px-6 py-4 text-left text-sm font-bold text-indigo-600">${{ number_format($product->sold_count * $product->sale_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity Placeholder -->
        <div class="bg-slate-900 rounded-3xl p-8 text-white">
            <h3 class="text-lg font-bold mb-6">نصيحة اليوم 💡</h3>
            <p class="text-slate-400 leading-relaxed mb-8">
                تأكد من مراجعة نواقص المخزون بانتظام لتجنب انقطاع المنتجات الأساسية. التقارير تشير إلى زيادة الطلب على قسم الألبان في عطلة نهاية الأسبوع.
            </p>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                    <div class="w-10 h-10 bg-indigo-500/20 text-indigo-400 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">تحديث المخزون</p>
                        <p class="text-xs text-slate-500">تم تحديث 12 منتجاً بنجاح</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
