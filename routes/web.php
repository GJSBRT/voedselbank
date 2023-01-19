<?php

use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/food-packages', [FoodPackageController::class, 'index'])->name('food-package.index');
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/new', [ProductController::class, 'Add'])->name('product.Add');
    Route::post('/products/new', [ProductController::class, 'CreateProduct'])->name('product.CreateProduct');
    Route::get('/products/{productId}', [ProductController::class, 'Edit'])->name('product.Edit');
    Route::patch('/products/{productId}', [ProductController::class, 'EditProduct'])->name('product.EditProduct');
    Route::delete('/products/{productId}', [ProductController::class, 'DeleteProduct'])->name('product.DeleteProduct');
});