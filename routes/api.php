<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/login',function() {
    return response()->json(array("message" => "Unauthenticated."));
})->name('login');  
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Route for Role
    Route::get('/role', [RoleController::class, 'index']);
    Route::get('/role/{id}', [RoleController::class, 'getById']);
    Route::post('/role', [RoleController::class, 'store']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);


    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'getUserById']);
    Route::Post('/user', [UserController::class, 'store']);
    Route::Post('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // All Routes for Permissions
    Route::get('/permissions', [PermissionController::class, 'permissions']);
    Route::post('/role-has-permissions', [PermissionController::class, 'store_role_has_permissions']);
    Route::get('/role-has-permissions/{id}', [PermissionController::class, 'role_has_permissions']);
    Route::post('/user-has-permissions', [PermissionController::class, 'store_user_has_permissions']);
    Route::get('/user-has-permissions/{id}', [PermissionController::class, 'user_has_permissions']);
    Route::get('/user-has-permissions/{id}', [PermissionController::class, 'user_has_permissions']);
    Route::get('/permissions/distinct/name', [PermissionController::class, 'distinct_permissions']);
});
