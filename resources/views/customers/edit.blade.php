@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up pb-12">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">تعديل العميل</h2>
            <p class="text-sm font-medium text-slate-500">تحديث بيانات العميل <span class="text-emerald-600 font-bold">{{ $customer->name }}</span> وسجل تواصله</p>
        </div>
        <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:border-emerald-100 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-8 md:p-12 space-y-10">
                <div class="space-y-2">
                    <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم العميل بالكامل</label>
                    <div class="relative group">
                        <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" 
                            class="custom-input pl-12 @error('name') border-rose-500 @enderror"
                            placeholder="مثال: أحمد علي حسن" required>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    @error('name') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" 
                            class="custom-input"
                            placeholder="customer@example.com">
                        @error('email') <p class="mt-1 text-[10px] font-bold text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="phone" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">رقم الهاتف</label>
                        <div class="relative group">
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" 
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
                    <label for="address" class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">العنوان بالتفصيل</label>
                    <textarea name="address" id="address" rows="3" 
                        class="custom-input py-4 min-h-[120px]"
                        placeholder="عنوان السكن أو العمل المعتمد لإيصال الطلبات...">{{ old('address', $customer->address) }}</textarea>
                </div>
            </div>

            <div class="px-8 py-8 md:px-12 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-6">
                <a href="{{ route('customers.index') }}" class="text-slate-400 hover:text-slate-600 font-black text-xs uppercase tracking-widest transition-colors order-2 md:order-1">
                    إلغاء التعديلات
                </a>
                <button type="submit" class="btn-premium w-full md:w-auto order-1 md:order-2 px-10 py-4 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black text-lg">تحديث بيانات العميل</span>
                </button>
            </div>
        </form>
    </div>
</div>@endsection
