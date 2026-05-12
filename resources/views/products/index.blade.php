@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">إدارة المنتجات</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                تتبع المخزون والأسعار والأقسام في مكان واحد
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('products.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">إضافة منتج جديد</span>
            </a>
        </div>
    </div>

    <!-- Filters & Stats Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Search & Filter Card -->
        <div class="lg:col-span-3 premium-card p-6 border-emerald-100/30">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">البحث السريع</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم المنتج، الباركود..." 
                            class="w-full pr-11 pl-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                    </div>
                </div>

                <div class="w-full md:w-64 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">تصفية حسب القسم</label>
                    <select name="category" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none cursor-pointer">
                        <option value="">جميع الأقسام</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="h-[52px] px-8 bg-slate-900 text-white rounded-2xl font-black text-sm hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10">
                        تصفية
                    </button>
                    @if(request()->anyFilled(['search', 'category']))
                        <a href="{{ route('products.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                            إعادة تعيين
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Quick Info Card -->
        <div class="premium-card p-6 bg-gradient-to-br from-emerald-500 to-emerald-700 text-white border-none shadow-emerald-500/20">
            <div class="flex items-center gap-4 h-full">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-100">إجمالي المنتجات</p>
                    <h4 class="text-3xl font-black tracking-tight">{{ $products->total() }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Area -->
    <div class="premium-table-container">
        <div class="overflow-x-auto">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="w-1/3">المنتج</th>
                        <th>القسم</th>
                        <th class="text-center">الباركود</th>
                        <th class="text-center">السعر</th>
                        <th class="text-center">المخزون</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-base font-black text-slate-900 tracking-tight">{{ $product->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">SKU: #PRO-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[11px] font-black uppercase tracking-wide">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-xs font-black bg-slate-50 border border-slate-100 text-slate-500 px-4 py-2 rounded-xl font-mono tracking-tighter">
                                {{ $product->barcode ?: '───' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="inline-flex flex-col items-center">
                                <span class="text-lg font-black text-slate-900 tracking-tight">{{ number_format($product->sale_price, 2) }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest -mt-1">ج.س</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                                <div class="inline-flex flex-col items-center">
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black bg-rose-50 text-rose-500 border border-rose-100 uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                                        منخفض
                                    </span>
                                    <span class="text-xs font-black text-rose-600 mt-2">{{ $product->stock_quantity }} وحدة</span>
                                </div>
                            @else
                                <div class="inline-flex flex-col items-center">
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest flex items-center gap-2">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                        متوفر
                                    </span>
                                    <span class="text-xs font-black text-slate-900 mt-2">{{ $product->stock_quantity }} وحدة</span>
                                </div>
                            @endif
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('products.edit', $product) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="تعديل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:shadow-xl hover:shadow-rose-500/10 rounded-2xl transition-all" title="حذف">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد منتجات حالياً</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">جرب تعديل معايير البحث أو إضافة منتج جديد للبدء</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="mt-8 px-8 py-6 premium-card border-none">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
