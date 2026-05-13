@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">تاريخ المبيعات</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                مراجعة وإدارة كافة الفواتير والعمليات السابقة
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pos') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black text-sm">عملية بيع جديدة</span>
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="premium-card p-6 border-slate-100">
        <form action="{{ route('sales.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">رقم الفاتورة</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="INV-..." 
                        class="w-full px-10 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                    <div class="absolute inset-y-0 right-4 flex items-center text-slate-400 group-focus-within:text-emerald-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">التاريخ</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm cursor-pointer">
            </div>
            <div class="md:col-span-2 flex items-end gap-3">
                <button type="submit" class="flex-1 h-[52px] bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/10">
                    تطبيق التصفية
                </button>
                @if(request()->anyFilled(['search', 'date']))
                    <a href="{{ route('sales.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                        إعادة تعيين
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Sales List Area -->
    <div class="flex-1">
        <!-- Desktop Table View -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[18%] text-right">رقم الفاتورة / المحصل</th>
                        <th class="w-[12%] text-center">العميل</th>
                        <th class="w-[12%] text-center">التاريخ</th>
                        <th class="w-[8%] text-center">الأصناف</th>
                        <th class="w-[10%] text-center">الإجمالي</th>
                        <th class="w-[10%] text-center">المدفوع</th>
                        <th class="w-[10%] text-center">المتبقي</th>
                        <th class="w-[10%] text-center">طريقة الدفع</th>
                        <th class="w-[10%] text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    @php
                        $total = $sale->payable_amount ?? 0;
                        $paid = $sale->paid_amount ?? 0;
                        $due = $sale->due_amount ?? max(0, $total - $paid);
                        $itemsCount = $sale->items->count();
                        
                        if ($due <= 0) $s_class = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                        elseif ($paid > 0) $s_class = 'bg-amber-50 text-amber-600 border-amber-100';
                        else $s_class = 'bg-rose-50 text-rose-600 border-rose-100';
                    @endphp
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $sale->invoice_number }}</span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">بواسطة: {{ $sale->user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                {{ $sale->customer->name ?? 'عميل نقدي' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-black text-slate-900 tracking-tight">{{ $sale->created_at->format('Y-m-d') }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $sale->created_at->format('H:i A') }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-black text-slate-700">{{ $itemsCount }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-base font-black text-emerald-600 tracking-tight">{{ number_format($total, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-bold text-slate-700">{{ number_format($paid, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-bold {{ $due > 0 ? 'text-rose-600' : 'text-slate-400' }}">{{ number_format($due, 2) }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $p_styles = ['cash' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 'card' => 'bg-indigo-50 text-indigo-600 border-indigo-100', 'credit' => 'bg-amber-50 text-amber-600 border-amber-100'];
                                $p_labels = ['cash' => 'نقداً', 'card' => 'بطاقة', 'credit' => 'آجل'];
                                $ps = $p_styles[$sale->payment_method] ?? 'bg-slate-50 text-slate-600';
                                $pl = $p_labels[$sale->payment_method] ?? $sale->payment_method;
                            @endphp
                            <span class="px-3 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest {{ $ps }}">
                                {{ $pl }}
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('sales.show', $sale) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد عمليات بيع</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ عمليات البيع من نافذة الكاشير الآن</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards View -->
        <div class="md:hidden space-y-4">
            @forelse($sales as $sale)
            @php
                $total = $sale->payable_amount ?? 0;
                $due = $sale->due_amount ?? max(0, $total - ($sale->paid_amount ?? 0));
                if ($due <= 0) $s_tag = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                elseif ($sale->paid_amount > 0) $s_tag = 'bg-amber-50 text-amber-600 border-amber-100';
                else $s_tag = 'bg-rose-50 text-rose-600 border-rose-100';
            @endphp
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $sale->invoice_number }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $sale->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-lg border text-[9px] font-black uppercase {{ $s_tag }}">
                        {{ $due <= 0 ? 'مدفوع' : ($sale->paid_amount > 0 ? 'جزئي' : 'مستحق') }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 py-3 border-y border-slate-50">
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">الإجمالي</span>
                        <span class="text-sm font-black text-emerald-600 tracking-tight">{{ number_format($total, 2) }} <span class="text-[9px]">ج.س</span></span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">العميل</span>
                        <span class="text-xs font-bold text-slate-700 truncate block">{{ $sale->customer->name ?? 'عميل نقدي' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 pt-1">
                    <span class="text-[10px] font-bold text-slate-500 italic">بواسطة: {{ $sale->user->name }}</span>
                    <a href="{{ route('sales.show', $sale) }}" class="h-11 px-6 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        عرض التفاصيل
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="premium-card p-12 flex flex-col items-center justify-center text-slate-400 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">لا توجد مبيعات</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ عمليات البيع الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if($sales->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $sales->links() }}
    </div>
    @endif
</div>
@endsection