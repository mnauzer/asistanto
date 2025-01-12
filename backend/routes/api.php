<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\PlaceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
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
});

// Public routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
