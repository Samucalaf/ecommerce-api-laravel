<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () { 
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);    
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::prefix('admin')->group(function () {
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/dashboard', function (Request $request) {
            return response()->json(['message' => 'Welcome to the admin dashboard']);
        });
    });
});