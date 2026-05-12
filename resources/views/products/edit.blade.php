@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up pb-12">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تعديل المنتج</h2>
            <p class="text-sm font-medium text-slate-500">تحديث بيانات <span class="text-emerald-600 font-bold">{{ $product->name }}</span> وإدارة مخزونه</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8 md:p-12 space-y-12">
                
                <!-- Section: Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="md:col-span-1 space-y-2">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">المعلومات الأساسية</h3>
                        <p class="text-xs font-medium text-slate-400 leading-relaxed">تحديث البيانات التعريفية للمنتج التي تظهر في الفواتير والبحث.</p>
                    </div>
                    
                    <div class="md:col-span-2 space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم المنتج</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                                class="custom-input @error('name') border-rose-500 @enderror"
                                placeholder="مثال: حليب المراعي 1 لتر" required>
                            @error('name') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="category_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">القسم</label>
                                <div class="relative">
                                    <select name="category_id" id="category_id" class="custom-input appearance-none cursor-pointer" required>
                                        <option value="">اختر القسم</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                @error('category_id') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="barcode" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الباركود</label>
                                <div class="relative group">
                                    <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" 
                                        class="custom-input pr-11"
                                        placeholder="امسح أو أدخل الباركود">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    </div>
                                </div>
                                @error('barcode') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-px bg-slate-100"></div>

                <!-- Section: Pricing & Inventory -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="md:col-span-1 space-y-2">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">الأسعار والمخزون</h3>
                        <p class="text-xs font-medium text-slate-400 leading-relaxed">تعديل تكاليف الشراء وأسعار البيع وضبط كميات المخزون الحالية.</p>
                    </div>
                    
                    <div class="md:col-span-2 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="purchase_price" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">سعر الشراء</label>
                                <div class="relative group">
                                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" 
                                        class="custom-input pl-14" required>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-black text-[10px] group-focus-within:text-emerald-500 transition-colors uppercase tracking-widest">ج.س</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="sale_price" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">سعر البيع</label>
                                <div class="relative group">
                                    <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" 
                                        class="custom-input pl-14 font-black text-emerald-600" required>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-black text-[10px] group-focus-within:text-emerald-500 transition-colors uppercase tracking-widest">ج.س</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="stock_quantity" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الكمية الحالية</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                    class="custom-input font-black" required>
                            </div>
                            <div class="space-y-2">
                                <label for="low_stock_threshold" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">حد التنبيه</label>
                                <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" 
                                    class="custom-input">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="expiry_date" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">تاريخ انتهاء الصلاحية</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}" 
                                class="custom-input cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 py-8 md:px-12 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-6">
                <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-600 font-black text-xs uppercase tracking-widest transition-colors order-2 md:order-1">
                    إلغاء التعديلات
                </a>
                <button type="submit" class="btn-premium w-full md:w-auto order-1 md:order-2 px-10 py-4 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black text-lg">تحديث بيانات المنتج</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
