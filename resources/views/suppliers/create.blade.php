@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up pb-12">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">إضافة مورد جديد</h2>
            <p class="text-sm font-medium text-slate-500">تسجيل بيانات الشركات الموردة لضمان استمرارية سلاسل الإمداد</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="p-8 md:p-12 space-y-10">
                <div class="space-y-2">
                    <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم المورد / الشركة</label>
                    <div class="relative group">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                            class="custom-input pl-12 @error('name') border-rose-500 @enderror"
                            placeholder="مثال: مجموعة المراعي للمنتجات الغذائية" required autofocus>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    </div>
                    @error('name') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="contact_person" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الشخص المسؤول / مندوب المبيعات</label>
                    <div class="relative group">
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" 
                            class="custom-input pl-12 font-black"
                            placeholder="مثال: محمد أحمد">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                            class="custom-input"
                            placeholder="vendor@example.com">
                        @error('email') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">رقم الهاتف / الفاكس</label>
                        <div class="relative group">
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                                class="custom-input pl-12 font-black"
                                placeholder="+249...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                        </div>
                        @error('phone') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="address" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">عنوان المكتب الرئيسي</label>
                    <textarea name="address" id="address" rows="3" 
                        class="custom-input py-4 min-h-[120px]"
                        placeholder="العنوان الفعلي للشركة للتواصل وإرسال الطلبات المكتوبة...">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="px-8 py-8 md:px-12 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-6">
                <a href="{{ route('suppliers.index') }}" class="text-slate-400 hover:text-slate-600 font-black text-xs uppercase tracking-widest transition-colors order-2 md:order-1">
                    إلغاء العملية
                </a>
                <button type="submit" class="btn-premium w-full md:w-auto order-1 md:order-2 px-10 py-4 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                    <span class="font-black text-lg">تسجيل بيانات المورد</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
