@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">أقسام المنتجات</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                تنظيم المنتجات حسب الفئات لتسهيل البحث والإدارة
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('categories.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">إضافة قسم جديد</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid (Enhanced with product total) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="premium-card p-6 bg-white border-emerald-100/30">
            <div class="flex items-center gap-4 h-full">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">إجمالي الأقسام</p>
                    <h4 class="text-2xl font-black tracking-tight text-slate-900">{{ $categories->count() }}</h4>
                </div>
            </div>
        </div>
        @php
            $totalProducts = $categories->sum('products_count');
        @endphp
        <div class="premium-card p-6 bg-white border-indigo-100/30">
            <div class="flex items-center gap-4 h-full">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center border border-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">إجمالي المنتجات</p>
                    <h4 class="text-2xl font-black tracking-tight text-slate-900">{{ $totalProducts }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories List Area -->
    <div class="flex-1">
        <!-- Desktop/Tablet View (Table) -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[35%] text-right">اسم القسم</th>
                        <th class="w-[20%] text-center">المنتجات المرتبطة</th>
                        <th class="w-[25%] text-center">تاريخ الإضافة</th>
                        <th class="w-[20%] text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $category->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $category->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-3 py-1.5 rounded-xl text-[11px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 inline-flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                {{ $category->products_count ?? 0 }} منتج
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-black text-slate-900">{{ $category->created_at ? $category->created_at->format('Y-m-d') : '—' }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase">{{ $category->created_at ? $category->created_at->format('H:i A') : '' }}</span>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 rounded-xl transition-all shadow-sm" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد أقسام حالياً</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة الأقسام لتنظيم منتجاتك</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            @forelse($categories as $category)
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $category->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $category->slug }}</span>
                        </div>
                    </div>
                    <div class="text-left">
                        <span class="px-2 py-1 rounded-lg text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                            {{ $category->products_count ?? 0 }} منتج
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-1">
                    <a href="{{ route('categories.edit', $category) }}" class="flex-1 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        تعديل
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full h-11 flex items-center justify-center bg-white border border-rose-100 text-rose-500 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="premium-card p-12 flex flex-col items-center justify-center text-slate-400 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">لا توجد أقسام حالياً</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة الأقسام الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if(method_exists($categories, 'hasPages') && $categories->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
