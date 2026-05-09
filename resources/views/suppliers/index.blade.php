@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">الموردين</h2>
            <p class="text-sm text-slate-500">إدارة موردي المنتجات والشركات</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة مورد
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">اسم المورد</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">الشخص المسؤول</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">معلومات الاتصال</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-900">{{ $supplier->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-slate-600">{{ $supplier->contact_person ?: 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm text-slate-600">{{ $supplier->email ?: 'لا يوجد بريد' }}</div>
                            <div class="text-xs text-slate-400">{{ $supplier->phone ?: 'لا يوجد هاتف' }}</div>
                        </td>
                        <td class="px-6 py-4 text-left space-x-reverse space-x-3">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">
                            لا يوجد موردين مضافين.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($suppliers->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $suppliers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
