<?php

use App\Http\Controllers\admin\brandController;
use App\Http\Controllers\admin\categoreyController;
use App\Http\Controllers\admin\colorSizesController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\mail\MailController;
use App\Http\Controllers\orders\cartController;
use App\Http\Controllers\orders\orderController;
use App\Http\Controllers\reviews\blogConteroller;
use App\Http\Middleware\checkAdmin;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
    Route::post('/user/address', [AuthController::class, 'addAddress'])->middleware('auth:api');
});

Route::middleware(checkAdmin::class)->group(function () {
    Route::controller(brandController::class)->group(function () {
        Route::get('/brands/{lang}', 'index');
        Route::get('/brand/{lang}/{id}', 'show');
        Route::post('/brand/{lang}', 'store');
        Route::post('/brand/{lang}/{id}', 'update');
        Route::delete('/brand/{lang}/{id}', 'destroy');
        Route::get('/brand/{lang}/{id}/products', 'products');
    });

    Route::controller(categoreyController::class)->group(function () {
        Route::get('/categories/{lang}', 'index');
        Route::get('/category/{lang}/{id}', 'show');
        Route::post('/category/{lang}', 'store');
        Route::post('/category/{lang}/{id}', 'update');
        Route::delete('/category/{lang}/{id}', 'destroy');
        Route::get('/category/{lang}/{id}/products', 'products');
    });

    Route::controller(productController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/product/{id}', 'show');
        Route::post('/product', 'store');
        Route::post('/product/{id}', 'update');
        Route::delete('/product/{id}','destroy');
        Route::get('/product/{id}/colors', 'colors');
        Route::get('/product/{id}/sizes', 'sizes');
        Route::get('/product/{id}/colorSizes', 'colorSizes');
    });

    Route::controller(colorSizesController::class)->group(function () {
        Route::post('/addColor', 'addColor');
        Route::post('/addSize', 'addSize');
        Route::get('/colors', 'getAllColors');
        Route::get('/sizes', 'getAllSizes');
    });

});



Route::controller(cartController::class)->group(function () {
    Route::post('/cart', 'addToCart');
    Route::get('/cart', 'getCartItems');
    Route::delete('/cart', 'deleteFromCart');
    Route::delete('/cart/clear', 'clearCart');
});

Route::controller(orderController::class)->group(function () {
    Route::get('/orders', 'index')->middleware(checkAdmin::class);
    Route::get('/order/{id}', 'show');
    Route::post('/order', 'store');
    Route::get('/user/orders', 'getUserOrders');
    Route::post('/order/{id}/status', 'ChangeStatus');
    Route::delete('/order/{id}', 'destroy');
});

Route::controller(MailController::class)->group(function () {
    Route::post('/send-email', 'sendEmail')->middleware(checkAdmin::class);
    Route::get('/send-email', 'sendEmail');
});


Route::controller(blogConteroller::class)->group(function () {
    Route::get('/blogs', 'index');
    Route::get('/blog/{id}', 'show');
    Route::post('/blog', 'store');
    Route::post('/blog/{id}', 'update');
    Route::delete('/blog/{id}', 'destroy');
});
