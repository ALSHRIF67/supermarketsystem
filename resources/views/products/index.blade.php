@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">إدارة المنتجات</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                تتبع المخزون والأسعار والأقسام في مكان واحد
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('products.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black text-sm">إضافة منتج جديد</span>
            </a>
        </div>
    </div>

    <!-- Filters & Stats Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Search & Filter Card -->
        <div class="lg:col-span-3 premium-card p-6 border-slate-100">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">البحث السريع</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم المنتج، الباركود..." 
                            class="w-full pr-11 pl-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                    </div>
                </div>

                <div class="w-full md:w-64 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">القسم</label>
                    <select name="category" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none cursor-pointer">
                        <option value="">جميع الأقسام</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="h-[52px] px-8 bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/10">
                        تصفية
                    </button>
                    @if(request()->anyFilled(['search', 'category']))
                        <a href="{{ route('products.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                            مسح
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Quick Info Card -->
        <div class="premium-card p-6 bg-slate-900 text-white border-none shadow-xl shadow-slate-900/20">
            <div class="flex items-center justify-between gap-4 h-full">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">إجمالي المنتجات</p>
                    <h4 class="text-3xl font-black tracking-tight text-white">{{ $products->total() }}</h4>
                </div>
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            @php
                $lowStockCount = $products->filter(function($p) { return ($p->stock_quantity ?? 0) <= ($p->low_stock_threshold ?? 5); })->count();
            @endphp
            @if($lowStockCount > 0)
            <div class="mt-3 pt-3 border-t border-white/10 text-[9px] font-black uppercase tracking-wider text-rose-400 animate-pulse">
                🚨 {{ $lowStockCount }} منتج منخفض المخزون
            </div>
            @endif
        </div>
    </div>

    <!-- Products List Area -->
    <div class="flex-1">
        <!-- Desktop Table View -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[20%] text-right">المنتج / SKU</th>
                        <th class="w-[10%] text-center">القسم</th>
                        <th class="w-[12%] text-center">الباركود</th>
                        <th class="w-[9%] text-center">التكلفة</th>
                        <th class="w-[9%] text-center">سعر البيع</th>
                        <th class="w-[9%] text-center">الربح</th>
                        <th class="w-[8%] text-center">المخزون</th>
                        <th class="w-[11%] text-center">الحالة</th>
                        <th class="w-[12%] text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    @php
                        $cost = $product->purchase_price ?? 0;
                        $price = $product->sale_price ?? 0;
                        $profit = $price - $cost;
                        $profitMargin = $price > 0 ? round(($profit / $price) * 100, 1) : 0;
                        $stock = $product->stock_quantity ?? 0;
                        $threshold = $product->low_stock_threshold ?? 5;
                        
                        if ($stock <= 0) {
                            $stockStatus = ['label' => 'نفد', 'class' => 'bg-rose-50 text-rose-600 border-rose-100'];
                        } elseif ($stock <= $threshold) {
                            $stockStatus = ['label' => 'منخفض', 'class' => 'bg-amber-50 text-amber-600 border-amber-100'];
                        } else {
                            $stockStatus = ['label' => 'متوفر', 'class' => 'bg-emerald-50 text-emerald-600 border-emerald-100'];
                        }
                    @endphp
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $product->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">SKU: #PRO-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-wide whitespace-nowrap">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-[10px] font-black text-slate-500 tracking-tight font-mono">
                                {{ $product->barcode ?: '────────' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-black text-slate-500 tracking-tight">{{ number_format($cost, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-base font-black text-emerald-600 tracking-tight">{{ number_format($price, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xs font-black {{ $profit > 0 ? 'text-indigo-600' : 'text-rose-600' }}">{{ number_format($profit, 2) }}</span>
                                <span class="text-[9px] font-bold text-slate-400">{{ $profitMargin }}%</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-base font-black {{ $stock <= $threshold ? 'text-rose-600' : 'text-slate-900' }}">
                                {{ $stock }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="px-3 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest whitespace-nowrap {{ $stockStatus['class'] }}">
                                {{ $stockStatus['label'] }}
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button onclick="confirmDelete({{ $product->id }})" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد منتجات مسجلة</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">أضف منتجك الأول الآن</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            @forelse($products as $product)
            @php
                $stock = $product->stock_quantity ?? 0;
                $threshold = $product->low_stock_threshold ?? 5;
                if ($stock <= 0) $s_class = 'text-rose-600 bg-rose-50';
                elseif ($stock <= $threshold) $s_class = 'text-amber-600 bg-amber-50';
                else $s_class = 'text-emerald-600 bg-emerald-50';
            @endphp
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $product->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#PRO-{{ $product->id }}</span>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-lg border text-[9px] font-black uppercase {{ $s_class }}">
                        {{ $product->stock_quantity ?? 0 }} وحدة
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 py-3 border-y border-slate-50">
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">سعر البيع</span>
                        <span class="text-sm font-black text-emerald-600 tracking-tight">{{ number_format($product->sale_price, 2) }} <span class="text-[9px]">ج.س</span></span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">القسم</span>
                        <span class="text-xs font-bold text-slate-700">{{ $product->category->name }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="flex-1 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        تعديل
                    </a>
                    <button onclick="confirmDelete({{ $product->id }})" class="flex-1 h-11 flex items-center justify-center bg-white border border-rose-100 text-rose-500 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        حذف
                    </button>
                </div>
            </div>
            @empty
            <div class="premium-card p-12 flex flex-col items-center justify-center text-slate-400 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">لا توجد منتجات</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">أضف منتجك الأول الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if($products->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $products->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function confirmDelete(productId) {
    if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
        document.getElementById('delete-form-' + productId).submit();
    }
}
</script>
@endpush
@endsection
