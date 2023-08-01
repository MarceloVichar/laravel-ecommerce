<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show']);
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update']);

    Route::apiResource('/companies', CompanyController::class);

    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/products-categories', \App\Http\Controllers\ProductCategoryController::class);

    Route::apiResource('/customers', \App\Http\Controllers\CustomerController::class);
    Route::apiResource('/admins', \App\Http\Controllers\AdminController::class);

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'show']);
    Route::put('/cart/finish', [\App\Http\Controllers\CartController::class, 'finish']);
    Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'destroy']);

    Route::apiResource('/cart/items', \App\Http\Controllers\CartItemController::class)
        ->only(['show', 'update', 'delete']);

});
