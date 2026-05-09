@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">قائمة المنتجات</h2>
            <p class="text-sm text-slate-500">إدارة منتجات السوبر ماركت وتتبع المخزون</p>
        </div>
        <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة منتج جديد
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم المنتج أو الباركود..." 
                    class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">القسم</label>
                <select name="category" class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">جميع الأقسام</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2 lg:col-span-2">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors flex-1 md:flex-none">
                    تصفية
                </button>
                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('products.index') }}" class="bg-slate-100 text-slate-600 px-6 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors text-center flex-1 md:flex-none">
                        مسح
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">المنتج</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">القسم</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">الباركود</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">السعر</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">المخزون</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-900">{{ $product->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $product->category->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-1 rounded">
                                {{ $product->barcode ?: 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-slate-900">${{ number_format($product->sale_price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                    {{ $product->stock_quantity }} (منخفض)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ $product->stock_quantity }} متوفر
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-left space-x-reverse space-x-3">
                            <a href="{{ route('products.edit', $product) }}" class="text-slate-400 hover:text-indigo-600 transition-colors inline-block">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">
                            لا توجد منتجات مطابقة للبحث.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
