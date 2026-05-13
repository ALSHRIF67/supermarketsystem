@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full max-w-[1600px] mx-auto">
    
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">اسم الصفحة هنا</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                وصف موجز لمحتويات الصفحة والوظائف المتاحة
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="#" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-xl shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">إضافة جديد</span>
            </a>
        </div>
    </div>

    <!-- Responsive Table Container -->
    <div class="premium-card p-0 overflow-hidden border-none shadow-2xl shadow-slate-200/50">
        <table class="stackable-table w-full border-separate border-spacing-0">
            <thead>
                <tr class="bg-slate-50/50">
                    <!-- 
                        HOW TO CUSTOMIZE COLUMNS:
                        1. Add/Remove <th> tags here for Desktop.
                        2. Match them with <td> tags in the <tbody>.
                    -->
                    <th class="px-6 py-5 text-right text-[11px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-100">المنتج</th>
                    <th class="px-6 py-5 text-center text-[11px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-100">الفئة</th>
                    <th class="px-6 py-5 text-center text-[11px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-100">السعر</th>
                    <th class="px-6 py-5 text-center text-[11px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-100">الحالة</th>
                    <th class="px-6 py-5 text-left text-[11px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-100">التحكم</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                {{-- Example Dynamic Loop --}}
                @forelse($items ?? [] as $item)
                <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                    <!-- 
                        DATA-LABEL ATTRIBUTE:
                        - This is crucial for Mobile view. 
                        - The text in data-label will appear as a title on the left side in mobile.
                    -->
                    <td data-label="المنتج" class="px-6 py-5">
                        <div class="flex items-center gap-3 md:justify-start justify-end w-full">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 font-black border border-emerald-100 group-hover:scale-110 transition-transform">
                                {{ substr($item->name ?? 'P', 0, 1) }}
                            </div>
                            <span class="font-black text-slate-900 text-sm tracking-tight">{{ $item->name ?? 'منتج افتراضي' }}</span>
                        </div>
                    </td>

                    <td data-label="الفئة" class="px-6 py-5 text-center">
                        <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                            {{ $item->category ?? 'تصنيف عام' }}
                        </span>
                    </td>

                    <td data-label="السعر" class="px-6 py-5 text-center">
                        <span class="font-black text-slate-900 text-sm tracking-tight">
                            {{ number_format($item->price ?? 150.00, 2) }} 
                            <span class="text-[10px] text-slate-400">ج.س</span>
                        </span>
                    </td>

                    <td data-label="الحالة" class="px-6 py-5 text-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black tracking-wide border border-emerald-100">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            نشط
                        </span>
                    </td>

                    <td data-label="التحكم" class="px-6 py-5">
                        <div class="flex items-center md:justify-start justify-end gap-2">
                            <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-0">
                        <div class="p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900">لا توجد بيانات حالياً</h3>
                            <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ بإضافة سجلات جديدة لتظهر هنا</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Optional Pagination --}}
    @if(isset($items) && method_exists($items, 'links'))
    <div class="mt-4">
        {{ $items->links() }}
    </div>
    @endif
</div>

<style>
    /* 
        STACKABLE TABLE CSS 
        This handles the transformation from Table to Card list on Mobile.
    */
    @media (max-width: 767px) {
        /* Hide the original table header */
        .stackable-table thead {
            display: none;
        }

        /* Make each part of the table a block element */
        .stackable-table, 
        .stackable-table tbody, 
        .stackable-table tr, 
        .stackable-table td {
            display: block;
            width: 100%;
        }

        /* Style the row (Card) */
        .stackable-table tr {
            margin-bottom: 1.5rem;
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 1.5rem;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        /* Style the cells (Flex rows inside Card) */
        .stackable-table td {
            text-align: left;
            padding: 0.75rem 0.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between; /* This puts label on right, value on left */
            border-bottom: 1px solid #f8fafc;
        }

        .stackable-table td:last-child {
            border-bottom: none;
        }

        /* Inject the data-label content */
        .stackable-table td::before {
            content: attr(data-label);
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8; /* slate-400 */
            margin-right: 1rem;
            order: 2; /* Move label to the right for RTL */
        }

        /* Ensure content takes proper alignment */
        .stackable-table td > * {
            order: 1; /* Move value to the left */
        }
    }
</style>
@endsection
