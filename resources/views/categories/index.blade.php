@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">أقسام المنتجات</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                تنظيم المنتجات حسب الفئات لتسهيل البحث والإدارة
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('categories.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">إضافة قسم جديد</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid (Compact) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="premium-card p-6 bg-white border-emerald-100/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">إجمالي الأقسام</p>
                    <h4 class="text-2xl font-black tracking-tight text-slate-900">{{ count($categories) }}</h4>
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
                        <th class="w-1/2">اسم القسم</th>
                        <th class="text-center">المنتجات المرتبطة</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 transition-colors">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-base font-black text-slate-900 leading-tight tracking-tight">{{ $category->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">{{ $category->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-5 py-2.5 rounded-2xl text-[11px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest inline-flex items-center gap-2.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                {{ $category->products_count ?? 0 }} منتج مرنبط
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('categories.edit', $category) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="تعديل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
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
                        <td colspan="3" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد أقسام حالياً</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ بإضافة الأقسام لتنظيم منتجاتك وتسهيل الوصول إليها</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
