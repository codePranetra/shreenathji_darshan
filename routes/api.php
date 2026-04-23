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
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\Service2Controller;

Route::get('/login', function () {
    return response()->json(["message" => "Unauthenticated."]);
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// ================= PUBLIC GET ROUTES ================= //

// Role
Route::get('/role', [RoleController::class, 'index']);
Route::get('/role/{id}', [RoleController::class, 'getById']);

// ================= BOOKING ROUTES (PUBLIC) ================= //
Route::post('/booking', [BookingController::class, 'store']);     // Create booking
Route::get('/booking/{id}', [BookingController::class, 'show']);   // Get single booking

// User
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);

// Features
Route::get('/features', [FeaturesController::class, 'index']);
Route::get('/features/{id}', [FeaturesController::class, 'getFeatureById']);

// Package
Route::get('/package', [PackageController::class, 'index']);
Route::get('/package/{id}', [PackageController::class, 'getPackageById']);

// Darshan Timing
Route::get('/darshantiming', [DarshanTimingController::class, 'index']);
Route::get('/darshantiming/{id}', [DarshanTimingController::class, 'getDarshanTimingById']);

// Services (public)
Route::get('/service', [ServiceController::class, 'index']);
Route::get('/service/{id}', [ServiceController::class, 'show'])->where('id', '[0-9]+');
Route::get('/service_2', [Service2Controller::class, 'index']);
Route::get('/service_2/police-station', [Service2Controller::class, 'policeStation']);
Route::get('/service_2/{id}', [Service2Controller::class, 'show'])->where('id', '[0-9]+');

// Permissions (read-only)
Route::get('/permissions', [PermissionController::class, 'permissions']);
Route::get('/role-has-permissions/{id}', [PermissionController::class, 'role_has_permissions']);
Route::get('/user-has-permissions/{id}', [PermissionController::class, 'user_has_permissions']);
Route::get('/permissions/distinct/name', [PermissionController::class, 'distinct_permissions']);


// ================= PROTECTED ROUTES ================= //
Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Role (create/update/delete)
    Route::post('/role', [RoleController::class, 'store']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);

    // User (create/update/delete)
    Route::post('/user', [UserController::class, 'store']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::post('/user/device-token/{id}', [UserController::class, 'addDeviceToken']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // Features (create/update/delete)
    Route::post('/features', [FeaturesController::class, 'store']);
    Route::put('/features/{id}', [FeaturesController::class, 'update']);
    Route::delete('/features/{id}', [FeaturesController::class, 'destroy']);

    // Package (create/update/delete)
    Route::post('/package', [PackageController::class, 'store']);
    Route::put('/package/{id}', [PackageController::class, 'update']);
    Route::delete('/package/{id}', [PackageController::class, 'destroy']);

    // Darshan Timing (create/update/delete)
    Route::post('/darshantiming', [DarshanTimingController::class, 'store']);
    Route::put('/darshantiming/{id}', [DarshanTimingController::class, 'update']);
    Route::delete('/darshantiming/{id}', [DarshanTimingController::class, 'destroy']);

    // Services (admin). store/update accept multipart/form-data (FormData).
    // Clients must not set Content-Type manually; the boundary must be included.
    Route::get('/service/manage', [ServiceController::class, 'manage']);
    Route::post('/service', [ServiceController::class, 'store']);
    Route::put('/service/{id}', [ServiceController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->where('id', '[0-9]+');

    // Service 2 (admin). store/update accept multipart/form-data (FormData).
    // Clients must not set Content-Type manually; the boundary must be included.
    Route::get('/service_2/manage', [Service2Controller::class, 'manage']);
    Route::post('/service_2', [Service2Controller::class, 'store']);
    Route::put('/service_2/{id}', [Service2Controller::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/service_2/{id}', [Service2Controller::class, 'destroy'])->where('id', '[0-9]+');

    // Permissions (write)
    Route::post('/role-has-permissions', [PermissionController::class, 'store_role_has_permissions']);
    Route::post('/user-has-permissions', [PermissionController::class, 'store_user_has_permissions']);

    // ================= BOOKING ROUTES (PROTECTED) ================= //
    Route::put('/booking/{id}', [BookingController::class, 'update']);    // Update booking
    Route::get('/booking', [BookingController::class, 'index']);     // Get all bookings
    Route::delete('/booking/{id}', [BookingController::class, 'destroy']); // Delete booking (optional)
});
