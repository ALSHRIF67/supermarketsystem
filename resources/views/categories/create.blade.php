@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">إضافة قسم جديد</h2>
            <p class="text-slate-500 mt-1">تنظيم المنتجات من خلال أقسام واضحة</p>
        </div>
        <a href="{{ route('categories.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            العودة للقائمة
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="p-6 md:p-10 space-y-8">
                <div class="form-input-group">
                    <label for="name" class="custom-label">اسم القسم</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="custom-input @error('name') border-rose-500 @enderror"
                        placeholder="مثال: مشروبات، مخبوزات، ألبان" required autofocus>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="form-input-group">
                    <label for="description" class="custom-label">وصف القسم (اختياري)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="custom-input"
                        placeholder="وصف مختصر لمحتويات هذا القسم...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="px-6 py-6 md:px-10 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-slate-700 font-bold text-sm px-6 py-3 transition-colors order-2 md:order-1">
                    إلغاء
                </a>
                <button type="submit" class="btn-primary w-full md:w-auto order-1 md:order-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    إنشاء القسم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
