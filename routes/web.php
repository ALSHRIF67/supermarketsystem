<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;

use App\Livewire\POS;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/pos', POS::class)->name('pos');
    Route::get('/products', function () { return 'Products coming soon'; })->name('products.index');
    Route::get('/inventory', function () { return 'Inventory coming soon'; })->name('inventory.index');
    Route::get('/sales', function () { return 'Sales coming soon'; })->name('sales.index');
    Route::get('/reports', function () { return 'Reports coming soon'; })->name('reports.index');
});
