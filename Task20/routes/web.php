<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
   return redirect()->route('catalog');
});

Route::get('catalog', [OrderController::class, 'index'])->name('catalog');
Route::post('catalog/{product}', [OrderController::class, 'store'])->name('catalog.store');

Route::get('products', [ProductController::class, 'index'])->name('products');
Route::post('products',[ProductController::class, 'store']);
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('services', [ServiceController::class, 'index'])->name('services');
Route::post('services',[ServiceController::class, 'store']);
Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');


