<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\POS;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/pos', POS::class)->name('pos');
    
    // Inventory Management
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    // Inventory Management
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/stock-in', [\App\Http\Controllers\InventoryController::class, 'stockIn'])->name('inventory.stock-in');
    Route::post('/inventory/stock-out', [\App\Http\Controllers\InventoryController::class, 'stockOut'])->name('inventory.stock-out');
    Route::post('/inventory/transfer', [\App\Http\Controllers\InventoryController::class, 'transfer'])->name('inventory.transfer');
    Route::post('/inventory/adjustment', [\App\Http\Controllers\InventoryController::class, 'adjustment'])->name('inventory.adjustment');
    
    // Sales Management
    Route::get('/sales', [\App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [\App\Http\Controllers\SaleController::class, 'show'])->name('sales.show');

    // Business Management
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::post('/expense-categories', [\App\Http\Controllers\ExpenseController::class, 'storeCategory'])->name('expense-categories.store');

    
    // Reports & Analytics
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});
