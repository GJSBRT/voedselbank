<?php

use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuantityProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/food-packages', [FoodPackageController::class, 'index'])->name('food-package.index');
    Route::get('/quantity-products', [QuantityProductsController::class, 'index'])->name('quantity-products.index');
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');

    Route::prefix('/food-packages')->group(function () {
        Route::get('/', [FoodPackageController::class, 'index'])->name('food-packages.index');
        Route::get('/new', [FoodPackageController::class, 'new'])->name('food-packages.new');
        Route::post('/new', [FoodPackageController::class, 'create'])->name('food-packages.create');
        Route::get('/{foodPackageId}', [FoodPackageController::class, 'view'])->name('food-packages.view');
        Route::patch('/{foodPackageId}', [FoodPackageController::class, 'update'])->name('food-packages.update');
    });

    Route::prefix('/customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/new', [CustomerController::class, 'new'])->name('customers.new');
        Route::post('/new', [CustomerController::class, 'create'])->name('customers.create');
        Route::get('/{customerId}', [CustomerController::class, 'view'])->name('customers.view');
        Route::get('/{customerId}/export', [CustomerController::class, 'export'])->name('customer.export');
        Route::patch('/{customerId}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{customerId}/delete', [CustomerController::class, 'delete'])->name('customers.delete');
    });

    Route::prefix('/suppliers')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/new', [SupplierController::class, 'new'])->name('suppliers.new');
        Route::post('/new', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::delete('/delete/{id}', [SupplierController::class, 'delete'])->name('suppliers.delete');
        Route::get('/{id}', [SupplierController::class, 'view'])->name('suppliers.view');
        Route::patch('/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    });

    Route::prefix('/deliveries')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('deliveries.index');
        Route::get('/new', [DeliveryController::class, 'new'])->name('deliveries.new');
        Route::post('/new', [DeliveryController::class, 'create'])->name('deliveries.create');
        Route::delete('/delete/{id}', [DeliveryController::class, 'delete'])->name('deliveries.delete');
        Route::get('/{id}', [DeliveryController::class, 'view'])->name('deliveries.view');
        Route::patch('/{id}', [DeliveryController::class, 'update'])->name('deliveries.update');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/new', [UserController::class, 'new'])->name('users.new');
        Route::post('/new', [UserController::class, 'create'])->name('users.create');
        Route::get('/{userId}', [UserController::class, 'view'])->name('users.view');
        Route::patch('/{userId}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{userId}', [UserController::class, 'delete'])->name('users.delete');
    });

    Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/new', [RoleController::class, 'new'])->name('roles.new');
        Route::post('/new', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/{roleId}', [RoleController::class, 'view'])->name('roles.view');
        Route::patch('/{roleId}', [RoleController::class, 'update'])->name('roles.update');
    });
});

Route::prefix('/search')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'search']);
    Route::get('/products', [ProductController::class, 'search']);
    Route::get('/roles', [RoleController::class, 'search']);
});
