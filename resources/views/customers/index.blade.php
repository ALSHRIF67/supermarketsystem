@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">العملاء</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                إدارة قاعدة بيانات العملاء وبرامج الولاء
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customers.create') }}" class="btn-premium flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 shadow-slate-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span class="font-black">إضافة عميل جديد</span>
            </a>
        </div>
    </div>

    <!-- Stats & Filters -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Search Card -->
        <div class="lg:col-span-3 premium-card p-6 border-slate-100">
            <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">البحث عن عميل</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو رقم الهاتف..." 
                            class="w-full px-12 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm">
                        <svg class="w-5 h-5 text-slate-400 absolute right-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="h-[52px] px-8 bg-emerald-600 text-white rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/10">
                        تصفية
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('customers.index') }}" class="h-[52px] px-6 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                            إلغاء
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Total Stats Card -->
        <div class="premium-card p-6 bg-white border-emerald-100/30">
            <div class="flex items-center gap-4 h-full">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">إجمالي العملاء</p>
                    <h4 class="text-2xl font-black tracking-tight text-slate-900">{{ count($customers) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers List Area -->
    <div class="flex-1">
        <!-- Desktop/Tablet View (Table) -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[30%] text-right">الاسم والبيانات</th>
                        <th class="w-[25%] text-center">معلومات التواصل</th>
                        <th class="w-[30%] text-center">العنوان</th>
                        <th class="w-[15%] text-left">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 group-hover:bg-white transition-colors">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $customer->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">كود: #CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="inline-flex flex-col items-center gap-1">
                                <span class="px-3 py-1.5 bg-slate-900 text-white rounded-xl text-[11px] font-black tracking-tight">
                                    {{ $customer->phone ?: '──────' }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-500 block truncate max-w-[180px]">{{ $customer->email ?: '──────' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="text-[11px] font-black text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 max-w-[220px] inline-block truncate">
                                {{ $customer->address ?: 'لا يوجد عنوان مسجل' }}
                            </span>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('customers.edit', $customer) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
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
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا يوجد عملاء حالياً</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة العملاء لبناء قاعدة بيانات قوية لنظامك</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            @forelse($customers as $customer)
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $customer->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="py-3 border-y border-slate-50 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">رقم الهاتف</span>
                        <span class="text-xs font-black text-slate-900 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">{{ $customer->phone ?: '──────' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">العنوان</span>
                        <span class="text-xs font-bold text-slate-600 truncate max-w-[200px]">{{ $customer->address ?: 'غير محدد' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-1">
                    <a href="{{ route('customers.edit', $customer) }}" class="flex-1 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        تعديل
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
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
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">لا يوجد عملاء حالياً</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">ابدأ بإضافة العملاء الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if(method_exists($customers, 'hasPages') && $customers->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection