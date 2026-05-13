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
            font-family: 'Noto Kufi Arabic', 'Arial', sans-serif !important;
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

        .text-emerald-600 {
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

<div class="max-w-3xl mx-auto animate-slide-up pb-12">
    <!-- Action Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 no-print">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تفاصيل الفاتورة</h2>
            <p class="text-sm font-medium text-slate-500">مراجعة بيانات البيع وطباعة الإيصال للعميل</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="btn-premium flex items-center gap-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span class="font-black text-lg">طباعة الفاتورة</span>
            </button>
            <a href="{{ route('sales.index') }}" class="inline-flex items-center gap-2 px-5 py-3.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm">
                العودة للتاريخ
            </a>
        </div>
    </div>

    <!-- Receipt Design -->
    <div class="receipt-container bg-white rounded-[2.5rem] border border-slate-200 shadow-2xl overflow-hidden relative">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-500/5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute top-0 left-0 w-32 h-32 bg-slate-500/5 rounded-full -ml-16 -mt-16"></div>

        <div class="p-8 md:p-12 relative">
            <!-- Header -->
            <div class="text-center border-b border-dashed border-slate-200 pb-10 mb-10">
                <div class="w-20 h-20 bg-slate-900 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-xl shadow-slate-900/20">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h1 class="text-4xl font-black text-slate-900 mb-2">الشريف ماركت</h1>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.2em]">High Performance Retailing</p>
                
                <div class="mt-8 grid grid-cols-2 gap-4 max-w-sm mx-auto p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="text-right">
                        <span class="text-[10px] font-black text-slate-400 block uppercase tracking-widest">رقم الفاتورة</span>
                        <span class="text-sm font-black text-slate-900">#{{ $sale->invoice_number }}</span>
                    </div>
                    <div class="text-left border-r border-slate-200 pr-4">
                        <span class="text-[10px] font-black text-slate-400 block uppercase tracking-widest">تاريخ العملية</span>
                        <span class="text-sm font-black text-slate-900">{{ $sale->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Client & Cashier Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">بيانات العميل</h4>
                    </div>
                    <div class="bg-slate-50/50 p-5 rounded-2xl border border-slate-100/50">
                        <p class="text-slate-900 font-black text-lg">{{ $sale->customer->name ?? 'عميل نقدي' }}</p>
                        @if($sale->customer)
                            <p class="text-sm font-bold text-slate-500 mt-1">{{ $sale->customer->phone }}</p>
                        @endif
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-2 justify-end">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">الموظف المسؤول</h4>
                        <div class="w-1.5 h-4 bg-slate-900 rounded-full"></div>
                    </div>
                    <div class="bg-slate-50/50 p-5 rounded-2xl border border-slate-100/50 text-left">
                        <p class="text-slate-900 font-black text-lg">{{ $sale->user->name }}</p>
                        <div class="mt-2 flex justify-end">
                            @php
                                $paymentStyles = [
                                    'cash' => 'bg-emerald-100 text-emerald-700',
                                    'card' => 'bg-indigo-100 text-indigo-700',
                                    'credit' => 'bg-amber-100 text-amber-700'
                                ];
                                $paymentLabels = ['cash' => 'دفع نقدي', 'card' => 'دفع بالبطاقة', 'credit' => 'حساب آجل'];
                                $style = $paymentStyles[$sale->payment_method] ?? 'bg-slate-100 text-slate-700';
                                $label = $paymentLabels[$sale->payment_method] ?? $sale->payment_method;
                            @endphp
                            <span class="px-3 py-1 rounded-lg font-black text-[10px] uppercase tracking-wider {{ $style }}">
                                {{ $label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="overflow-x-auto mb-12">
                <table class="w-full">
                    <thead>
                        <tr class="text-right border-b-2 border-slate-900">
                            <th class="py-5 font-black text-slate-900 uppercase tracking-widest text-[10px]">المنتج / الوصف</th>
                            <th class="py-5 font-black text-slate-900 text-center uppercase tracking-widest text-[10px]">الكمية</th>
                            <th class="py-5 font-black text-slate-900 text-left uppercase tracking-widest text-[10px]">سعر الوحدة</th>
                            <th class="py-5 font-black text-slate-900 text-left uppercase tracking-widest text-[10px]">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($sale->items as $item)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-6">
                                <p class="font-black text-slate-900 text-base leading-tight">{{ $item->product->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $item->product->barcode }}</p>
                            </td>
                            <td class="py-6 text-center">
                                <span class="inline-flex w-10 h-10 items-center justify-center bg-slate-100 rounded-xl font-black text-slate-900">{{ $item->quantity }}</span>
                            </td>
                            <td class="py-6 text-left font-bold text-slate-500">{{ number_format($item->unit_price, 2) }} <span class="text-[10px]">ج.س</span></td>
                            <td class="py-6 text-left font-black text-slate-900 text-lg">{{ number_format($item->subtotal, 2) }} <span class="text-xs">ج.س</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="flex flex-col md:flex-row justify-between items-start gap-8 border-t-2 border-slate-900 pt-10">
                <div class="flex-1 text-slate-400 font-bold text-sm leading-relaxed max-w-sm italic">
                    * شكراً لاختياركم متجرنا. يرجى الاحتفاظ بهذه الفاتورة في حال الرغبة في الاسترجاع أو الاستبدال خلال 7 أيام من تاريخ العملية.
                </div>
                <div class="w-full md:w-80 space-y-4">
                    <div class="flex justify-between items-center text-slate-500 font-bold px-4">
                        <span class="text-[10px] uppercase tracking-widest">المجموع الفرعي</span>
                        <span class="text-base">{{ number_format($sale->total_amount, 2) }} <span class="text-xs">ج.س</span></span>
                    </div>
                    @if($sale->discount_amount > 0)
                    <div class="flex justify-between items-center text-rose-600 font-black px-4 bg-rose-50 py-3 rounded-2xl">
                        <span class="text-[10px] uppercase tracking-widest">قيمة الخصم (-)</span>
                        <span class="text-base">-{{ number_format($sale->discount_amount, 2) }} <span class="text-xs">ج.س</span></span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center bg-emerald-600 text-white p-6 rounded-[2rem] shadow-xl shadow-emerald-600/20 transform hover:scale-105 transition-transform">
                        <span class="text-xs font-black uppercase tracking-widest">إجمالي المدفوع</span>
                        <span class="text-3xl font-black">{{ number_format($sale->payable_amount, 2) }} <span class="text-lg">ج.س</span></span>
                    </div>
                </div>
            </div>

            <!-- QR / Footer -->
            <div class="mt-16 text-center pt-10 border-t border-dashed border-slate-200">
                <div class="mb-6 flex justify-center">
                    <div class="w-24 h-24 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center p-2 opacity-50 grayscale hover:grayscale-0 transition-all cursor-pointer">
                        <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h4v4H3V3zM17 3h4v4h-4V3zM3 17h4v4H3v-4zM14 14h2v2h-2v-2zM18 18h2v2h-2v-2zM14 18h2v2h-2v-2zM18 14h2v2h-2v-2zM10 10h4v4h-4v-4z"></path></svg>
                    </div>
                </div>
                <p class="text-slate-500 font-black text-lg mb-2">نتمنى لكم يوماً سعيداً!</p>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">WWW.ALSHRIF-MARKET.COM</p>
                
                <div class="mt-10 flex justify-center gap-6 text-[8px] font-black text-slate-300 uppercase tracking-widest">
                    <span>Generated by SuperPOS v3.5</span>
                    <span>•</span>
                    <span>{{ date('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Bottom Zigzag Decorative Border -->
        <div class="h-2 w-full bg-[radial-gradient(circle_at_10px_-7px,transparent_8px,#f8fafc_8px,white_9px)] bg-[length:20px_10px] no-print"></div>
    </div>
</div>
@endsection
