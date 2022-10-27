<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('products', [ProductController::class, 'index'])->name('products');
Route::post('products',[ProductController::class, 'store']);
Route::post('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');

Route::get('services', [ServiceController::class, 'index'])->name('services');
Route::post('services',[ServiceController::class, 'store']);
Route::post('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');

