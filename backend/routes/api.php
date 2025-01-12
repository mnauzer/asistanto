<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\InvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public routes with rate limiting
    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware(['throttle:6,1']); // 6 attempts per minute
    Route::post('auth/register', [AuthController::class, 'register'])
        ->middleware(['throttle:3,1']); // 3 attempts per minute

    // Protected routes with rate limiting
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
        // Auth routes
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Person routes
        Route::apiResource('persons', PersonController::class);
        Route::get('persons/type/{type}', [PersonController::class, 'getByType']);

        // Employee routes
        Route::apiResource('employees', EmployeeController::class);
        Route::post('employees/{employee}/rates', [EmployeeController::class, 'addRate']);
        Route::get('employees/{employee}/attendance', [EmployeeController::class, 'getAttendance']);

        // Inventory routes
        Route::apiResource('inventory', InventoryController::class);
        Route::get('inventory/category/{category}', [InventoryController::class, 'getByCategory']);
        Route::post('inventory/{item}/stock-adjustment', [InventoryController::class, 'adjustStock']);

        // Place routes
        Route::apiResource('places', PlaceController::class);
        Route::get('places/nearby', [PlaceController::class, 'getNearby']);

        // Quote routes
        Route::apiResource('quotes', QuoteController::class);

        // Order routes
        Route::apiResource('orders', OrderController::class);

        // Invoice routes
        Route::apiResource('invoices', InvoiceController::class);
    });
});
