<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AfterCareController;
use App\Http\Controllers\AfterCareBookingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminAfterCareController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin Authentication API
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->middleware('auth:sanctum');

// Product API (CRUD)
Route::prefix('products')->group(function () {
    // Public routes
    Route::get('/', [ProductApiController::class, 'index']); // List all products
    Route::get('/{id}', [ProductApiController::class, 'show']); // Show one product
    
    // Admin only routes - Protected with Sanctum
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [ProductApiController::class, 'store']); // Add product (admin only)
        Route::put('/{id}', [ProductApiController::class, 'update']); // Update product (admin only)
        Route::delete('/{id}', [ProductApiController::class, 'destroy']); // Delete product (admin only)
    });
});

// Routes moved from web.php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/aftercare', [AfterCareController::class, 'index'])->name('aftercare');

// After Care Booking Routes
Route::get('/aftercare/booking', [AfterCareBookingController::class, 'showBookingForm'])->name('aftercare.booking');
Route::post('/aftercare/booking', [AfterCareBookingController::class, 'submitBooking'])->name('aftercare.booking.submit');

// Product Routes
Route::get('/shop', [ProductController::class, 'index'])->name('products.index');
Route::get('/shop/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        
        // Product Management
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        
        // After Care Reservations Management
        Route::get('/aftercare-reservations', [AdminAfterCareController::class, 'index'])->name('admin.aftercare.index');
        Route::patch('/aftercare-reservations/{id}/status', [AdminAfterCareController::class, 'updateStatus'])->name('admin.aftercare.updateStatus');
        Route::delete('/aftercare-reservations/{id}', [AdminAfterCareController::class, 'destroy'])->name('admin.aftercare.destroy');
        
        // Order Management
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::post('/orders/{id}/accept', [AdminOrderController::class, 'accept'])->name('admin.orders.accept');
        Route::post('/orders/{id}/decline', [AdminOrderController::class, 'decline'])->name('admin.orders.decline');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profile Settings Routes
    Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::put('/profile/address', [App\Http\Controllers\ProfileController::class, 'updateAddress'])->name('profile.updateAddress');
});
