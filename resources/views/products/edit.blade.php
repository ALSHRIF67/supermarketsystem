@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">تعديل المنتج: {{ $product->name }}</h2>
            <p class="text-slate-500 mt-1">قم بتحديث معلومات المنتج والمخزون</p>
        </div>
        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            العودة للقائمة
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-10 space-y-10">
                
                <!-- Section: Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-bold text-slate-800">المعلومات الأساسية</h3>
                        <p class="text-sm text-slate-500 mt-1">تحديث الاسم، القسم والباركود.</p>
                    </div>
                    <div class="md:col-span-2 grid grid-cols-1 gap-6">
                        <div class="form-input-group">
                            <label for="name" class="custom-label">اسم المنتج</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                                class="custom-input @error('name') border-rose-500 @enderror"
                                placeholder="مثال: حليب المراعي 1 لتر" required>
                            @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-input-group">
                                <label for="category_id" class="custom-label">القسم</label>
                                <select name="category_id" id="category_id" class="custom-input cursor-pointer" required>
                                    <option value="">اختر القسم</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-input-group">
                                <label for="barcode" class="custom-label">الباركود</label>
                                <div class="relative">
                                    <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" 
                                        class="custom-input pr-10"
                                        placeholder="امسح أو أدخل الباركود">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    </div>
                                </div>
                                @error('barcode') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Section: Pricing & Inventory -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-bold text-slate-800">الأسعار والمخزون</h3>
                        <p class="text-sm text-slate-500 mt-1">تعديل تكاليف الشراء وأسعار البيع.</p>
                    </div>
                    <div class="md:col-span-2 grid grid-cols-1 gap-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-input-group">
                                <label for="purchase_price" class="custom-label">سعر الشراء</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" 
                                        class="custom-input pl-12" required>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-bold text-xs">ج.س</div>
                                </div>
                            </div>
                            <div class="form-input-group">
                                <label for="sale_price" class="custom-label">سعر البيع</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" 
                                        class="custom-input pl-12" required>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-bold text-xs">ج.س</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-input-group">
                                <label for="stock_quantity" class="custom-label">الكمية الحالية</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                                    class="custom-input" required>
                            </div>
                            <div class="form-input-group">
                                <label for="low_stock_threshold" class="custom-label">حد التنبيه</label>
                                <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" 
                                    class="custom-input">
                            </div>
                        </div>

                        <div class="form-input-group">
                            <label for="expiry_date" class="custom-label">تاريخ انتهاء الصلاحية</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}" 
                                class="custom-input cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 md:px-10 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-slate-700 font-bold text-sm px-6 py-3 transition-colors order-2 md:order-1">
                    إلغاء التعديل
                </a>
                <button type="submit" class="btn-primary w-full md:w-auto order-1 md:order-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    تحديث بيانات المنتج
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
