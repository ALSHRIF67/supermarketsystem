@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">تاريخ المبيعات</h2>
            <p class="text-sm text-slate-500">عرض وإدارة جميع العمليات السابقة</p>
        </div>
        <a href="{{ route('pos') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            عملية بيع جديدة
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('sales.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">رقم الفاتورة</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="INV-..." 
                    class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">التاريخ</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex items-end gap-2 lg:col-span-2">
                <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors flex-1">
                    تصفية
                </button>
                @if(request()->anyFilled(['search', 'date']))
                    <a href="{{ route('sales.index') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors flex-1 text-center">
                        مسح
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">الفاتورة</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">العميل</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">التاريخ</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">الإجمالي</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">طريقة الدفع</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-900">{{ $sale->invoice_number }}</span>
                            <p class="text-xs text-slate-500">بواسطة {{ $sale->user->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-slate-600">{{ $sale->customer->name ?? 'عميل نقدي' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-slate-500">
                            {{ $sale->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-slate-900">${{ number_format($sale->payable_amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 capitalize">
                                {{ $sale->payment_method == 'cash' ? 'نقداً' : ($sale->payment_method == 'card' ? 'بطاقة' : 'آجل') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-left">
                            <a href="{{ route('sales.show', $sale) }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">
                            لا توجد سجلات مبيعات.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
