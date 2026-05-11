<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('inventory')->group(function () {
    Route::post('/stock-in', [InventoryController::class, 'stockIn']);
    Route::post('/stock-out', [InventoryController::class, 'stockOut']);
    Route::post('/transfer', [InventoryController::class, 'transfer']);
    Route::post('/adjustment', [InventoryController::class, 'adjustment']);
});
