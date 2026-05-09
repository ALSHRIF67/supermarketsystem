@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">إدارة المخزون</h2>
            <p class="text-sm text-slate-500">تتبع كميات المنتجات وتحديث المخزون يدوياً</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('inventory.index', ['filter' => 'low_stock']) }}" class="bg-rose-50 text-rose-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-rose-100 transition-colors">
                النواقص فقط
            </a>
            <a href="{{ route('inventory.index') }}" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                الكل
            </a>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">المنتج</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">المخزون الحالي</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">الحد الأدنى</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left">تحديث سريع</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($products as $product)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-900">{{ $product->name }}</span>
                            <p class="text-xs text-slate-400">{{ $product->barcode }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                                <span class="text-sm font-bold text-rose-600">{{ $product->stock_quantity }}</span>
                            @else
                                <span class="text-sm font-bold text-slate-900">{{ $product->stock_quantity }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-slate-500">
                            {{ $product->low_stock_threshold }}
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('inventory.update', $product) }}" method="POST" class="flex items-center gap-2 justify-end">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="0" class="w-20 rounded-lg border-slate-200 text-sm focus:ring-indigo-500">
                                <button type="submit" name="action" value="add" class="bg-emerald-600 text-white p-2 rounded-lg hover:bg-emerald-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                                <button type="submit" name="action" value="set" class="bg-slate-900 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-slate-800">
                                    تعيين
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
