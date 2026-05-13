@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">الموردين</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                إدارة موردي المنتجات وشركات التوزيع
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('suppliers.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="font-black">إضافة مورد جديد</span>
            </a>
        </div>
    </div>

    <!-- Filters & Stats Grid -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Search & Filter Card -->
        <div class="premium-card p-6 border-slate-100">
            <form action="{{ route('suppliers.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">بحث عن مورد</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو اسم المسؤول..." 
                            class="w-full px-12 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                        <svg class="w-5 h-5 text-slate-400 absolute right-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="h-[52px] px-8 bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/10">
                        تصفية
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('suppliers.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                            إلغاء
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Suppliers List Area -->
    <div class="flex-1">
        <!-- Desktop/Tablet View (Table) -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[30%] text-right">اسم الشركة / المورد</th>
                        <th class="w-[20%] text-center">المسؤول</th>
                        <th class="w-[30%] text-center">معلومات الاتصال</th>
                        <th class="w-[20%] text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $supplier->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">كود: #SUP-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="inline-block px-3 py-1.5 bg-slate-50 text-slate-600 rounded-xl text-[11px] font-black uppercase tracking-widest border border-slate-100">
                                {{ $supplier->contact_person ?: 'غير محدد' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="space-y-0.5">
                                <span class="block text-sm font-black text-slate-900 leading-tight">{{ $supplier->phone ?: '──────' }}</span>
                                <span class="text-[10px] font-bold text-slate-500 block truncate max-w-[200px] mx-auto tracking-widest">{{ $supplier->email ?: '──────' }}</span>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟')">
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
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا يوجد موردين مضافين</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة الموردين لإدارة مخزونك وسلاسل الإمداد</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            @forelse($suppliers as $supplier)
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $supplier->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#SUP-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 py-3 border-y border-slate-50">
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">المسؤول</span>
                        <span class="text-xs font-bold text-slate-700">{{ $supplier->contact_person ?: 'غير محدد' }}</span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">الهاتف</span>
                        <span class="text-xs font-black text-emerald-600">{{ $supplier->phone ?: '──────' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-1">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="flex-1 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        تعديل
                    </a>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟')">
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
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">لا يوجد موردين مضافين</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة الموردين الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if(method_exists($suppliers, 'hasPages') && $suppliers->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $suppliers->links() }}
    </div>
    @endif
</div>
@endsection