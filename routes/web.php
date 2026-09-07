<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/// Ubah bagian ini di routes/web.php
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin', [ProductController::class, 'admin'])->name('products.admin');

Route::resource('products', ProductController::class)->except(['index']);