<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\FeaturesController;
use App\Http\Controllers\API\DarshanTimingController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\BookingController;


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
Route::post('/register', [AuthController::class, 'register']);
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

    // All Routes for Features
    Route::get('/features', [FeaturesController::class, 'index']);
    Route::get('/features/{id}', [FeaturesController::class, 'getFeatureById']);
    Route::Post('/features', [FeaturesController::class, 'store']);
    Route::Put('/features/{id}', [FeaturesController::class, 'update']);
    Route::delete('/features/{id}', [FeaturesController::class, 'destroy']);
    //all routes for booking 

    
    //all routes for package
    Route::get('/package', [PackageController::class, 'index']);
    Route::get('/package/{id}', [PackageController::class, 'getPackageById']);
    Route::Post('/package', [PackageController::class, 'store']);
    Route::Put('/package/{id}', [PackageController::class, 'update']);
    Route::delete('/package/{id}', [PackageController::class, 'destroy']);  
    

    // All Routes for Darshan Timing
    Route::get('/darshantiming', [DarshanTimingController::class, 'index']);
    Route::get('/darshantiming/{id}', [DarshanTimingController::class, 'getDarshanTimingById']);
    Route::Post('/darshantiming', [DarshanTimingController::class, 'store']);
    Route::Put('/darshantiming/{id}', [DarshanTimingController::class, 'update']);
    Route::delete('/darshantiming/{id}', [DarshanTimingController::class, 'destroy']);

    // All Routes for Permissions
    Route::get('/permissions', [PermissionController::class, 'permissions']);
    Route::post('/role-has-permissions', [PermissionController::class, 'store_role_has_permissions']);
    Route::get('/role-has-permissions/{id}', [PermissionController::class, 'role_has_permissions']);
    Route::post('/user-has-permissions', [PermissionController::class, 'store_user_has_permissions']);
    Route::get('/user-has-permissions/{id}', [PermissionController::class, 'user_has_permissions']);
    Route::get('/user-has-permissions/{id}', [PermissionController::class, 'user_has_permissions']);
    Route::get('/permissions/distinct/name', [PermissionController::class, 'distinct_permissions']);
});


    Route::get('/booking', [BookingController::class, 'index']);
    Route::get('/booking/{id}', [BookingController::class, 'getBookingById']);
    Route::Post('/booking', [BookingController::class, 'store']);
    Route::Put('/booking/{id}', [BookingController::class, 'update']);
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']);  