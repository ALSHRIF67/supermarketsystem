@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">تعديل القسم: {{ $category->name }}</h2>
            <p class="text-slate-500 mt-1">تعديل معلومات القسم ووصفه</p>
        </div>
        <a href="{{ route('categories.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            العودة للقائمة
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-10 space-y-8">
                <div class="form-input-group">
                    <label for="name" class="custom-label">اسم القسم</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                        class="custom-input @error('name') border-rose-500 @enderror"
                        placeholder="مثال: مشروبات، مخبوزات، ألبان" required>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="form-input-group">
                    <label for="description" class="custom-label">وصف القسم (اختياري)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="custom-input"
                        placeholder="وصف مختصر لمحتويات هذا القسم...">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="px-6 py-6 md:px-10 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-slate-700 font-bold text-sm px-6 py-3 transition-colors order-2 md:order-1">
                    إلغاء التعديل
                </a>
                <button type="submit" class="btn-primary w-full md:w-auto order-1 md:order-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    تحديث القسم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
