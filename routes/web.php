<?php

use Illuminate\Support\Facades\Route;

// ─── User Routes ─────────────────────────────────────────────────────────────
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

// Store public pages
Route::get('/products', [App\Http\Controllers\ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductCatalogController::class, 'show'])->name('products.show');
Route::post('/products/{product:slug}/review', [App\Http\Controllers\ProductCatalogController::class, 'storeReview'])->name('products.review')->middleware('auth');
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::get('/about', fn() => view('store.about'))->name('about');

// Custom order (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/custom-order', [App\Http\Controllers\CustomOrderFormController::class, 'index'])->name('custom-order.index');
    Route::post('/custom-order', [App\Http\Controllers\CustomOrderFormController::class, 'store'])->name('custom-order.store');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// ─── Payment Routes ───────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{product}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{product}/order', [App\Http\Controllers\PaymentController::class, 'createOrder'])->name('payment.create');
    Route::get('/payment/finish', [App\Http\Controllers\PaymentController::class, 'finish'])->name('payment.finish');

    // Order tracking
    Route::get('/my-orders', [App\Http\Controllers\OrderTrackingController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [App\Http\Controllers\OrderTrackingController::class, 'show'])->name('orders.show');
});

// Webhook — tidak perlu auth, tapi perlu CSRF exempt
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    });

    Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

    // Protected admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

        // Products
        Route::post('products/{product}/primary-image', [App\Http\Controllers\Admin\ProductController::class, 'setPrimaryImage'])->name('products.primary-image');
        Route::delete('products/images/{image}', [App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.delete-image');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

        // Orders
        Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('orders/{order}/proof', [App\Http\Controllers\Admin\OrderController::class, 'uploadProof'])->name('orders.proof');
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->except(['create', 'store', 'edit', 'update']);

        // Custom Orders
        Route::patch('custom-orders/{customOrder}/status', [App\Http\Controllers\Admin\CustomOrderController::class, 'updateStatus'])->name('custom-orders.status');
        Route::patch('custom-orders/{customOrder}/price', [App\Http\Controllers\Admin\CustomOrderController::class, 'setPrice'])->name('custom-orders.price');
        Route::resource('custom-orders', App\Http\Controllers\Admin\CustomOrderController::class)->except(['create', 'store', 'edit', 'update']);

        // Posts
        Route::resource('posts', App\Http\Controllers\Admin\PostController::class);

        // Users
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });
});
