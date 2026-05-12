<div class="h-full flex flex-col lg:flex-row gap-8 animate-slide-up" x-data="{ 
    open: false, 
    sale: null,
    closeModal() {
        this.open = false;
    }
}" @sale-completed.window="sale = $event.detail.saleData; open = true;">
    <!-- Right: Search & Products -->
    <div class="w-full lg:w-1/2 flex flex-col gap-6 order-1 lg:order-2">
        <div class="relative group">
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-500 text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" 
                   wire:model.live.debounce.300ms="search"
                   placeholder="امسح الباركود أو ابحث عن منتج..."
                   class="w-full pr-14 pl-6 py-5 bg-white rounded-[2rem] border-2 border-transparent shadow-xl shadow-slate-200/50 focus:ring-0 focus:border-emerald-500 outline-none text-right font-bold text-lg transition-all"
                   autofocus>
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center">
                <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200">F1 Focus</span>
            </div>
        </div>

        <div class="flex-1 premium-card overflow-hidden flex flex-col min-h-[400px]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-black text-slate-900">نتائج البحث</h3>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ count($searchResults) }} منتج تم العثور عليه</span>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                @forelse($searchResults as $product)
                <div class="flex items-center gap-3 w-full p-4 rounded-2xl hover:bg-emerald-50 transition-all duration-300 group border border-transparent hover:border-emerald-100">
                    <button wire:click="addToCart({{ $product->id }})" class="flex-1 flex items-center gap-5 text-right">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex-shrink-0 group-hover:bg-white transition-all flex items-center justify-center text-slate-400 group-hover:text-emerald-500 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="text-base font-black text-slate-900 truncate">{{ $product->name }}</h5>
                            <p class="text-xs text-slate-500 font-medium">باركود: {{ $product->barcode }}</p>
                        </div>
                        <div class="text-left">
                            <p class="text-lg font-black text-emerald-600 tracking-tight">{{ number_format($product->sale_price, 2) }} <span class="text-[10px] font-bold">ج.س</span></p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $product->stock_quantity <= 5 ? 'bg-rose-50 text-rose-500' : 'bg-slate-100 text-slate-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $product->stock_quantity <= 5 ? 'bg-rose-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                {{ $product->stock_quantity }} متوفر
                            </span>
                        </div>
                    </button>
                    <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                        <button wire:click="editProduct({{ $product->id }})" class="p-2.5 text-emerald-600 hover:bg-emerald-500 hover:text-white bg-white rounded-xl shadow-sm border border-slate-200 transition-all" title="تعديل">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>
                </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 py-12">
                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4 border border-slate-100">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-900">ابدأ البحث...</p>
                        <p class="text-xs font-medium text-slate-400 mt-1">أدخل اسم المنتج أو امسح الباركود</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Left: Cart & Payment -->
    <div class="w-full lg:w-1/2 flex flex-col premium-card overflow-hidden order-2 lg:order-1 min-h-[600px] border-emerald-100/50">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-xl font-black text-slate-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                الطلب الحالي
            </h2>
            <button wire:click="$set('cart', [])" class="px-4 py-2 text-[10px] font-black text-rose-500 hover:bg-rose-50 rounded-xl uppercase tracking-[0.2em] transition-all">مسح السلة</button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
            @forelse($cart as $id => $item)
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-5 rounded-[1.5rem] bg-white border border-slate-100 group transition-all hover:border-emerald-200 hover:shadow-lg hover:shadow-emerald-500/5">
                <div class="flex-1 flex items-center gap-5 w-full">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center font-black text-emerald-600 border border-emerald-100 flex-shrink-0 group-hover:scale-110 transition-transform">
                        {{ $item['quantity'] }}x
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-black text-slate-900 truncate">{{ $item['name'] }}</h4>
                        <p class="text-xs text-slate-400 font-bold tracking-tight mt-0.5">{{ number_format($item['price'], 2) }} ج.س للوحدة</p>
                    </div>
                </div>
                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                    <div class="flex items-center bg-slate-50 rounded-xl border border-slate-100 p-1">
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg text-slate-400 hover:text-emerald-500 font-black transition-all shadow-sm">-</button>
                        <span class="px-4 font-black text-slate-900 min-w-[45px] text-center text-sm">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg text-slate-400 hover:text-emerald-500 font-black transition-all shadow-sm">+</button>
                    </div>
                    <div class="text-left min-w-[100px]">
                        <p class="text-base font-black text-slate-900">{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">المجموع</p>
                    </div>
                    <button wire:click="removeFromCart({{ $id }})" class="p-2.5 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center text-slate-300 py-12">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-5 border border-slate-100">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-lg font-black text-slate-400 italic">السلة لا تزال خالية</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">ابدأ بإضافة المنتجات للمتابعة</p>
            </div>
            @endforelse
        </div>

        <!-- Checkout Section -->
        <div class="p-8 bg-slate-900 text-white rounded-t-[3rem] shadow-2xl space-y-8">
            <div class="grid grid-cols-2 gap-8 items-end">
                <div class="space-y-4">
                    <div class="flex justify-between text-slate-500 font-bold text-xs uppercase tracking-widest">
                        <span>إجمالي السلة</span>
                        <span>{{ number_format($total, 2) }} ج.س</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-800 pt-4">
                        <span class="text-lg font-black text-slate-400 uppercase tracking-widest">الصافي</span>
                        <div class="text-right">
                            <span class="text-4xl font-black text-emerald-400 tracking-tighter">{{ number_format($payable, 2) }}</span>
                            <span class="text-xs font-black text-emerald-600 block">جنيهاً سودانياً</span>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">العميل</label>
                            <select wire:model="selectedCustomer" class="w-full bg-slate-800 border-none rounded-xl text-white font-bold py-3 text-sm text-right focus:ring-2 focus:ring-emerald-500">
                                <option value="">عميل نقدي</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">الدفع</label>
                            <select wire:model="paymentMethod" class="w-full bg-slate-800 border-none rounded-xl text-white font-bold py-3 text-sm text-right focus:ring-2 focus:ring-emerald-500">
                                <option value="cash">نقداً</option>
                                <option value="card">بطاقة</option>
                                <option value="credit">آجل</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button wire:click="checkout" class="w-full py-5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-2xl font-black text-xl transition-all shadow-xl shadow-emerald-500/20 active:scale-[0.98] flex items-center justify-center gap-3 group">
                <svg class="w-7 h-7 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2h6a2 2 0 002 2z"></path></svg>
                تأكيد العملية وطباعة الفاتورة
            </button>
        </div>
    </div>

    <!-- Premium Invoice Modal (Glassmorphism) -->
    <div id="inv-modal" x-cloak x-show="open" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-6 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xl transition-opacity" aria-hidden="true" @click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" 
                 x-transition:enter="ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-12 sm:translate-y-0 sm:scale-90" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 class="inline-block align-middle bg-white rounded-[3rem] text-right overflow-hidden shadow-[0_40px_80px_-15px_rgba(0,0,0,0.3)] transform transition-all my-8 sm:align-middle sm:max-w-xl sm:w-full border border-white/20 relative z-10">
                
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 px-10 py-14 flex flex-col items-center relative overflow-hidden text-center">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                    <div class="w-28 h-28 bg-white rounded-[2.5rem] flex items-center justify-center text-emerald-600 shadow-2xl mb-8 relative group transform hover:rotate-6 transition-transform">
                        <svg class="w-14 h-14 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-4xl font-black text-white relative tracking-tighter">عملية ناجحة</h3>
                    <div class="flex items-center gap-3 mt-4 relative">
                        <span class="w-10 h-1 bg-emerald-400 rounded-full"></span>
                        <p class="text-emerald-100 font-black uppercase tracking-[0.4em] text-[10px]">MarketOS Premium</p>
                        <span class="w-10 h-1 bg-emerald-400 rounded-full"></span>
                    </div>
                </div>

                <div class="p-10 bg-white">
                    <div id="inv-content" class="bg-slate-50/80 rounded-[2rem] p-10 border border-slate-100 font-bold text-slate-700 text-sm leading-relaxed min-h-[350px]">
                        <template x-if="sale">
                            <div class="space-y-8">
                                <div class="text-center border-b-2 border-dashed border-slate-200 pb-6">
                                    <h4 class="text-2xl font-black text-slate-900 tracking-tight">{{ config('app.name') }}</h4>
                                    <p class="text-slate-400 text-[10px] mt-2 font-black uppercase tracking-[0.2em]" x-text="sale.date || ''"></p>
                                    <p class="text-slate-900 text-xs font-black mt-1" x-text="'NO: ' + (sale.invoice_number || '')"></p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 text-xs">
                                    <div class="bg-white p-3 rounded-xl border border-slate-100">
                                        <p class="text-slate-400 font-black uppercase tracking-widest text-[8px] mb-1">العميل</p>
                                        <p class="text-slate-900 font-black" x-text="sale.customer || 'عميل نقدي'"></p>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-100 text-left">
                                        <p class="text-slate-400 font-black uppercase tracking-widest text-[8px] mb-1">طريقة الدفع</p>
                                        <p class="text-slate-900 font-black" x-text="sale.payment_method || ''"></p>
                                    </div>
                                </div>

                                <table class="w-full text-right inv-tbl">
                                    <thead>
                                        <tr class="border-b-2 border-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest">
                                            <th class="py-4">الصنف</th>
                                            <th class="py-4 text-center">الكمية</th>
                                            <th class="py-4 text-left">المجموع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="item in sale.items" :key="item.name">
                                            <tr class="border-b border-slate-50 group">
                                                <td class="py-5">
                                                    <p class="font-black text-slate-900" x-text="item.name"></p>
                                                    <p class="text-[9px] text-slate-400 font-bold" x-text="parseFloat(item.price || 0).toFixed(2) + ' ج.س'"></p>
                                                </td>
                                                <td class="py-5 text-center">
                                                    <span class="bg-slate-100 px-3 py-1 rounded-full text-[10px] font-black" x-text="item.quantity + 'x'"></span>
                                                </td>
                                                <td class="py-5 text-left font-black text-slate-900" x-text="parseFloat(item.subtotal || 0).toFixed(2)"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <div class="pt-6 space-y-3 inv-tot">
                                    <div class="flex justify-between items-center pt-6 border-t-4 border-double border-slate-200">
                                        <span class="text-slate-400 font-black uppercase tracking-widest text-sm">المجموع النهائي</span>
                                        <div class="text-left">
                                            <span class="text-3xl font-black text-emerald-600 tracking-tighter" x-text="parseFloat(sale.payable || 0).toFixed(2)"></span>
                                            <span class="text-[10px] font-black text-slate-400 block">جنيهاً سودانياً</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center pt-10 border-t-2 border-dashed border-slate-200">
                                    <p class="font-black text-slate-900 text-sm">شكرًا لثقتكم بنا!</p>
                                    <p class="text-slate-400 text-[9px] font-bold mt-1 uppercase tracking-widest italic">Always at your service</p>
                                </div>
                            </div>
                        </template>
                        <template x-if="!sale">
                            <div class="flex flex-col items-center justify-center h-full gap-5">
                                <div class="w-16 h-16 border-4 border-emerald-100 border-t-emerald-500 rounded-full animate-spin"></div>
                                <p class="text-slate-400 font-black uppercase tracking-widest text-xs">جاري إصدار الفاتورة...</p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="p-10 pt-0 flex gap-6 no-print">
                    <button class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 font-black py-6 rounded-[1.5rem] transition-all border border-slate-100 flex items-center justify-center gap-2" @click="closeModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        إغلاق
                    </button>
                    <button class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-6 rounded-[1.5rem] shadow-2xl shadow-emerald-600/30 transition-all transform hover:-translate-y-2 flex items-center justify-center gap-3 group" onclick="window.print()">
                        <svg class="w-7 h-7 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2h6a2 2 0 002 2z"></path></svg>
                        طباعة الإيصال
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div x-cloak x-show="$wire.showEditModal" class="fixed inset-0 z-[110] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-6 text-center">
            <div x-show="$wire.showEditModal" @click="$wire.set('showEditModal', false)" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>
            
            <div class="inline-block align-middle bg-white rounded-[3rem] text-right overflow-hidden shadow-2xl transform transition-all sm:max-w-xl sm:w-full border border-slate-100 relative z-20">
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900">تعديل بيانات المنتج</h3>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">اسم المنتج</label>
                                <input type="text" wire:model="editingProductData.name" class="custom-input">
                                @error('editingProductData.name') <span class="text-[10px] font-bold text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">القسم</label>
                                <select wire:model="editingProductData.category_id" class="custom-input appearance-none">
                                    <option value="">اختر القسم</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الباركود</label>
                                <input type="text" wire:model="editingProductData.barcode" class="custom-input">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الصلاحية</label>
                                <input type="date" wire:model="editingProductData.expiry_date" class="custom-input">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الشراء</label>
                                <input type="number" step="0.01" wire:model="editingProductData.purchase_price" class="custom-input">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">البيع</label>
                                <input type="number" step="0.01" wire:model="editingProductData.sale_price" class="custom-input font-black text-emerald-600">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pr-2">الكمية</label>
                                <input type="number" wire:model="editingProductData.stock_quantity" class="custom-input font-black">
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-6">
                        <button @click="$wire.set('showEditModal', false)" class="flex-1 px-8 py-5 bg-slate-50 hover:bg-slate-100 text-slate-500 font-black rounded-2xl transition-all border border-slate-100">إلغاء</button>
                        <button wire:click="updateProduct" class="flex-1 px-8 py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-600/30 transition-all transform hover:-translate-y-1">حفظ التغييرات</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        
        @media print {
            @page { size: 80mm auto; margin: 0; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            body { background: white !important; overflow: visible !important; }
            .no-print, aside, header, nav, button { display: none !important; }
            #inv-modal { position: absolute !important; left: 0; top: 0; width: 80mm !important; display: block !important; }
            .inline-block.align-middle { display: block !important; width: 100% !important; border-radius: 0 !important; border: none !important; margin: 0 !important; }
            .bg-gradient-to-br { background: white !important; color: black !important; padding: 5mm 0 !important; border-bottom: 2px dashed #000 !important; }
            .bg-gradient-to-br h3, .bg-gradient-to-br p { color: black !important; }
            .w-28.h-28 { display: none !important; }
            .p-10 { padding: 2mm !important; }
            #inv-content { background: white !important; border: none !important; padding: 0 !important; }
            #inv-content * { color: black !important; font-size: 9pt !important; line-height: 1.4 !important; }
            #inv-content h4 { font-size: 14pt !important; margin-bottom: 2mm !important; }
            .inv-tbl { width: 100% !important; border-collapse: collapse !important; }
            .inv-tbl th { border-bottom: 1px solid #000 !important; padding: 1mm 0 !important; font-size: 8pt !important; }
            .inv-tbl td { padding: 3mm 0 !important; border-bottom: 0.5px solid #eee !important; }
            .inv-tot { border-top: 1px dashed #000 !important; padding-top: 3mm !important; }
            .inv-tot .text-3xl { font-size: 18pt !important; font-weight: 900 !important; }
        }
    </style>
</div>
