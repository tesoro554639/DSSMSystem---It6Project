<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('stock-in/{bale}/add-items', [StockInController::class, 'addItems'])->name('stock-in.add-items');
    Route::resource('stock-in', StockInController::class);

    Route::post('suppliers/{supplier}/add-bales', [SupplierController::class, 'addBales'])->name('suppliers.add-bales');
    Route::resource('suppliers', SupplierController::class);

    Route::resource('payment_methods', PaymentMethodController::class);

    Route::post('items/{supplier}/add-items', [ItemsController::class, 'addItems'])->name('suppliers.add-items');
    Route::resource('items', ItemsController::class);

    Route::resource('sales', SalesController::class)->except(['edit', 'update']);
    Route::get('sales/receipt/{transaction}', [ReportsController::class, 'transactionReceipt'])->name('sales.receipt');

    Route::resource('inventory', InventoryController::class);

    Route::get('reports/daily-sales', [ReportsController::class, 'dailySales'])->name('reports.daily-sales');
    Route::get('reports/inventory-status', [ReportsController::class, 'inventoryStatus'])->name('reports.inventory-status');
    
    Route::get('reports/revenue-analytics', [ReportsController::class, 'revenueAnalytics'])->name('reports.revenue');

    Route::resource('categories', CategoryController::class);

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');
});