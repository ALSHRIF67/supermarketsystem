@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">إضافة منتج جديد</h2>
            <p class="text-sm text-slate-500">أدخل تفاصيل المنتج ومعلومات المخزون</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">
            &rarr; العودة للقائمة
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Basic Info -->
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">المعلومات الأساسية</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">اسم المنتج</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-rose-500 @enderror"
                            placeholder="مثال: حليب المراعي 1 لتر" required>
                        @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">القسم</label>
                        <select name="category_id" id="category_id" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">اختر القسم</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="barcode" class="block text-sm font-medium text-slate-700 mb-1">الباركود</label>
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="امسح أو أدخل الباركود">
                        @error('barcode') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">الأسعار والمخزون</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-slate-700 mb-1">سعر الشراء</label>
                            <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" 
                                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-slate-700 mb-1">سعر البيع</label>
                            <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" 
                                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-slate-700 mb-1">الكمية المتوفرة</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" 
                                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label for="low_stock_threshold" class="block text-sm font-medium text-slate-700 mb-1">حد الإنذار</label>
                            <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="{{ old('low_stock_threshold', 10) }}" 
                                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-slate-700 mb-1">تاريخ الانتهاء</label>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" 
                            class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('products.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors w-full md:w-auto text-center">
                    إلغاء
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition-colors w-full md:w-auto">
                    حفظ المنتج
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
