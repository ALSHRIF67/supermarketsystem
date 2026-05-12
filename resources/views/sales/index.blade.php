@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تاريخ المبيعات</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                مراجعة وإدارة كافة الفواتير والعمليات السابقة
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pos') }}" class="btn-premium flex items-center gap-2 px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">عملية بيع جديدة</span>
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="premium-card p-6 bg-white border-slate-100/50">
        <form action="{{ route('sales.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">رقم الفاتورة</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="INV-..." 
                        class="custom-input pl-10">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">التاريخ</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="custom-input cursor-pointer">
            </div>
            <div class="md:col-span-2 flex items-end gap-3">
                <button type="submit" class="flex-1 px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-black rounded-2xl transition-all shadow-lg shadow-slate-900/10 text-xs uppercase tracking-widest">
                    تطبيق التصفية
                </button>
                @if(request()->anyFilled(['search', 'date']))
                    <a href="{{ route('sales.index') }}" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-2xl transition-all text-xs uppercase tracking-widest text-center">
                        إعادة تعيين
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table Area -->
    <div class="premium-table-container">
        <div class="overflow-x-auto">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="w-1/4">رقم الفاتورة / المحصل</th>
                        <th class="text-center">العميل</th>
                        <th class="text-center">تاريخ العملية</th>
                        <th class="text-center">الإجمالي</th>
                        <th class="text-center">طريقة الدفع</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-7 h-7 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-base font-black text-slate-900 leading-tight tracking-tight">{{ $sale->invoice_number }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">بواسطة: {{ $sale->user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-[11px] font-black border border-slate-100 uppercase tracking-widest">
                                {{ $sale->customer->name ?? 'عميل نقدي' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-black text-slate-900 tracking-tight">{{ $sale->created_at->format('Y-m-d') }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $sale->created_at->format('H:i A') }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-lg font-black text-emerald-600 tracking-tight">${{ number_format($sale->payable_amount, 2) }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $paymentStyles = [
                                    'cash' => 'bg-emerald-50 text-emerald-600 border-emerald-100 shadow-emerald-500/5',
                                    'card' => 'bg-indigo-50 text-indigo-600 border-indigo-100 shadow-indigo-500/5',
                                    'credit' => 'bg-amber-50 text-amber-600 border-amber-100 shadow-amber-500/5'
                                ];
                                $paymentLabels = ['cash' => 'نقداً', 'card' => 'بطاقة', 'credit' => 'آجل'];
                                $style = $paymentStyles[$sale->payment_method] ?? 'bg-slate-50 text-slate-600';
                                $label = $paymentLabels[$sale->payment_method] ?? $sale->payment_method;
                            @endphp
                            <span class="px-4 py-2 rounded-2xl border text-[10px] font-black uppercase tracking-widest shadow-sm {{ $style }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('sales.show', $sale) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="عرض التفاصيل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد عمليات بيع مسجلة</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ عمليات البيع من نافذة الكاشير لتظهر هنا</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sales->hasPages())
        <div class="mt-8 px-8 py-6 premium-card border-none">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
