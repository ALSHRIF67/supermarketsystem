@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">إضافة مورد جديد</h2>
            <p class="text-slate-500 mt-1">تسجيل بيانات الموردين والشركات الموردة</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-medium transition-colors group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span>
            العودة للقائمة
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="p-6 md:p-10 space-y-8">
                <div class="form-input-group">
                    <label for="name" class="custom-label">اسم المورد / الشركة</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="custom-input @error('name') border-rose-500 @enderror"
                        placeholder="مثال: مجموعة المراعي" required autofocus>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div class="form-input-group">
                    <label for="contact_person" class="custom-label">الشخص المسؤول</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" 
                        class="custom-input"
                        placeholder="مثال: محمد أحمد">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-input-group">
                        <label for="email" class="custom-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                            class="custom-input"
                            placeholder="vendor@example.com">
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-input-group">
                        <label for="phone" class="custom-label">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                            class="custom-input"
                            placeholder="+249...">
                        @error('phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-input-group">
                    <label for="address" class="custom-label">عنوان المكتب</label>
                    <textarea name="address" id="address" rows="3" 
                        class="custom-input"
                        placeholder="العنوان الفعلي للشركة...">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="px-6 py-6 md:px-10 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-end gap-4">
                <a href="{{ route('suppliers.index') }}" class="text-slate-500 hover:text-slate-700 font-bold text-sm px-6 py-3 transition-colors order-2 md:order-1">
                    إلغاء
                </a>
                <button type="submit" class="btn-primary w-full md:w-auto order-1 md:order-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                    إضافة المورد
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
