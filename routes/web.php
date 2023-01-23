<?php

use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Http\Controllers\Customer\CustomerController;
use \App\Http\Controllers\Category\CategoryController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::prefix('/food-packages')->group(function () {
        Route::get('/', [FoodPackageController::class, 'index'])->name('food-packages.index');
        Route::get('/new', [FoodPackageController::class, 'new'])->name('food-packages.new');
        Route::post('/new', [FoodPackageController::class, 'create'])->name('food-packages.create');
        Route::get('/{foodPackageId}', [FoodPackageController::class, 'view'])->name('food-packages.view');
        Route::patch('/{foodPackageId}', [FoodPackageController::class, 'update'])->name('food-packages.update');
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/new', [CustomerController::class, 'add'])->name('customer.add');
        Route::post('/new', [CustomerController::class, 'registerCustomer'])->name('customer.registercustomer');
        Route::get('/{customerId}', [CustomerController::class, 'view'])->name('customer.view');
        Route::patch('/{customerId}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/{customerId}/delete', [CustomerController::class, 'confirmation'])->name('customer.confirmation');
        Route::delete('/{customerId}/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    });

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/new', [CategoryController::class, 'new'])->name('categories.new');
        Route::post('/new', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('/{categoryId}', [CategoryController::class, 'view'])->name('categories.view');
        Route::patch('/{categoryId}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{categoryId}', [CategoryController::class, 'delete'])->name('categories.delete');
    });
});

Route::prefix('/search')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'search']);
    Route::get('/products', [ProductController::class, 'search']);
});

