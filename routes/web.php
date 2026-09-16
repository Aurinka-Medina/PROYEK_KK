<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/// Ubah bagian ini di routes/web.php
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin', [ProductController::class, 'admin'])->name('products.admin');

Route::resource('products', ProductController::class)->except(['index']);

// Shopping Cart
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::patch('/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::get('/cart/checkout', [CartController::class, 'checkout'])
    ->name('cart.checkout');