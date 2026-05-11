<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class POS extends Component
{
    public $search = '';
    public $cart = [];
    public $total = 0;
    public $discount = 0;
    public $tax = 0;
    public $payable = 0;
    public $customers = [];
    public $selectedCustomer = null;
    public $paymentMethod = 'cash';
    
    protected $listeners = [
        'productUpdated' => 'refreshCartData',
        'cartUpdated' => 'calculateTotals'
    ];

    // New properties for editing/deleting products
    public $editingProduct = null;
    public $editingProductData = [
        'id' => null,
        'name' => '',
        'barcode' => '',
        'category_id' => '',
        'purchase_price' => 0,
        'sale_price' => 0,
        'stock_quantity' => 0,
        'low_stock_threshold' => 0,
        'expiry_date' => '',
    ];
    public $showEditModal = false;

    public function mount()
    {
        $this->customers = Customer::all();
    }

    public function updatedSearch()
    {
        if (strlen($this->search) > 0) {
            $product = Product::where('barcode', $this->search)
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->first();

            if ($product && $product->barcode === $this->search) {
                $this->addToCart($product->id);
                $this->search = '';
            }
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) return;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
            ];
        }

        $this->calculateTotals();
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateTotals();
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            unset($this->cart[$productId]);
        }
        $this->calculateTotals();
    }

    // New: Edit product directly from POS
    public function editProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->editingProductData = [
            'id' => $product->id,
            'name' => $product->name,
            'barcode' => $product->barcode,
            'category_id' => $product->category_id,
            'purchase_price' => $product->purchase_price,
            'sale_price' => $product->sale_price,
            'stock_quantity' => $product->stock_quantity,
            'low_stock_threshold' => $product->low_stock_threshold,
            'expiry_date' => $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '',
        ];
        $this->showEditModal = true;
    }

    public function updateProduct()
    {
        $this->validate([
            'editingProductData.name' => 'required|string|max:255',
            'editingProductData.category_id' => 'required|exists:categories,id',
            'editingProductData.barcode' => 'nullable|string|unique:products,barcode,' . $this->editingProductData['id'],
            'editingProductData.purchase_price' => 'required|numeric|min:0',
            'editingProductData.sale_price' => 'required|numeric|min:0',
            'editingProductData.stock_quantity' => 'required|integer|min:0',
            'editingProductData.low_stock_threshold' => 'nullable|integer|min:0',
            'editingProductData.expiry_date' => 'nullable|date',
        ]);

        $product = Product::findOrFail($this->editingProductData['id']);
        $product->update([
            'name' => $this->editingProductData['name'],
            'slug' => \Illuminate\Support\Str::slug($this->editingProductData['name'], '-', null), // Support UTF-8/Arabic
            'barcode' => $this->editingProductData['barcode'],
            'category_id' => $this->editingProductData['category_id'],
            'purchase_price' => $this->editingProductData['purchase_price'],
            'sale_price' => $this->editingProductData['sale_price'],
            'stock_quantity' => $this->editingProductData['stock_quantity'],
            'low_stock_threshold' => $this->editingProductData['low_stock_threshold'],
            'expiry_date' => $this->editingProductData['expiry_date'],
        ]);

        // Sync with cart if product is in cart
        if (isset($this->cart[$product->id])) {
            $this->cart[$product->id]['name'] = $product->name;
            $this->cart[$product->id]['price'] = $product->sale_price;
        }

        $this->calculateTotals();
        $this->showEditModal = false;
        $this->dispatch('productUpdated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'تم تحديث المنتج بنجاح!']);
    }

    // New: Delete product from system
    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Remove from cart if exists
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->calculateTotals();
        }

        $product->delete();
        $this->dispatch('productUpdated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'تم حذف المنتج بنجاح!']);
    }

    public function refreshCartData()
    {
        foreach ($this->cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $this->cart[$productId]['name'] = $product->name;
                $this->cart[$productId]['price'] = $product->sale_price;
            } else {
                // Product was deleted
                unset($this->cart[$productId]);
            }
        }
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $this->payable = $this->total - $this->discount + $this->tax;
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Cart is empty']);
            return;
        }

        $saleData = DB::transaction(function () {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $this->selectedCustomer,
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'total_amount' => $this->total,
                'discount_amount' => $this->discount,
                'tax_amount' => $this->tax,
                'payable_amount' => $this->payable,
                'paid_amount' => $this->payable,
                'payment_method' => $this->paymentMethod,
                'payment_status' => 'paid',
            ]);

            $items = [];
            foreach ($this->cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                $items[] = [
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ];

                // Update stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            $paymentMethods = [
                'cash' => 'نقداً',
                'card' => 'بطاقة',
                'credit' => 'آجل',
            ];

            return [
                'invoice_number' => $sale->invoice_number,
                'date' => $sale->created_at->format('Y-m-d H:i'),
                'customer' => $sale->customer ? $sale->customer->name : 'عميل نقدي',
                'items' => $items,
                'subtotal' => $sale->total_amount,
                'discount' => $sale->discount_amount,
                'tax' => $sale->tax_amount,
                'total' => $sale->total_amount,
                'payable' => $sale->payable_amount,
                'payment_method' => $paymentMethods[$sale->payment_method] ?? $sale->payment_method,
                'cashier' => auth()->user()->name,
            ];
        });

        $this->cart = [];
        $this->calculateTotals();
        $this->dispatch('sale-completed', saleData: $saleData);
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Sale completed successfully!']);
    }

    public function render()
    {
        $products = [];
        if (strlen($this->search) > 0) {
            $products = Product::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('barcode', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
        }

        return view('livewire.p-o-s', [
            'searchResults' => $products,
            'categories' => \App\Models\Category::all()
        ])->layout('layouts.app', ['header' => 'Point of Sale']);
    }
}
