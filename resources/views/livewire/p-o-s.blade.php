<div class="h-full flex flex-col lg:flex-row gap-6" x-data="{ 
    open: false, 
    sale: null,
    closeModal() {
        this.open = false;
    }
}" @sale-completed.window="sale = $event.detail.saleData; open = true;">
    <!-- Right: Search & Products (Primary for touch/mouse) -->
    <div class="w-full lg:w-1/2 flex flex-col gap-6 order-1 lg:order-2">
        <div class="relative">
            <input type="text" 
                   wire:model.live.debounce.300ms="search"
                   placeholder="امسح الباركود أو ابحث عن منتج..."
                   class="w-full pr-12 pl-4 py-4 bg-white rounded-2xl border border-slate-200 shadow-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-right"
                   autofocus>
            <svg class="w-6 h-6 absolute right-4 top-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex-1 bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden flex flex-col min-h-[300px]">
            <div class="p-6 border-b border-slate-100 font-bold text-slate-800 bg-slate-50/50 text-right">نتائج البحث</div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse($searchResults as $product)
                <div class="flex items-center gap-2 w-full p-3 rounded-xl hover:bg-indigo-50 transition-colors group">
                    <button wire:click="addToCart({{ $product->id }})" class="flex-1 flex items-center gap-4 text-right">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex-shrink-0 group-hover:bg-white transition-colors flex items-center justify-center text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-slate-900">{{ $product->name }}</h5>
                            <p class="text-xs text-slate-500">باركود: {{ $product->barcode }}</p>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-indigo-600">${{ number_format($product->sale_price, 2) }}</p>
                            <p class="text-[10px] uppercase font-bold {{ $product->stock_quantity <= 5 ? 'text-rose-500' : 'text-slate-400' }}">
                                {{ $product->stock_quantity }} في المخزن
                            </p>
                        </div>
                    </button>
                    <div class="flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="editProduct({{ $product->id }})" class="p-2 text-indigo-500 hover:bg-indigo-50 bg-white rounded-lg shadow-sm border border-slate-200" title="تعديل">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button onclick="confirm('هل أنت متأكد من حذف المنتج نهائياً؟') || event.stopImmediatePropagation()" wire:click="deleteProduct({{ $product->id }})" class="p-2 text-rose-500 hover:bg-rose-50 bg-white rounded-lg shadow-sm border border-slate-200" title="حذف">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                @empty
                    @if(strlen($search) > 0)
                    <p class="text-slate-400 text-sm text-center py-8 italic">لم يتم العثور على "{{ $search }}"</p>
                    @else
                    <p class="text-slate-400 text-sm text-center py-8 italic">ابدأ الكتابة للبحث عن المنتجات</p>
                    @endif
                @endforelse
            </div>
        </div>
    </div>

    <!-- Left: Cart & Payment -->
    <div class="w-full lg:w-1/2 flex flex-col bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden order-2 lg:order-1 min-h-[500px]">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                الطلب الحالي
            </h2>
            <button wire:click="$set('cart', [])" class="text-xs font-bold text-rose-500 hover:text-rose-600 uppercase tracking-wider">مسح السلة</button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4">
            @forelse($cart as $id => $item)
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group transition-all hover:border-indigo-200">
                <div class="flex-1 flex items-center gap-4 w-full">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center font-bold text-indigo-600 border border-slate-200 flex-shrink-0">
                        {{ $item['quantity'] }}x
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-900">{{ $item['name'] }}</h4>
                        <p class="text-xs text-slate-500">${{ number_format($item['price'], 2) }} للوحدة</p>
                    </div>
                </div>
                <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
                    <div class="flex items-center bg-white rounded-lg border border-slate-200 overflow-hidden">
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="px-3 py-1 hover:bg-slate-50 text-slate-400 font-bold">-</button>
                        <span class="px-3 font-bold text-slate-700 min-w-[40px] text-center">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="px-3 py-1 hover:bg-slate-50 text-slate-400 font-bold">+</button>
                    </div>
                    <div class="text-left min-w-[80px]">
                        <p class="font-bold text-slate-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button wire:click="editProduct({{ $id }})" class="p-2 text-slate-300 hover:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button wire:click="removeFromCart({{ $id }})" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center text-slate-400 py-12">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="font-medium italic">السلة فارغة</p>
                <p class="text-xs">امسح باركود أو ابحث عن منتج للإضافة</p>
            </div>
            @endforelse
        </div>

        <!-- Summary -->
        <div class="p-6 md:p-8 bg-slate-900 text-white rounded-t-3xl space-y-6">
            <div class="space-y-2">
                <div class="flex justify-between text-slate-400 text-sm">
                    <span>المجموع</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                    <span class="text-lg font-bold">المبلغ المطلوب</span>
                    <span class="text-3xl font-black text-indigo-400">${{ number_format($payable, 2) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">طريقة الدفع</label>
                    <select wire:model="paymentMethod" class="w-full bg-slate-800 border-none rounded-xl text-white focus:ring-indigo-500 text-right">
                        <option value="cash">نقداً</option>
                        <option value="card">بطاقة</option>
                        <option value="credit">آجل</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">العميل</label>
                    <select wire:model="selectedCustomer" class="w-full bg-slate-800 border-none rounded-xl text-white focus:ring-indigo-500 text-right">
                        <option value="">عميل نقدي</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button wire:click="checkout" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                إتمام البيع وطباعة الفاتورة
            </button>
        </div>
    </div>

    <!-- Premium Invoice Modal (Indigo & Slate) -->
    <div id="inv-modal" x-cloak x-show="open" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            {{-- Backdrop --}}
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity" aria-hidden="true" @click="closeModal()"></div>

            {{-- This element is to trick the browser into centering the modal contents. --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Design --}}
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 class="inline-block align-middle bg-white rounded-[2.5rem] text-right overflow-hidden shadow-[0_32px_64px_-12px_rgba(15,23,42,0.3)] transform transition-all my-8 sm:align-middle sm:max-w-xl sm:w-full border border-slate-100 relative z-10">
                
            {{-- Header with Indigo Gradient --}}
            <div class="bg-indigo-600 px-10 py-12 flex flex-col items-center relative overflow-hidden text-center">
                <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.2),transparent)]"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="w-24 h-24 bg-white rounded-[2.5rem] flex items-center justify-center text-indigo-600 shadow-2xl mb-8 relative group">
                    <div class="absolute inset-0 bg-indigo-500/20 rounded-[2.5rem] scale-90 group-hover:scale-110 transition-transform duration-500"></div>
                    <svg class="w-12 h-12 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h3 class="text-4xl font-black text-white relative tracking-tight">تم إتمام البيع بنجاح</h3>
                <div class="flex items-center gap-2 mt-4 relative">
                    <span class="w-8 h-px bg-indigo-400"></span>
                    <p class="text-indigo-100 font-black uppercase tracking-[0.3em] text-[10px]">Transaction Verified</p>
                    <span class="w-8 h-px bg-indigo-400"></span>
                </div>
            </div>

                {{-- Invoice Content (Dynamic) --}}
                <div class="p-10 bg-white">
                    <div id="inv-content" class="bg-slate-50/50 rounded-3xl p-8 border border-slate-100 font-bold text-slate-700 text-sm leading-relaxed min-h-[300px]">
                        <template x-if="sale">
                            <div class="space-y-6">
                                <div class="text-center border-b border-slate-200 pb-4">
                                    <h4 class="text-xl font-black text-slate-900">{{ config('app.name') }}</h4>
                                    <p class="text-slate-500 text-xs mt-1" x-text="sale.date || ''"></p>
                                    <p class="text-slate-500 text-xs" x-text="'رقم الفاتورة: ' + (sale.invoice_number || '')"></p>
                                </div>
                                
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 uppercase tracking-wider">العميل:</span>
                                        <span class="text-slate-900" x-text="sale.customer || 'عميل نقدي'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 uppercase tracking-wider">الكاشير:</span>
                                        <span class="text-slate-900" x-text="sale.cashier || ''"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-400 uppercase tracking-wider">طريقة الدفع:</span>
                                        <span class="text-slate-900" x-text="sale.payment_method || ''"></span>
                                    </div>
                                </div>

                                <table class="w-full text-right inv-tbl">
                                    <thead>
                                        <tr class="border-b border-slate-200 text-slate-400 text-[10px] uppercase tracking-widest">
                                            <th class="py-3 font-black text-right">المنتج</th>
                                            <th class="py-3 font-black text-center">الكمية</th>
                                            <th class="py-3 font-black text-left">الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-slate-700">
                                        <template x-for="item in sale.items" :key="item.name">
                                            <tr class="border-b border-slate-50">
                                                <td class="py-4 text-right">
                                                    <div class="font-black text-slate-900" x-text="item.name"></div>
                                                    <div class="text-[10px] text-slate-400" x-text="'$' + parseFloat(item.price || 0).toFixed(2) + ' للوحدة'"></div>
                                                </td>
                                                <td class="py-4 text-center font-black" x-text="(item.quantity || 0) + 'x'"></td>
                                                <td class="py-4 text-left font-black text-slate-900" x-text="'$' + parseFloat(item.subtotal || 0).toFixed(2)"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <div class="pt-4 space-y-2 inv-tot">
                                    <div class="flex justify-between text-slate-400 text-xs">
                                        <span>المجموع الفرعي</span>
                                        <span x-text="'$' + parseFloat(sale.subtotal || 0).toFixed(2)"></span>
                                    </div>
                                    <template x-if="sale.discount > 0">
                                        <div class="flex justify-between text-rose-500 text-xs">
                                            <span>الخصم</span>
                                            <span x-text="'- $' + parseFloat(sale.discount || 0).toFixed(2)"></span>
                                        </div>
                                    </template>
                                    <template x-if="sale.tax > 0">
                                        <div class="flex justify-between text-slate-400 text-xs">
                                            <span>الضريبة</span>
                                            <span x-text="'+ $' + parseFloat(sale.tax || 0).toFixed(2)"></span>
                                        </div>
                                    </template>
                                    <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                                        <span class="text-slate-900 font-black">المجموع النهائي</span>
                                        <span class="text-2xl font-black text-indigo-600" x-text="'$' + parseFloat(sale.payable || 0).toFixed(2)"></span>
                                    </div>
                                </div>

                                <div class="text-center pt-8 border-t border-slate-100 space-y-2">
                                    <p class="italic text-slate-400 text-[10px]">شكرًا لتسوقكم معنا!</p>
                                    <div class="flex justify-center">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!sale">
                            <div class="flex items-center justify-center h-full text-slate-300 animate-pulse">جاري تحضير الفاتورة...</div>
                        </template>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="p-10 pt-0 flex gap-5 no-print">
                    <button class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 font-black py-5 rounded-2xl transition-all border border-slate-100" @click="closeModal()">إغلاق</button>
                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-2xl shadow-indigo-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 group" onclick="window.print()">
                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2h6a2 2 0 002 2z"></path></svg>
                        طباعة الفاتورة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div x-cloak x-show="$wire.showEditModal" class="fixed inset-0 z-[110] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="$wire.showEditModal" @click="$wire.set('showEditModal', false)" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            
            <div class="inline-block align-middle bg-white rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border border-slate-100 relative z-20">
                <div class="p-8">
                    <h3 class="text-2xl font-black text-slate-900 mb-6">تعديل بيانات المنتج</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">اسم المنتج</label>
                                <input type="text" wire:model="editingProductData.name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right">
                                @error('editingProductData.name') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">القسم</label>
                                <select wire:model="editingProductData.category_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right cursor-pointer">
                                    <option value="">اختر القسم</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('editingProductData.category_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">الباركود</label>
                                <input type="text" wire:model="editingProductData.barcode" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right">
                                @error('editingProductData.barcode') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">تاريخ الصلاحية</label>
                                <input type="date" wire:model="editingProductData.expiry_date" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right">
                                @error('editingProductData.expiry_date') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">سعر الشراء</label>
                                <input type="number" step="0.01" wire:model="editingProductData.purchase_price" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right">
                                @error('editingProductData.purchase_price') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">سعر البيع</label>
                                <input type="number" step="0.01" wire:model="editingProductData.sale_price" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right font-bold text-indigo-600">
                                @error('editingProductData.sale_price') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">الكمية</label>
                                <input type="number" wire:model="editingProductData.stock_quantity" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right font-bold">
                                @error('editingProductData.stock_quantity') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">حد تنبيه المخزون</label>
                            <input type="number" wire:model="editingProductData.low_stock_threshold" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-right">
                            @error('editingProductData.low_stock_threshold') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex gap-4">
                        <button @click="$wire.set('showEditModal', false)" class="flex-1 px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-colors">إلغاء</button>
                        <button wire:click="updateProduct" class="flex-1 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-600/20 transition-all">حفظ التغييرات</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        /* ─── PROFESSIONAL RECEIPT STYLES ─────────────────────────── */
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            
            /* Reset everything for print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                box-shadow: none !important;
                text-shadow: none !important;
                font-family: 'Arial', sans-serif !important;
                box-sizing: border-box !important;
                margin: 0;
                padding: 0;
            }

            body {
                background: white !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            /* Hide UI elements */
            .no-print, aside, header, nav, #toasts, .bg-slate-900\/80, button, .backdrop-blur-md {
                display: none !important;
            }

            /* Container for Receipt */
            #inv-modal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 80mm !important; /* Default for 80mm */
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
                background: white !important;
                box-shadow: none !important;
                border: none !important;
            }

            /* Adjust for 58mm if needed via width override */
            @media (max-width: 58mm) {
                #inv-modal {
                    width: 58mm !important;
                }
            }

            .inline-block.align-middle {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
            }

            /* Receipt Header */
            .bg-indigo-600 {
                background-color: white !important;
                color: black !important;
                padding: 5mm 0 !important;
                border-bottom: 1px dashed #000 !important;
            }

            .bg-indigo-600 h3 {
                color: black !important;
                font-size: 14pt !important;
                font-weight: bold !important;
            }

            .bg-indigo-600 .w-24.h-24, .bg-indigo-600 .bg-white\/10, .bg-indigo-600 .bg-indigo-500\/20 {
                display: none !important;
            }

            .bg-indigo-600 .flex.items-center.gap-2.mt-4 {
                display: none !important;
            }

            /* Receipt Content */
            .p-10 {
                padding: 2mm !important;
            }

            #inv-content {
                background: white !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            #inv-content * {
                color: black !important;
                font-size: 9pt !important;
                line-height: 1.4 !important;
            }

            #inv-content h4 {
                font-size: 12pt !important;
                margin-bottom: 1mm !important;
            }

            .inv-tbl {
                width: 100% !important;
                border-collapse: collapse !important;
                margin: 3mm 0 !important;
            }

            .inv-tbl th {
                border-bottom: 1px solid #000 !important;
                padding: 1mm 0 !important;
                font-size: 8pt !important;
            }

            .inv-tbl td {
                padding: 2mm 0 !important;
                border-bottom: 0.5px solid #eee !important;
                vertical-align: top !important;
            }

            /* Prevent long product names from breaking layout */
            .inv-tbl td div {
                word-break: break-word !important;
                max-width: 40mm !important;
            }

            .inv-tot {
                border-top: 1px dashed #000 !important;
                padding-top: 2mm !important;
            }

            .inv-tot .text-2xl {
                font-size: 14pt !important;
                font-weight: bold !important;
            }

            .text-indigo-600 {
                color: black !important;
            }

            /* Footer */
            .pt-8 {
                padding-top: 4mm !important;
                border-top: 1px dashed #000 !important;
            }
        }
    </style>
</div>
