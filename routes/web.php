<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('prevent_admin_storefront_cart')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::get('/dashboard', function () {
    if (auth()->user()?->isCustomer()) {
        return redirect()->route('home');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('prevent_admin_storefront_cart')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    });

    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('my-orders.show');
    Route::post('/my-orders/{order}/pay', [CustomerPaymentController::class, 'store'])->name('my-orders.pay');
    Route::post('/my-orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])
        ->middleware('role:customer')
        ->name('my-orders.cancel');

    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::patch('/products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('products.toggle-active');

    Route::get('/stocks', [AdminStockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks', [AdminStockController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/history', [AdminStockController::class, 'history'])->name('stocks.history');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/ready', [AdminOrderController::class, 'markReady'])->name('orders.ready');
    Route::post('/orders/{order}/picked-up', [AdminOrderController::class, 'markPickedUp'])->name('orders.picked-up');
    Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/reports/sales', [AdminReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/print', [AdminReportController::class, 'salesPrint'])->name('reports.sales.print');
});

require __DIR__.'/auth.php';
