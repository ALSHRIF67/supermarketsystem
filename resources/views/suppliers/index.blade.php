@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">الموردين</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
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

    <!-- Main Table Area -->
    <div class="premium-table-container">
        <div class="overflow-x-auto">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="w-1/3">اسم الشركة / المورد</th>
                        <th class="text-center">المسؤول</th>
                        <th class="text-center">معلومات الاتصال</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-7 h-7 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-base font-black text-slate-900 leading-tight tracking-tight">{{ $supplier->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">كود المورد: #SUP-{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-[11px] font-black uppercase tracking-widest border border-slate-100">
                                {{ $supplier->contact_person ?: 'غير محدد' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="space-y-1">
                                <span class="block text-sm font-black text-slate-900 leading-tight">{{ $supplier->phone ?: '───' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 block truncate max-w-[200px] mx-auto uppercase tracking-widest">{{ $supplier->email ?: '───' }}</span>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="تعديل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟')">
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
                        <td colspan="4" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا يوجد موردين مضافين</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ بإضافة الموردين لإدارة مخزونك وسلاسل الإمداد</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($suppliers->hasPages())
        <div class="mt-8 px-8 py-6 premium-card border-none">
            {{ $suppliers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
