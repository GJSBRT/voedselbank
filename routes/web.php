<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

  Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/new', [ProductController::class, 'add'])->name('product.add');
    Route::post('/new', [ProductController::class, 'create'])->name('product.create');
    Route::get('/{productId}', [ProductController::class, 'edit'])->name('product.edit');
    Route::patch('/{productId}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/{productId}', [ProductController::class, 'delete'])->name('product.delete');
  });

    Route::prefix('/food-packages')->group(function () {
        Route::get('/', [FoodPackageController::class, 'index'])->name('food-packages.index');
        Route::get('/new', [FoodPackageController::class, 'new'])->name('food-packages.new');
        Route::post('/new', [FoodPackageController::class, 'create'])->name('food-packages.create');
        Route::get('/{foodPackageId}', [FoodPackageController::class, 'view'])->name('food-packages.view');
        Route::patch('/{foodPackageId}', [FoodPackageController::class, 'update'])->name('food-packages.update');
    });
});


Route::prefix('/search')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'search']);
    Route::get('/products', [ProductController::class, 'search']);

});