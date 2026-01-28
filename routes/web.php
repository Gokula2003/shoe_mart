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
use App\Http\Controllers\Admin\AdminOrderController;

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

// Cart Routes - Protected by Authentication
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
});

// Voucher Routes
Route::get('/vouchers', App\Livewire\VoucherShop::class)->name('vouchers.shop');
Route::get('/vouchers/success/{voucher}', function ($voucherId) {
    $voucher = App\Models\Voucher::findOrFail($voucherId);
    return view('vouchers.success', compact('voucher'));
})->name('vouchers.success');

// Gift Routes
Route::get('/gift', App\Livewire\SendGift::class)->name('gift.send');
Route::get('/gift/product/{productId}', function ($productId) {
    return (new App\Livewire\SendGift)->render()->with(['productId' => $productId]);
})->name('gift.product');
Route::get('/gift/success/{giftOrder}', function ($giftOrderId) {
    $giftOrder = App\Models\GiftOrder::findOrFail($giftOrderId);
    return view('gift.success', compact('giftOrder'));
})->name('gift.success');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    
    // Admin Creation Routes (protected - only accessible if no admins exist or in local environment)
    Route::middleware('allow.admin.creation')->group(function () {
        Route::get('/create-admin', [AdminAuthController::class, 'showCreateForm'])->name('admin.create.form');
        Route::post('/create-admin', [AdminAuthController::class, 'storeAdmin'])->name('admin.create.store');
    });
    
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
        
        // Add Product (Central page with combo box)
        Route::get('/add-product', function () {
            return view('admin.add-product');
        })->name('admin.add-product');
        
        // Voucher Management
        Route::get('/vouchers', [App\Http\Controllers\Admin\AdminVoucherController::class, 'index'])->name('admin.vouchers.index');
        Route::get('/vouchers/create', [App\Http\Controllers\Admin\AdminVoucherController::class, 'create'])->name('admin.vouchers.create');
        Route::post('/vouchers', [App\Http\Controllers\Admin\AdminVoucherController::class, 'store'])->name('admin.vouchers.store');
        Route::post('/vouchers/{id}/mark-used', [App\Http\Controllers\Admin\AdminVoucherController::class, 'markAsUsed'])->name('admin.vouchers.markAsUsed');
        Route::delete('/vouchers/{id}', [App\Http\Controllers\Admin\AdminVoucherController::class, 'destroy'])->name('admin.vouchers.destroy');
        
        // Gift Order Management
        Route::get('/gifts', [App\Http\Controllers\Admin\AdminGiftController::class, 'index'])->name('admin.gifts.index');
        Route::get('/gifts/create', [App\Http\Controllers\Admin\AdminGiftController::class, 'create'])->name('admin.gifts.create');
        Route::post('/gifts', [App\Http\Controllers\Admin\AdminGiftController::class, 'store'])->name('admin.gifts.store');
        Route::get('/gifts/{id}', [App\Http\Controllers\Admin\AdminGiftController::class, 'show'])->name('admin.gifts.show');
        Route::patch('/gifts/{id}/status', [App\Http\Controllers\Admin\AdminGiftController::class, 'updateStatus'])->name('admin.gifts.updateStatus');
        Route::patch('/gifts/{id}/tracking', [App\Http\Controllers\Admin\AdminGiftController::class, 'updateTracking'])->name('admin.gifts.updateTracking');
        Route::delete('/gifts/{id}', [App\Http\Controllers\Admin\AdminGiftController::class, 'destroy'])->name('admin.gifts.destroy');
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
    
    // User Voucher Routes
    Route::get('/my-vouchers', [App\Http\Controllers\VoucherController::class, 'myVouchers'])->name('vouchers.my');
    Route::post('/vouchers/apply', [App\Http\Controllers\VoucherController::class, 'apply'])->name('vouchers.apply');
    Route::post('/vouchers/remove', [App\Http\Controllers\VoucherController::class, 'remove'])->name('vouchers.remove');
    
    // User Gift Routes
    Route::get('/my-gifts', [App\Http\Controllers\GiftController::class, 'mySentGifts'])->name('gifts.my');
    Route::get('/gifts/{id}', [App\Http\Controllers\GiftController::class, 'show'])->name('gifts.show');
    Route::post('/gifts/{id}/cancel', [App\Http\Controllers\GiftController::class, 'cancel'])->name('gifts.cancel');
});

// API Documentation Route
Route::get('/api-documentation', function () {
    return view('api-documentation');
})->name('api.documentation');
