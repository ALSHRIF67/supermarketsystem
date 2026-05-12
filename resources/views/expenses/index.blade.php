@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">المصروفات</h2>
            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                تتبع وإدارة تكاليف تشغيل السوبر ماركت والمدفوعات
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('expenses.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-black">تسجيل مصروف جديد</span>
            </a>
        </div>
    </div>

    <!-- Filters & Stats Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Search & Filter Card -->
        <div class="lg:col-span-3 premium-card p-6 border-slate-100">
            <form action="{{ route('expenses.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-64 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الفئة</label>
                    <select name="category" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none cursor-pointer">
                        <option value="">جميع الفئات</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">التاريخ</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                        class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="h-[52px] px-8 bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/10">
                        تصفية
                    </button>
                    @if(request()->anyFilled(['category', 'date']))
                        <a href="{{ route('expenses.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                            إلغاء
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Total Stats Card -->
        <div class="premium-card p-6 bg-gradient-to-br from-rose-500 to-rose-700 text-white border-none shadow-rose-500/20">
            <div class="flex items-center gap-4 h-full">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-rose-100">إجمالي الفترة</p>
                    <h4 class="text-2xl font-black tracking-tight">{{ number_format($expenses->sum('amount'), 2) }} <span class="text-xs">ج.س</span></h4>
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
                        <th class="w-32">التاريخ</th>
                        <th>الفئة</th>
                        <th class="text-center">الوصف والمرجع</th>
                        <th class="text-center">المبلغ</th>
                        <th class="text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td>
                            <div class="flex flex-col">
                                <span class="text-base font-black text-slate-900 tracking-tight">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d') }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->translatedFormat('M Y') }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[11px] font-black uppercase tracking-widest">
                                {{ $expense->category->name }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="space-y-1">
                                <span class="block text-sm font-black text-slate-900 leading-tight">Ref: #{{ $expense->reference_number ?: '───' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 block truncate max-w-[250px] mx-auto">{{ $expense->description ?: 'لا يوجد وصف مضاف' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="inline-flex flex-col items-center">
                                <span class="text-lg font-black text-rose-600 tracking-tight">{{ number_format($expense->amount, 2) }}</span>
                                <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest -mt-1">ج.س</span>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('expenses.edit', $expense) }}" class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/10 rounded-2xl transition-all" title="تعديل">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
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
                        <td colspan="5" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد سجلات مصروفات</h3>
                                <p class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">ابدأ بتسجيل المصروفات لتتبع تكاليفك التشغيلية بدقة</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($expenses->hasPages())
        <div class="mt-8 px-8 py-6 premium-card border-none">
            {{ $expenses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
