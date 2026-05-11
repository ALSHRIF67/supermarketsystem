@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6" dir="rtl">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">إدارة المخزون</h2>
            <p class="text-sm text-slate-500">تتبع حركات المنتجات والتحويلات بين المخازن</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openModal('stockInModal')" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                توريد مخزون
            </button>
            <button onclick="openModal('transferModal')" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                تحويل مخازن
            </button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">إجمالي المنتجات</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $products->total() }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm border-r-4 border-r-rose-500">
            <p class="text-sm text-slate-500 mb-1">منتجات منخفضة المخزون</p>
            <h3 class="text-2xl font-bold text-rose-600">{{ $products->where('stock_quantity', '<=', 10)->count() }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-sm text-slate-500 mb-1">المخازن المتاحة</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $warehouses->count() }}</h3>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4">
        <form action="{{ route('inventory.index') }}" method="GET" class="flex-1 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المنتج أو الباركود..." class="flex-1 rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl hover:bg-slate-900">بحث</button>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('inventory.index', ['filter' => 'low_stock']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('filter') == 'low_stock' ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">النواقص</a>
            <a href="{{ route('inventory.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('filter') ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">الكل</a>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">المنتج</th>
                        <th class="px-6 py-4">المخزن / الكمية</th>
                        <th class="px-6 py-4 text-center">إجمالي المخزون</th>
                        <th class="px-6 py-4 text-left">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900">{{ $product->name }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $product->barcode }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                @forelse($product->inventories as $inv)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        {{ $inv->warehouse->name }}: <b>{{ $inv->quantity }}</b>
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400 italic">لا يوجد مخزون</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $product->stock_quantity <= $product->low_stock_threshold ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-left">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openAdjustmentModal({{ $product->id }}, '{{ $product->name }}')" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="جرد">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </button>
                                <button onclick="openStockOutModal({{ $product->id }}, '{{ $product->name }}')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="صرف">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Stock In Modal -->
<div id="stockInModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="bg-emerald-600 p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold">توريد مخزون جديد</h3>
            <button onclick="closeModal('stockInModal')" class="hover:bg-emerald-500 rounded-lg p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.stock-in') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">المنتج</label>
                <select name="product_id" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500" required>
                    @foreach(App\Models\Product::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">المخزن</label>
                    <select name="warehouse_id" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">الكمية</label>
                    <input type="number" name="quantity" min="1" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">المرجع (رقم الفاتورة)</label>
                <input type="text" name="reference" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all">تأكيد التوريد</button>
            </div>
        </form>
    </div>
</div>

<!-- Transfer Modal -->
<div id="transferModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="bg-indigo-600 p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold">تحويل بين المخازن</h3>
            <button onclick="closeModal('transferModal')" class="hover:bg-indigo-500 rounded-lg p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.transfer') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">المنتج</label>
                <select name="product_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                    @foreach(App\Models\Product::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">من مخزن</label>
                    <select name="from_warehouse_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">إلى مخزن</label>
                    <select name="to_warehouse_id" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">الكمية</label>
                <input type="number" name="quantity" min="1" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all">بدء التحويل</button>
            </div>
        </form>
    </div>
</div>

<!-- Stock Out Modal (Generic) -->
<div id="stockOutModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="bg-rose-600 p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold" id="stockOutTitle">صرف مخزون</h3>
            <button onclick="closeModal('stockOutModal')" class="hover:bg-rose-500 rounded-lg p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.stock-out') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="product_id" id="stockOutProductId">
            <div class="bg-rose-50 p-3 rounded-xl border border-rose-100 mb-4">
                <p class="text-xs text-rose-600 font-bold">المنتج: <span id="stockOutProductName" class="text-sm"></span></p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">المخزن</label>
                    <select name="warehouse_id" class="w-full rounded-xl border-slate-200 focus:ring-rose-500 focus:border-rose-500" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">الكمية</label>
                    <input type="number" name="quantity" min="1" class="w-full rounded-xl border-slate-200 focus:ring-rose-500 focus:border-rose-500" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">السبب / الملاحظات</label>
                <textarea name="notes" class="w-full rounded-xl border-slate-200 focus:ring-rose-500 focus:border-rose-500" rows="2"></textarea>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-rose-600 text-white py-3 rounded-xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all">تأكيد الصرف</button>
            </div>
        </form>
    </div>
</div>

<!-- Adjustment Modal -->
<div id="adjustmentModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="bg-slate-800 p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold">جرد المخزون (تسوية)</h3>
            <button onclick="closeModal('adjustmentModal')" class="hover:bg-slate-700 rounded-lg p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.adjustment') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="product_id" id="adjProductId">
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 mb-4">
                <p class="text-xs text-slate-500 font-bold">تعديل كمية: <span id="adjProductName" class="text-sm text-slate-900"></span></p>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">المخزن</label>
                <select name="warehouse_id" class="w-full rounded-xl border-slate-200 focus:ring-slate-800 focus:border-slate-800" required>
                    @foreach($warehouses as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">الكمية الفعلية المكتشفة</label>
                <input type="number" name="quantity" min="0" class="w-full rounded-xl border-slate-200 focus:ring-slate-800 focus:border-slate-800" required>
                <p class="text-[10px] text-slate-400 mt-1">سيقوم النظام بحساب الفرق آلياً وتسجيل حركة تسوية.</p>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-800 text-white py-3 rounded-xl font-bold hover:bg-slate-900 transition-all">تحديث الكمية (تسوية)</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    function openStockOutModal(id, name) {
        document.getElementById('stockOutProductId').value = id;
        document.getElementById('stockOutProductName').innerText = name;
        openModal('stockOutModal');
    }

    function openAdjustmentModal(id, name) {
        document.getElementById('adjProductId').value = id;
        document.getElementById('adjProductName').innerText = name;
        openModal('adjustmentModal');
    }
</script>

@endsection
