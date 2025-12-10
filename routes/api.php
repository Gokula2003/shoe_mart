<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\AuthController;

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
