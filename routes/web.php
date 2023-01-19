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
Route::get('/food-packages', [FoodPackageController::class, 'index'])->name('food-package.index');

  Route::prefix('/products')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/new', [ProductController::class, 'Add'])->name('product.Add');
    Route::post('/products/new', [ProductController::class, 'CreateProduct'])->name('product.CreateProduct');
    Route::get('/products/{productId}', [ProductController::class, 'Edit'])->name('product.Edit');
    Route::patch('/products/{productId}', [ProductController::class, 'EditProduct'])->name('product.EditProduct');
    Route::delete('/products/{productId}', [ProductController::class, 'DeleteProduct'])->name('product.DeleteProduct');
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