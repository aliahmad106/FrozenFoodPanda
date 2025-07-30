<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest routes (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes (only accessible when logged in)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{cartItemId}', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    
    // User routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders.history');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    
    // Order history
    Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
    
    // Product reviews
    Route::post('/products/{id}/review', [ProductController::class, 'addReview'])
        ->name('products.review');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Product management
    Route::get('/products', [App\Http\Controllers\Admin\ProductManagementController::class, 'index'])
        ->name('admin.products');
    Route::get('/analytics', [App\Http\Controllers\Admin\ProductManagementController::class, 'analytics'])
        ->name('admin.analytics');

    Route::get('/products/create', [App\Http\Controllers\Admin\ProductManagementController::class, 'create'])
        ->name('admin.products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductManagementController::class, 'store'])
        ->name('admin.products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Admin\ProductManagementController::class, 'edit'])
        ->name('admin.products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductManagementController::class, 'update'])
        ->name('admin.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductManagementController::class, 'destroy'])
        ->name('admin.products.destroy');
    Route::post('/products/{product}/toggle-active', [App\Http\Controllers\Admin\ProductManagementController::class, 'toggleActive'])
        ->name('admin.products.toggle-active');

    // Order management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])
        ->name('admin.orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])
        ->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])
        ->name('admin.orders.update-status');
    Route::post('/orders/{order}/refund', [App\Http\Controllers\Admin\OrderController::class, 'processRefund'])
        ->name('admin.orders.refund');

    // Review management
    Route::get('/reviews', [ReviewController::class, 'index'])
        ->name('admin.reviews.index');
    Route::patch('/reviews/{review}/moderate', [ReviewController::class, 'moderate'])
        ->name('admin.reviews.moderate');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('admin.reviews.destroy');
});

// Public routes
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/shipping', function () {
    return view('shipping');
})->name('shipping');

Route::get('/returns', function () {
    return view('returns');
})->name('returns');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'sendMessage'])->name('contact.send');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');