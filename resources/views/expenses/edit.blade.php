@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up pb-12">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تعديل مصروف</h2>
            <p class="text-sm font-medium text-slate-500">تحديث بيانات المصروف المسجل بتاريخ <span class="text-emerald-600 font-bold">{{ $expense->expense_date->format('Y-m-d') }}</span></p>
        </div>
        <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8 md:p-12 space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-2">
                            <label for="expense_category_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400">فئة المصروف</label>
                            <button type="button" @click="$dispatch('open-category-modal')" class="text-[10px] font-black text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition-colors uppercase tracking-widest">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                إضافة فئة
                            </button>
                        </div>
                        <div class="relative">
                            <select name="expense_category_id" id="expense_category_id" class="custom-input appearance-none cursor-pointer" required>
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('expense_category_id') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="expense_date" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">التاريخ</label>
                        <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" 
                            class="custom-input cursor-pointer" required>
                        @error('expense_date') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="amount" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">المبلغ</label>
                        <div class="relative group">
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" 
                                class="custom-input pl-14 font-black text-rose-600"
                                placeholder="0.00" required>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-black text-[10px] group-focus-within:text-rose-500 transition-colors uppercase tracking-widest">ج.س</div>
                        </div>
                        @error('amount') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="reference_number" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">رقم المرجع / الفاتورة</label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number', $expense->reference_number) }}" 
                            class="custom-input font-black"
                            placeholder="اختياري">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الوصف / التفاصيل</label>
                    <textarea name="description" id="description" rows="3" 
                        class="custom-input py-4 min-h-[120px]"
                        placeholder="ما هو سبب هذا المصروف؟">{{ old('description', $expense->description) }}</textarea>
                </div>
            </div>

            <div class="px-8 py-8 md:px-12 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-6">
                <a href="{{ route('expenses.index') }}" class="text-slate-400 hover:text-slate-600 font-black text-xs uppercase tracking-widest transition-colors order-2 md:order-1">
                    إلغاء التعديلات
                </a>
                <button type="submit" class="btn-premium w-full md:w-auto order-1 md:order-2 px-10 py-4 flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black text-lg">تحديث بيانات المصروف</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Add Category Modal -->
    <div x-data="{ showCategoryModal: false }" @open-category-modal.window="showCategoryModal = true">
        <div x-show="showCategoryModal" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="showCategoryModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showCategoryModal = false"></div>
                
                <div x-show="showCategoryModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-slate-100 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -mr-16 -mt-16"></div>
                    
                    <div class="relative">
                        <h3 class="text-xl font-black text-slate-900 mb-6">إضافة فئة مصروفات جديدة</h3>
                        <form action="{{ route('expense-categories.store') }}" method="POST">
                            @csrf
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم الفئة</label>
                                    <input type="text" name="name" class="custom-input" placeholder="مثال: إيجار، كهرباء، رواتب..." required autofocus>
                                </div>
                                <div class="flex gap-4 pt-2">
                                    <button type="button" @click="showCategoryModal = false" class="flex-1 px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black rounded-2xl transition-all text-xs uppercase tracking-widest">إلغاء</button>
                                    <button type="submit" class="flex-1 px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20 text-xs uppercase tracking-widest">حفظ الفئة</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
