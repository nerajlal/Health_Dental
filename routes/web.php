<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PartnerRequestController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ClinicController as AdminClinic;
use App\Http\Controllers\Admin\DistributorController as AdminDistributor;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Clinic\DashboardController as ClinicDashboard;
use App\Http\Controllers\Clinic\ProductController as ClinicProduct;
use App\Http\Controllers\Clinic\OrderController as ClinicOrder;
use App\Http\Controllers\Clinic\BagController as ClinicBag;
use App\Http\Controllers\Distributor\CompetitionController;
use App\Http\Controllers\Distributor\DashboardController as DistributorDashboard;
use App\Http\Controllers\Distributor\ProductController as DistributorProduct;
use App\Http\Controllers\Distributor\OrderController as DistributorOrder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/about', [LandingController::class, 'about'])->name('landing.about');
Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');

// Partner Request
Route::post('/partner-request', [PartnerRequestController::class, 'store'])->name('partner.request.store');

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

    // Clinic Partner Request Approvals
    Route::post('/clinics/approve-request/{id}', [AdminClinic::class, 'approveRequest'])->name('clinics.approve-request');
    Route::post('/clinics/reject-request/{id}', [AdminClinic::class, 'rejectRequest'])->name('clinics.reject-request');

    // Distributor Partner Request Approvals
    Route::post('/distributors/approve-request/{id}', [AdminDistributor::class, 'approveRequest'])->name('distributors.approve-request');
    Route::post('/distributors/reject-request/{id}', [AdminDistributor::class, 'rejectRequest'])->name('distributors.reject-request');
    
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

    // Margins & Profit Analysis
    Route::get('/margins', [App\Http\Controllers\Admin\MarginController::class, 'index'])->name('margin');
    Route::get('/margins/product-analysis', [App\Http\Controllers\Admin\MarginController::class, 'productAnalysis'])->name('margin.products');
    Route::get('/margins/distributor-analysis', [App\Http\Controllers\Admin\MarginController::class, 'distributorAnalysis'])->name('margin.distributors');

    // Product Requests
    Route::get('/product-requests', [App\Http\Controllers\Admin\ProductRequestController::class, 'index'])->name('product-requests.index');
    Route::get('/product-requests/{productRequest}', [App\Http\Controllers\Admin\ProductRequestController::class, 'show'])->name('product-requests.show');
    Route::post('/product-requests/{productRequest}/approve', [App\Http\Controllers\Admin\ProductRequestController::class, 'approve'])->name('product-requests.approve');
    Route::post('/product-requests/{productRequest}/reject', [App\Http\Controllers\Admin\ProductRequestController::class, 'reject'])->name('product-requests.reject');
    Route::put('/product-requests/{productRequest}/status', [App\Http\Controllers\Admin\ProductRequestController::class, 'updateStatus'])->name('product-requests.update-status');
});

// Clinic Routes
Route::middleware(['auth'])->prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/dashboard', [ClinicDashboard::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [ClinicProduct::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ClinicProduct::class, 'show'])->name('products.show');

    // Product Requests
    Route::get('/product-requests', [App\Http\Controllers\Clinic\ProductRequestController::class, 'index'])->name('product-requests.index');
    Route::post('/product-requests', [App\Http\Controllers\Clinic\ProductRequestController::class, 'store'])->name('product-requests.store');
    Route::get('/product-requests/{productRequest}', [App\Http\Controllers\Clinic\ProductRequestController::class, 'show'])->name('product-requests.show');

    // Single product checkout from cart
    Route::post('/orders/checkout-single/{product}', [App\Http\Controllers\Clinic\OrderController::class, 'checkoutSingle'])->name('orders.checkout-single');
    
    // Cart & Orders
    Route::get('/cart', [ClinicOrder::class, 'cart'])->name('cart');
    Route::post('/cart/{product}', [ClinicOrder::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{product}', [ClinicOrder::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{product}', [ClinicOrder::class, 'removeFromCart'])->name('cart.remove');
    
    Route::get('/orders', [ClinicOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [ClinicOrder::class, 'create'])->name('orders.create');
    Route::post('/orders', [ClinicOrder::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [ClinicOrder::class, 'show'])->name('orders.show');

    // Bag Routes
    Route::get('/bag', [ClinicBag::class, 'index'])->name('bag.index');
    Route::post('/bag/add/{product}', [ClinicBag::class, 'add'])->name('bag.add');
    Route::put('/bag/update/{product}', [ClinicBag::class, 'update'])->name('bag.update');
    Route::delete('/bag/remove/{product}', [ClinicBag::class, 'remove'])->name('bag.remove');
    Route::post('/bag/quick-order', [ClinicBag::class, 'quickOrder'])->name('bag.quick-order');
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

    // Distributor Analytics
    Route::get('/analytics', [App\Http\Controllers\Distributor\AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/products', [App\Http\Controllers\Distributor\AnalyticsController::class, 'productAnalysis'])->name('analytics.products');
    Route::get('/analytics/clinics', [App\Http\Controllers\Distributor\AnalyticsController::class, 'clinicAnalysis'])->name('analytics.clinics');

    // Mark order items as shipped
    Route::put('/order-items/{orderItem}/mark-shipped', [DistributorOrder::class, 'markAsShipped'])->name('order-items.mark-shipped');
    Route::put('/order-items/{orderItem}/mark-not-shipped', [DistributorOrder::class, 'markAsNotShipped'])->name('order-items.mark-not-shipped');

    // Product Requests
    Route::get('/product-requests', [App\Http\Controllers\Distributor\ProductRequestController::class, 'index'])->name('product-requests.index');
    Route::get('/product-requests/{productRequest}', [App\Http\Controllers\Distributor\ProductRequestController::class, 'show'])->name('product-requests.show');
    Route::get('/product-requests/{productRequest}/create-product', [App\Http\Controllers\Distributor\ProductRequestController::class, 'createProduct'])->name('product-requests.create-product');
    Route::post('/product-requests/{productRequest}/store-product', [App\Http\Controllers\Distributor\ProductRequestController::class, 'storeProduct'])->name('product-requests.store-product');
    Route::post('/product-requests/{productRequest}/fulfill', [App\Http\Controllers\Distributor\ProductRequestController::class, 'fulfill'])->name('product-requests.fulfill');

    // Competition Routes
    Route::get('/competition', [CompetitionController::class, 'index'])->name('competition.index');
    Route::get('/competition/product/{product}', [CompetitionController::class, 'productComparison'])->name('competition.product');
});

