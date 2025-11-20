<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ClinicController as AdminClinic;
use App\Http\Controllers\Admin\DistributorController as AdminDistributor;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Clinic\DashboardController as ClinicDashboard;
use App\Http\Controllers\Clinic\ProductController as ClinicProduct;
use App\Http\Controllers\Clinic\OrderController as ClinicOrder;
use App\Http\Controllers\Distributor\DashboardController as DistributorDashboard;
use App\Http\Controllers\Distributor\ProductController as DistributorProduct;
use App\Http\Controllers\Distributor\OrderController as DistributorOrder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminDashboard::class, 'analytics'])->name('analytics');
    
    // Clinic Management
    Route::resource('clinics', AdminClinic::class);
    
    // Distributor Management
    Route::resource('distributors', AdminDistributor::class);
    
    // Product Management
    Route::get('/products', [AdminProduct::class, 'index'])->name('products.index');
    Route::get('/products/{product}/edit', [AdminProduct::class, 'edit'])->name('products.edit');
    Route::get('/products/pending', [AdminProduct::class, 'pending'])->name('products.pending');
    Route::put('/products/{product}/approve', [AdminProduct::class, 'approve'])->name('products.approve');
    Route::put('/products/{product}', [AdminProduct::class, 'update'])->name('products.update');
    Route::get('/products/{product}/custom-pricing', [AdminProduct::class, 'customPricing'])->name('products.custom-pricing');
    Route::post('/products/{product}/custom-pricing', [AdminProduct::class, 'storeCustomPricing'])->name('products.store-custom-pricing');
    Route::delete('/custom-pricing/{customPricing}', [AdminProduct::class, 'destroyCustomPricing'])->name('custom-pricing.destroy');
    
    // Order Management
    Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::get('/orders/pending/list', [AdminOrder::class, 'pending'])->name('orders.pending');
    Route::post('/orders/approve-all', [AdminOrder::class, 'approveAll'])->name('orders.approve-all');
    Route::put('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.update-status');
});

// Clinic Routes
Route::middleware(['auth'])->prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/dashboard', [ClinicDashboard::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [ClinicProduct::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ClinicProduct::class, 'show'])->name('products.show');
    
    // Cart & Orders
    Route::get('/cart', [ClinicOrder::class, 'cart'])->name('cart');
    Route::post('/cart/{product}', [ClinicOrder::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{product}', [ClinicOrder::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{product}', [ClinicOrder::class, 'removeFromCart'])->name('cart.remove');
    
    Route::get('/orders', [ClinicOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [ClinicOrder::class, 'create'])->name('orders.create');
    Route::post('/orders', [ClinicOrder::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [ClinicOrder::class, 'show'])->name('orders.show');
});

// Distributor Routes
Route::middleware(['auth'])->prefix('distributor')->name('distributor.')->group(function () {
    Route::get('/dashboard', [DistributorDashboard::class, 'index'])->name('dashboard');
    Route::get('/analytics', [DistributorDashboard::class, 'analytics'])->name('analytics');
    
    // Products
    Route::resource('products', DistributorProduct::class);
    
    // Orders
    Route::get('/orders', [DistributorOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/bulk', [DistributorOrder::class, 'bulkOrders'])->name('orders.bulk');
    Route::get('/orders/bulk/{bulkOrder}', [DistributorOrder::class, 'showBulkOrder'])->name('orders.bulk-show');
    Route::put('/orders/bulk/{bulkOrder}/status', [DistributorOrder::class, 'updateBulkOrderStatus'])->name('orders.update-bulk-status');
});

