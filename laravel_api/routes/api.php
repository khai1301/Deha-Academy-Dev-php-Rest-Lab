<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/products', [ProductController::class, 'index']);

// Route::post('/products', [ProductController::class, 'store']);

// Route::get('/products/{$id}', [ProductController::class, 'show']);

Route::resource('products', ProductController::class);

Route::get('/products/search/{name}', [ProductController::class, 'search']);