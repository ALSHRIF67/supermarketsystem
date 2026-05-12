@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">العملاء</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                إدارة قاعدة بيانات العملاء وبرامج الولاء
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customers.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span class="font-black">إضافة عميل جديد</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid (Compact) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="premium-card p-6 bg-white border-emerald-100/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">إجمالي العملاء</p>
                    <h4 class="text-2xl font-black tracking-tight text-slate-900">{{ count($customers) }}</h4>
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
                        <th class="w-1/3">الاسم والبيانات</th>
                        <th class="text-center">معلومات التواصل</th>
                        <th class="text-center">العنوان</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 transition-colors">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-base font-black text-slate-900 leading-tight tracking-tight">{{ $customer->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em]">كود العميل: #CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="inline-flex flex-col items-center gap-1">
                                <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-xs font-black tracking-tight">
                                    {{ $customer->phone ?: '───' }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 block truncate max-w-[150px]">{{ $customer->email ?: '───' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-xs font-black text-slate-500 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100 max-w-[200px] inline-block truncate">
                                {{ $customer->address ?: 'لا يوجد عنوان مسجل' }}
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('customers.edit', $customer) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="تعديل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
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
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا يوجد عملاء حالياً</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ بإضافة العملاء لبناء قاعدة بيانات قوية لنظامك</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($customers->hasPages())
        <div class="mt-8 px-8 py-6 premium-card border-none">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
