<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;

Route::prefix('auth')->group(function () { 
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);    
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('address', AddressController::class);
    Route::apiResource('orders', OrderController::class);

    Route::get('cart', [CartController::class, 'index']);
    Route::delete('cart', [CartController::class, 'clear']);


    Route::post('cart/items/{productId}', [CartItemController::class, 'store']);
    Route::put('cart/items/{productId}', [CartItemController::class, 'update']);
    Route::delete('cart/items/{productId}', [CartItemController::class, 'destroy']);
});


Route::prefix('admin')->group(function () {
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/dashboard', function (Request $request) {
            return response()->json(['message' => 'Welcome to the admin dashboard']);
        });
    });
});