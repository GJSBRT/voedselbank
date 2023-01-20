<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/new', [UserController::class, 'new'])->name('users.new');
        Route::post('/new', [UserController::class, 'create'])->name('users.create');
        Route::get('/{userId}', [UserController::class, 'view'])->name('users.view');
        Route::patch('/{userId}', [UserController::class, 'update'])->name('users.update');
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

Route::get('/permissions', [PermissionController::class, 'permissions']);