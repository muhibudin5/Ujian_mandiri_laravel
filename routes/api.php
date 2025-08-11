<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {

    // Semua role bisa CRUD Product
    Route::apiResource('products', ProductController::class);

    // Khusus admin bisa CRUD Category
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('categories', CategoryController::class);
    });
});
