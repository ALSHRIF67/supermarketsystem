<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stats Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Today's Sales</p>
                    <h3 class="text-2xl font-bold text-slate-900">${{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-medium text-emerald-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>12% from yesterday</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Today's Orders</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-xs font-medium text-blue-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>5 new customers</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Low Stock</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $lowStockCount }}</h3>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-amber-600">
                <a href="#" class="hover:underline">View details</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Expiring Soon</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $expiringSoonCount }}</h3>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-rose-600">
                <a href="#" class="hover:underline">View alerts</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Chart Placeholder -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Sales Overview</h3>
                <select class="bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-indigo-500">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                </select>
            </div>
            <div class="h-64 bg-slate-50 rounded-xl flex items-center justify-center border border-dashed border-slate-300">
                <p class="text-slate-400 font-medium italic">Sales Chart Visualization</p>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-6">Top Selling</h3>
            <div class="space-y-6">
                @forelse($topProducts as $product)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex-shrink-0"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-900">{{ $product->name }}</p>
                        <p class="text-xs text-slate-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-900">${{ number_format($product->sale_price, 2) }}</p>
                        <p class="text-xs text-emerald-600 font-medium">In Stock</p>
                    </div>
                </div>
                @empty
                <p class="text-slate-400 text-sm text-center py-8 italic">No products found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
