<?php

use Illuminate\Http\Request;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;

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

Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');
    Route::apiResource('users', 'UserController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_USER_MANAGE);
    Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::apiResource('roles', 'RoleController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
   
    // Route::apiResource('expenses', 'ExpenseController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('expense_categories', 'ExpenseCategoryController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('expense_subcategories', 'ExpenseSubcategoryController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('incomes', 'IncomeController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('income_categories', 'IncomeCategoryController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('income_subcategories', 'IncomeSubcategoryController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('jobs', 'JobController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('employees', 'EmployeeController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('employee_wages', 'EmployeeWageController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('customers', 'CustomerController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('orders', 'OrderController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('order_types', 'OrderTypeController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('order_statuses', 'OrderStatusController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
    // Route::apiResource('accounts', 'AccountController')->middleware('permission:' . \App\Laravue\Acl::PERMISSION_PERMISSION_MANAGE);
});

// Route::apiResource('workhours', 'WorkhourController');
Route::apiResource('workhours', 'WorkhourController');
Route::apiResource('expenses', 'ExpenseController');
Route::apiResource('expense_categories', 'ExpenseCategoryController');
Route::apiResource('expense_subcategories', 'ExpenseSubcategoryController');
Route::apiResource('incomes', 'IncomeController');
Route::apiResource('income_categories', 'IncomeCategoryController');
Route::apiResource('income_subcategories', 'IncomeSubcategoryController');
Route::apiResource('jobs', 'JobController');
Route::apiResource('employees', 'EmployeeController');
Route::apiResource('employee_wages', 'EmployeeWageController');
Route::apiResource('customers', 'CustomerController');
Route::apiResource('suppliers', 'SupplierController');
Route::apiResource('orders', 'OrderController');
Route::apiResource('order_types', 'OrderTypeController');
Route::apiResource('order_statuses', 'OrderStatusController');
Route::apiResource('accounts', 'AccountController');



