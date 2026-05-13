@extends('layouts.app')

@section('content')
<div class="flex-1 flex flex-col space-y-8 animate-slide-up w-full pb-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">إدارة المخزون</h2>
            <p class="text-xs md:text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                مراقبة حركات السلع والتحويلات اللوجستية بين المستودعات
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openModal('stockInModal')" class="h-11 md:h-12 px-5 md:px-6 bg-emerald-600 text-white rounded-xl md:rounded-2xl font-black text-xs md:text-sm hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 flex items-center gap-2 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>توريد مخزون</span>
            </button>
            <button onclick="openModal('transferModal')" class="h-11 md:h-12 px-5 md:px-6 bg-indigo-600 text-white rounded-xl md:rounded-2xl font-black text-xs md:text-sm hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 flex items-center gap-2 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span>تحويل مخازن</span>
            </button>
        </div>
    </div>

    <!-- Stats Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="premium-card p-6 md:p-8 bg-white group hover:border-emerald-200 transition-all border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">إجمالي المنتجات</p>
            <h3 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ $products->total() }} <span class="text-xs font-bold text-slate-400">صنف</span></h3>
        </div>

        <div class="premium-card p-6 md:p-8 bg-white border-rose-100 group hover:border-rose-300 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">نواقص المخزون</p>
            <h3 class="text-2xl md:text-3xl font-black text-rose-600 tracking-tight">{{ $products->where('stock_quantity', '<=', 10)->count() }} <span class="text-xs font-bold text-rose-300">تحذير</span></h3>
        </div>

        <div class="premium-card p-6 md:p-8 bg-slate-900 shadow-xl shadow-slate-900/20 border-none group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1 text-emerald-400">مستودعات الإمداد</p>
            <h3 class="text-2xl md:text-3xl font-black text-white tracking-tight">{{ $warehouses->count() }} <span class="text-xs font-bold text-slate-500">مخزن نشط</span></h3>
        </div>
    </div>

    <!-- Filters Area -->
    <div class="premium-card p-6 md:p-8 bg-white border-slate-100 flex flex-col md:flex-row gap-6 mb-10">
        <form action="{{ route('inventory.index') }}" method="GET" class="flex-1">
            <div class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث برمز الباركود أو اسم المنتج..." 
                    class="w-full pr-12 pl-4 h-14 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm md:text-lg">
                <div class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </form>
        <div class="flex gap-3">
            <a href="{{ route('inventory.index', ['filter' => 'low_stock']) }}" class="h-14 px-6 md:px-8 flex items-center justify-center rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-widest transition-all {{ request('filter') == 'low_stock' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                فرز النواقص
            </a>
            <a href="{{ route('inventory.index') }}" class="h-14 px-6 md:px-8 flex items-center justify-center rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-widest transition-all {{ !request('filter') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                كافة المخزون
            </a>
        </div>
    </div>

    <!-- Inventory List Area -->
    <div class="flex-1">
        <!-- Desktop Table View -->
        <div class="hidden md:block premium-table-container">
            <table class="premium-table w-full">
                <thead>
                    <tr>
                        <th class="w-[30%] text-right">المنتج والوصف</th>
                        <th class="w-[30%] text-right">توزيع المخازن</th>
                        <th class="w-[20%] text-center">إجمالي الرصيد</th>
                        <th class="w-[20%] text-left">التحكم اللوجستي</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 font-black border border-slate-100 uppercase group-hover:bg-white transition-colors">
                                    {{ substr($product->name, 0, 2) }}
                                </div>
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-black text-slate-900 leading-tight tracking-tight">{{ $product->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Barcode: {{ $product->barcode }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex flex-wrap justify-end gap-2">
                                @forelse($product->inventories as $inv)
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black bg-slate-50 border border-slate-100 hover:border-emerald-200 transition-all">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $inv->quantity > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span class="text-slate-500 uppercase">{{ $inv->warehouse->name }}:</span>
                                        <span class="text-slate-900">{{ $inv->quantity }}</span>
                                    </div>
                                @empty
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black bg-rose-50 text-rose-500 border border-rose-100 uppercase tracking-widest italic">غير مدرج</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $isLow = $product->stock_quantity <= $product->low_stock_threshold;
                                $totalClass = $isLow ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-emerald-600 bg-emerald-50 border-emerald-100';
                            @endphp
                            <div class="flex flex-col items-center gap-1">
                                <span class="px-4 py-2 rounded-xl border text-base font-black {{ $totalClass }}">
                                    {{ $product->stock_quantity }}
                                </span>
                                @if($isLow)
                                    <span class="text-[9px] font-black text-rose-400 uppercase tracking-widest animate-pulse">منخفض</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openAdjustmentModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 rounded-xl transition-all shadow-sm" title="جرد وتسوية">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </button>
                                <button onclick="openStockOutModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 rounded-xl transition-all shadow-sm" title="سحب مخزون (تلف/هالك)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-0">
                            <div class="premium-card p-20 flex flex-col items-center justify-center text-slate-400 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6 border border-slate-100 text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">لا توجد منتجات في المخزون</h3>
                                <p class="text-sm font-bold text-slate-500 mt-2 uppercase tracking-widest">أضف منتجات أو قم بعملية توريد أولى</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4">
            @forelse($products as $product)
            @php
                $isLow = $product->stock_quantity <= $product->low_stock_threshold;
                $s_class = $isLow ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-emerald-600 bg-emerald-50 border-emerald-100';
            @endphp
            <div class="premium-card p-5 bg-white border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-slate-900">{{ $product->name }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Barcode: {{ $product->barcode }}</span>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 rounded-lg border text-[11px] font-black {{ $s_class }}">
                        {{ $product->stock_quantity }}
                    </span>
                </div>
                
                @if($product->inventories->isNotEmpty())
                <div class="py-3 border-y border-slate-50">
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 pr-1">توزيع المخازن</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->inventories as $inv)
                        <div class="inline-flex items-center gap-1 px-2 py-1 bg-slate-50 rounded-lg text-[9px] font-black border border-slate-100">
                            <span class="text-slate-500">{{ $inv->warehouse->name }}:</span>
                            <span class="text-slate-900">{{ $inv->quantity }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="flex items-center justify-end gap-2 pt-1">
                    <button onclick="openAdjustmentModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="flex-1 h-11 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        تسوية
                    </button>
                    <button onclick="openStockOutModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="flex-1 h-11 flex items-center justify-center bg-white border border-rose-100 text-rose-500 rounded-xl font-black text-xs gap-2 transition-all active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        سحب
                    </button>
                </div>
            </div>
            @empty
            <div class="premium-card p-12 flex flex-col items-center justify-center text-slate-400 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 italic">المخزن خالي</h3>
                <p class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-widest">قم بإضافة منتجاتك الأولى الآن</p>
            </div>
            @endforelse
        </div>
    </div>
        
    @if($products->hasPages())
    <div class="mt-8 px-8 py-6 premium-card border-none">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Modals -->
<div id="stockInModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="stockInModalCard">
        <div class="bg-emerald-600 p-8 text-white flex justify-between items-center">
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight italic">توريد مخزون</h3>
                <p class="text-[10px] font-bold text-emerald-200 uppercase tracking-widest">Stock replenishment form</p>
            </div>
            <button onclick="closeModal('stockInModal')" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-2xl flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.stock-in') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">المنتج المورد</label>
                <select name="product_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none" required>
                    @foreach(App\Models\Product::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->barcode }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">المستودع</label>
                    <select name="warehouse_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">الكمية</label>
                    <input type="number" name="quantity" min="1" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm" placeholder="0" required>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">رقم الفاتورة / المرجع</label>
                <input type="text" name="reference" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm" placeholder="REF-000000">
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-[2rem] font-black text-lg transition-all shadow-xl shadow-emerald-200 flex items-center justify-center gap-3 active:scale-95">
                    <span class="font-black">تأكيد عملية التوريد</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="transferModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="transferModalCard">
        <div class="bg-indigo-600 p-8 text-white flex justify-between items-center">
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight italic">تحويل مخازن</h3>
                <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest">Internal Stock Transfer</p>
            </div>
            <button onclick="closeModal('transferModal')" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-2xl flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.transfer') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">الصنف المراد تحويله</label>
                <select name="product_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none" required>
                    @foreach(App\Models\Product::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">من مخزن</label>
                    <select name="from_warehouse_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-rose-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">إلى مخزن</label>
                    <select name="to_warehouse_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-emerald-500 focus:bg-white focus:ring-0 outline-none transition-all font-bold text-sm appearance-none" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">الكمية المحولة</label>
                <input type="number" name="quantity" min="1" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 outline-none transition-all font-black text-2xl h-16 text-center" placeholder="0" required>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-[2rem] font-black text-lg transition-all shadow-xl shadow-indigo-200 flex items-center justify-center gap-3 active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    تنفيذ التحويل اللوجستي
                </button>
            </div>
        </form>
    </div>
</div>

<div id="stockOutModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="stockOutModalCard">
        <div class="bg-rose-600 p-8 text-white flex justify-between items-center">
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight italic">صرف مخزون</h3>
                <p class="text-[10px] font-bold text-rose-200 uppercase tracking-widest">Inventory write-off form</p>
            </div>
            <button onclick="closeModal('stockOutModal')" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-2xl flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.stock-out') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <input type="hidden" name="product_id" id="stockOutProductId">
            <div class="bg-rose-50/50 p-5 rounded-2xl border border-rose-100 flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-rose-500 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest block">المنتج المحدد</span>
                    <p id="stockOutProductName" class="text-sm font-black text-slate-900"></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">من مخزن</label>
                    <select name="warehouse_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-rose-500 focus:bg-white focus:ring-0 outline-none font-bold text-sm appearance-none" required>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">الكمية</label>
                    <input type="number" name="quantity" min="1" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-rose-500 focus:bg-white focus:ring-0 outline-none font-bold text-sm" placeholder="0" required>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">سبب الصرف (تلف / انتهاء)</label>
                <textarea name="notes" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-rose-500 focus:bg-white focus:ring-0 outline-none font-bold text-sm min-h-[100px] py-4" placeholder="اكتب سبب استبعاد الكمية..."></textarea>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white py-5 rounded-[2rem] font-black text-lg transition-all shadow-xl shadow-rose-200 active:scale-95">
                    تأكيد صرف الكمية
                </button>
            </div>
        </form>
    </div>
</div>

<div id="adjustmentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[100] hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="adjustmentModalCard">
        <div class="bg-slate-900 p-8 text-white flex justify-between items-center">
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight italic">جرد وتسوية</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Inventory audit & adjustment</p>
            </div>
            <button onclick="closeModal('adjustmentModal')" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-2xl flex items-center justify-center transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('inventory.adjustment') }}" method="POST" class="p-8 space-y-8">
            @csrf
            <input type="hidden" name="product_id" id="adjProductId">
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">تعديل رصيد الصنف</span>
                <p id="adjProductName" class="text-sm font-black text-slate-900"></p>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">المستودع المستهدف</label>
                <select name="warehouse_id" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-slate-500 focus:bg-white focus:ring-0 outline-none font-bold text-sm appearance-none" required>
                    @foreach($warehouses as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pr-2">الكمية الفعلية المكتشفة</label>
                <input type="number" name="quantity" min="0" class="w-full px-4 py-3.5 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-slate-500 focus:bg-white focus:ring-0 outline-none font-black text-2xl h-16 text-center" placeholder="0" required>
                <p class="text-[9px] text-slate-400 font-bold text-center mt-2 px-4 uppercase tracking-tighter">* سيقوم النظام آلياً بإنشاء حركة تسوية لسد الفجوة</p>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white py-5 rounded-[2rem] font-black text-lg transition-all shadow-xl shadow-slate-200 active:scale-95">
                    تحديث الكمية وتسوية الفارق
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const card = document.getElementById(id + 'Card');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const card = document.getElementById(id + 'Card');
        card.classList.add('scale-95', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
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

    window.onclick = function(event) {
        if (event.target.classList.contains('fixed')) {
            closeModal(event.target.id);
        }
    }
</script>
@endsection
