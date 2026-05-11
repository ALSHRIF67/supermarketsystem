@extends('layouts.app')

@section('content')
<style>
    @media print {
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            box-shadow: none !important;
            text-shadow: none !important;
            font-family: 'Arial', sans-serif !important;
            box-sizing: border-box !important;
        }

        html, body {
            overflow: visible !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            width: 100% !important;
        }

        .no-print { display: none !important; }
        
        main {
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            width: 100% !important;
        }

        .receipt-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 4mm 2mm !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
        }

        .receipt-container * {
            color: #000 !important;
            font-size: 10px !important;
        }

        .receipt-container h1 {
            font-size: 16px !important;
            margin-bottom: 1mm !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        th {
            border-bottom: 1px dashed #000 !important;
            padding: 1mm 0 !important;
            font-size: 9px !important;
        }

        td {
            padding: 1.5mm 0 !important;
            border-bottom: 0.5px solid #eee !important;
        }

        .text-2xl, .text-3xl {
            font-size: 14px !important;
        }

        .text-indigo-600 {
            color: #000 !important;
            font-weight: 900 !important;
            font-size: 14px !important;
        }

        /* Support for smaller printers (58mm) */
        @media (max-width: 58mm) {
            .receipt-container {
                width: 58mm !important;
            }
        }
    }
</style>

<div class="max-w-4xl mx-auto py-8 px-4 no-print">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">تفاصيل الفاتورة</h2>
            <p class="text-slate-500">مراجعة وطباعة بيانات البيع</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                طباعة الآن
            </button>
            <a href="{{ route('sales.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all">
                العودة للتاريخ
            </a>
        </div>
    </div>
</div>

<div class="receipt-container bg-white rounded-3xl border border-slate-200 shadow-xl mx-auto p-8 md:p-12 mb-12">
    <!-- Header -->
    <div class="text-center border-b border-dashed border-slate-200 pb-8 mb-8">
        <h1 class="text-3xl font-black text-slate-900 mb-1">سوقنا الذكي</h1>
        <p class="text-slate-500 font-medium">إدارة السوبر ماركت الحديثة</p>
        <div class="mt-4 flex flex-col items-center gap-1 text-sm text-slate-400">
            <span>رقم الفاتورة: <span class="text-slate-900 font-bold">#{{ $sale->invoice_number }}</span></span>
            <span>تاريخ البيع: {{ $sale->created_at->format('Y-m-d H:i') }}</span>
        </div>
    </div>

    <!-- Details -->
    <div class="grid grid-cols-2 gap-8 mb-10 text-sm">
        <div class="space-y-1">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">العميل</h4>
            <p class="text-slate-900 font-bold text-base">{{ $sale->customer->name ?? 'عميل نقدي' }}</p>
            @if($sale->customer)
                <p class="text-slate-500">{{ $sale->customer->phone }}</p>
            @endif
        </div>
        <div class="text-left space-y-1">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">الموظف</h4>
            <p class="text-slate-900 font-bold text-base">{{ $sale->user->name }}</p>
            <span class="inline-flex px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-[10px] uppercase">
                {{ $sale->payment_method == 'cash' ? 'نقداً' : ($sale->payment_method == 'card' ? 'بطاقة' : 'آجل') }}
            </span>
        </div>
    </div>

    <!-- Items -->
    <div class="overflow-x-auto mb-10">
        <table class="w-full">
            <thead>
                <tr class="text-right border-b-2 border-slate-900">
                    <th class="py-4 font-black text-slate-900">المنتج</th>
                    <th class="py-4 font-black text-slate-900 text-center">الكمية</th>
                    <th class="py-4 font-black text-slate-900 text-left">السعر</th>
                    <th class="py-4 font-black text-slate-900 text-left">الإجمالي</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($sale->items as $item)
                <tr>
                    <td class="py-5">
                        <p class="font-bold text-slate-900">{{ $item->product->name }}</p>
                        <p class="text-xs text-slate-400">{{ $item->product->barcode }}</p>
                    </td>
                    <td class="py-5 text-center font-bold text-slate-600">{{ $item->quantity }}</td>
                    <td class="py-5 text-left text-slate-600 font-medium">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-5 text-left font-black text-slate-900">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    <div class="flex justify-end border-t border-slate-200 pt-8">
        <div class="w-full md:w-64 space-y-4">
            <div class="flex justify-between text-slate-500 font-medium">
                <span>المجموع الفرعي:</span>
                <span>${{ number_format($sale->total_amount, 2) }}</span>
            </div>
            @if($sale->discount_amount > 0)
            <div class="flex justify-between text-rose-600 font-bold">
                <span>الخصم:</span>
                <span>-${{ number_format($sale->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center bg-slate-50 p-4 rounded-2xl">
                <span class="text-lg font-black text-slate-900">الإجمالي:</span>
                <span class="text-2xl font-black text-indigo-600">${{ number_format($sale->payable_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-12 text-center border-t border-dashed border-slate-200 pt-8">
        <p class="text-slate-500 font-bold italic mb-2">شكراً لزيارتكم! نتمنى رؤيتكم قريباً</p>
        <div class="flex justify-center gap-4 text-[10px] text-slate-400 font-black uppercase tracking-widest">
            <span>MarketOS v2.0</span>
            <span>•</span>
            <span>{{ now()->format('Y') }}</span>
        </div>
    </div>
</div>
@endsection
