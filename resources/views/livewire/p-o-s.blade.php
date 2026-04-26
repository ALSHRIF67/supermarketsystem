<div class="h-[calc(100vh-140px)] flex gap-8">
    <!-- Left: Cart & Payment -->
    <div class="flex-1 bg-white rounded-3xl border border-slate-200 shadow-xl flex flex-col overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Current Order
            </h2>
            <button wire:click="$set('cart', [])" class="text-xs font-bold text-rose-500 hover:text-rose-600 uppercase tracking-wider">Clear Cart</button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            @forelse($cart as $id => $item)
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group transition-all hover:border-indigo-200">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center font-bold text-indigo-600 border border-slate-200">
                    {{ $item['quantity'] }}x
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-900">{{ $item['name'] }}</h4>
                    <p class="text-xs text-slate-500">${{ number_format($item['price'], 2) }} per unit</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center bg-white rounded-lg border border-slate-200 overflow-hidden">
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="p-2 hover:bg-slate-50 text-slate-400">-</button>
                        <span class="px-3 font-bold text-slate-700 min-w-[40px] text-center">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="p-2 hover:bg-slate-50 text-slate-400">+</button>
                    </div>
                    <div class="text-right min-w-[80px]">
                        <p class="font-bold text-slate-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                    <button wire:click="removeFromCart({{ $id }})" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="h-full flex flex-col items-center justify-center text-slate-400">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="font-medium italic">Your cart is empty</p>
                <p class="text-xs">Scan a barcode or search for products</p>
            </div>
            @endforelse
        </div>

        <!-- Summary -->
        <div class="p-8 bg-slate-900 text-white rounded-t-3xl space-y-6">
            <div class="space-y-2">
                <div class="flex justify-between text-slate-400 text-sm">
                    <span>Subtotal</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-400 text-sm">
                    <span>Tax (0%)</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                    <span class="text-lg font-bold">Total Amount</span>
                    <span class="text-3xl font-black text-indigo-400">${{ number_format($payable, 2) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Payment Method</label>
                    <select wire:model="paymentMethod" class="w-full bg-slate-800 border-none rounded-xl text-white focus:ring-indigo-500">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="credit">Credit / Debt</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Customer</label>
                    <select wire:model="selectedCustomer" class="w-full bg-slate-800 border-none rounded-xl text-white focus:ring-indigo-500">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button wire:click="checkout" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                Place Order & Print Receipt
            </button>
        </div>
    </div>

    <!-- Right: Search & Quick Pick -->
    <div class="w-[400px] flex flex-col gap-6">
        <div class="relative">
            <input type="text" 
                   wire:model.live.debounce.300ms="search"
                   placeholder="Scan barcode or search products..."
                   class="w-full pl-12 pr-4 py-4 bg-white rounded-2xl border border-slate-200 shadow-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                   autofocus>
            <svg class="w-6 h-6 absolute left-4 top-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex-1 bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 font-bold text-slate-800 bg-slate-50/50">Search Results</div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse($searchResults as $product)
                <button wire:click="addToCart({{ $product->id }})" class="w-full flex items-center gap-4 p-3 rounded-xl hover:bg-indigo-50 transition-colors text-left group">
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex-shrink-0 group-hover:bg-white transition-colors"></div>
                    <div class="flex-1">
                        <h5 class="text-sm font-bold text-slate-900">{{ $product->name }}</h5>
                        <p class="text-xs text-slate-500">Barcode: {{ $product->barcode }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-indigo-600">${{ number_format($product->sale_price, 2) }}</p>
                        <p class="text-[10px] uppercase font-bold text-slate-400">{{ $product->stock_quantity }} in stock</p>
                    </div>
                </button>
                @empty
                    @if(strlen($search) > 0)
                    <p class="text-slate-400 text-sm text-center py-8 italic">No products found for "{{ $search }}"</p>
                    @else
                    <p class="text-slate-400 text-sm text-center py-8 italic">Start typing to search products</p>
                    @endif
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 gap-4">
            <button class="p-4 bg-white rounded-2xl border border-slate-200 shadow-md font-bold text-slate-700 hover:bg-slate-50 flex flex-col items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Quick Product
            </button>
            <button class="p-4 bg-white rounded-2xl border border-slate-200 shadow-md font-bold text-slate-700 hover:bg-slate-50 flex flex-col items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Add Customer
            </button>
        </div>
    </div>
</div>
