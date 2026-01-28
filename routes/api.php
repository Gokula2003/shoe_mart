<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\CartApiController;

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

// Cart API - Protected with Sanctum
Route::middleware(['auth:sanctum'])->prefix('cart')->group(function () {
    Route::get('/', [CartApiController::class, 'index']); // Get cart items
    Route::post('/', [CartApiController::class, 'store']); // Add to cart
    Route::put('/{id}', [CartApiController::class, 'update']); // Update cart item
    Route::delete('/{id}', [CartApiController::class, 'destroy']); // Remove from cart
    Route::delete('/', [CartApiController::class, 'clear']); // Clear cart
});

// Order API - Protected with Sanctum
Route::middleware(['auth:sanctum'])->prefix('orders')->group(function () {
    Route::get('/', [OrderApiController::class, 'index']); // Get user orders
    Route::get('/{id}', [OrderApiController::class, 'show']); // Get specific order
    Route::post('/', [OrderApiController::class, 'store']); // Create order
    Route::delete('/{id}', [OrderApiController::class, 'destroy']); // Cancel order
});
