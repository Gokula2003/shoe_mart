<?php

use Illuminate\Support\Facades\Route;
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
