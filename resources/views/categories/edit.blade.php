@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up pb-12">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تعديل القسم</h2>
            <p class="text-sm font-medium text-slate-500">تعديل بيانات القسم: <span class="text-emerald-600 font-bold">{{ $category->name }}</span></p>
        </div>
        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8 md:p-12 space-y-10">
                <div class="space-y-2">
                    <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم القسم</label>
                    <div class="relative group">
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                            class="custom-input pl-12 @error('name') border-rose-500 @enderror"
                            placeholder="مثال: مشروبات، مخبوزات، ألبان" required>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                    @error('name') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">وصف القسم (اختياري)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="custom-input py-4 min-h-[120px]"
                        placeholder="وصف مختصر لمحتويات هذا القسم...">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="px-8 py-8 md:px-12 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-6">
                <a href="{{ route('categories.index') }}" class="text-slate-400 hover:text-slate-600 font-black text-xs uppercase tracking-widest transition-colors order-2 md:order-1">
                    إلغاء التعديل
                </a>
                <button type="submit" class="btn-premium w-full md:w-auto order-1 md:order-2 px-10 py-4 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black text-lg">تحديث بيانات القسم</span>
                </button>
            </div>
        </form>
    </div>
</div>@endsection
