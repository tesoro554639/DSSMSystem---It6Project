<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockInController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('stock-in', StockInController::class)->except(['edit', 'update']);
    Route::post('stock-in/{bale}/add-items', [StockInController::class, 'addItems'])->name('stock-in.add-items');

    Route::resource('sales', SalesController::class)->except(['edit', 'update']);
    Route::get('sales/receipt/{transaction}', [ReportsController::class, 'transactionReceipt'])->name('sales.receipt');

    Route::resource('inventory', InventoryController::class)->only(['index', 'show']);

    Route::get('reports/daily-sales', [ReportsController::class, 'dailySales'])->name('reports.daily-sales');
    Route::get('reports/inventory-status', [ReportsController::class, 'inventoryStatus'])->name('reports.inventory-status');

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');
});