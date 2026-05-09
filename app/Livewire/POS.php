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
                $product->decrement('stock_quantity', $item['quantity']);
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
            'searchResults' => $products
        ])->layout('layouts.app', ['header' => 'Point of Sale']);
    }
}
