@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">تسجيل مصروف جديد</h2>
            <p class="text-slate-500 mt-1">توثيق المصروفات الإدارية والتشغيلية</p>
        </div>
        <a href="{{ route('expenses.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            العودة للقائمة
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="p-6 md:p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-input-group">
                        <label for="expense_category_id" class="custom-label">فئة المصروف</label>
                        <select name="expense_category_id" id="expense_category_id" class="custom-input cursor-pointer" required>
                            <option value="">اختر الفئة</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-input-group">
                        <label for="expense_date" class="custom-label">التاريخ</label>
                        <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" 
                            class="custom-input cursor-pointer" required>
                        @error('expense_date') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-input-group">
                        <label for="amount" class="custom-label">المبلغ</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" 
                                class="custom-input pl-12"
                                placeholder="0.00" required>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 font-bold text-xs">ج.س</div>
                        </div>
                        @error('amount') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-input-group">
                        <label for="reference_number" class="custom-label">رقم المرجع / الفاتورة</label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" 
                            class="custom-input"
                            placeholder="اختياري">
                    </div>
                </div>

                <div class="form-input-group">
                    <label for="description" class="custom-label">الوصف / التفاصيل</label>
                    <textarea name="description" id="description" rows="3" 
                        class="custom-input"
                        placeholder="ما هو سبب هذا المصروف؟">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="px-6 py-6 md:px-10 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('expenses.index') }}" class="text-slate-500 hover:text-slate-700 font-bold text-sm px-6 py-3 transition-colors order-2 md:order-1">
                    إلغاء
                </a>
                <button type="submit" class="btn-primary w-full md:w-auto order-1 md:order-2 bg-rose-600 hover:bg-rose-700 shadow-rose-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    حفظ المصروف
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
