<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Employees routes
Route::apiResource('employees', EmployeeController::class);

// Attendance routes
Route::apiResource('attendance', AttendanceController::class);

// Tasks routes (existing functionality)
Route::apiResource('tasks', TaskController::class);

// Test route for API (optional, for debugging purposes)
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
