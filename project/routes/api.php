<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProductController;
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
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'show']);
    Route::put('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'update']);

    Route::middleware('admin')->group(function () {

        Route::apiResource('/admin/companies', CompanyController::class);

        Route::apiResource('/admin/products', ProductController::class);

        Route::apiResource('/admin/products-categories', \App\Http\Controllers\Admin\ProductCategoryController::class);

        Route::apiResource('/admin/customers', \App\Http\Controllers\Admin\CustomerController::class);

        Route::apiResource('/admin/admins', \App\Http\Controllers\Admin\AdminController::class);

        Route::apiResource('/admin/orders', \App\Http\Controllers\Admin\OrderController::class)
            ->only(['index', 'show']);
    });

    Route::middleware('customer')->group(function () {

        Route::apiResource('/customer/companies', \App\Http\Controllers\Customer\CompanyController::class)
            ->only(['index', 'show']);

        Route::apiResource('/customer/products-categories', \App\Http\Controllers\Customer\ProductCategoryController::class)
            ->only(['index', 'show']);

        Route::apiResource('/customer/products', \App\Http\Controllers\Customer\ProductController::class)
            ->only(['index', 'show']);

        Route::post('/customer/products/{product}/add-to-cart', [\App\Http\Controllers\Customer\ProductController::class, 'addToCart']);

        Route::get('/customer/cart', [\App\Http\Controllers\Customer\CartController::class, 'show']);
        Route::put('/customer/cart/finish', [\App\Http\Controllers\Customer\CartController::class, 'finish']);
        Route::delete('/customer/cart', [\App\Http\Controllers\Customer\CartController::class, 'destroy']);

        Route::apiResource('/customer/cart/items', \App\Http\Controllers\Customer\CartItemController::class)
            ->only(['show', 'update', 'destroy']);

        Route::apiResource('/customer/orders', \App\Http\Controllers\Customer\OrderController::class)
            ->only(['index', 'show']);
    });

    Route::middleware('company')->group(function () {
        Route::apiResource('/company/products-categories', \App\Http\Controllers\Customer\ProductCategoryController::class)
            ->only(['index', 'show']);

        Route::get('/company/my-company', [\App\Http\Controllers\Company\CompanyController::class, 'show']);
        Route::put('/company/my-company', [\App\Http\Controllers\Company\CompanyController::class, 'update']);
        Route::delete('/company/my-company', [\App\Http\Controllers\Company\CompanyController::class, 'destroy']);

        Route::apiResource('/company/products', \App\Http\Controllers\Company\ProductController::class);

        Route::apiResource('/company/orders', \App\Http\Controllers\Customer\OrderController::class)
            ->only(['index', 'show']);
    });

});
