<?php

use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Driver\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/users/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum', 'guard:users'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('drivers/{driver}/remove-vehicle', [DriverController::class, 'removeVehicle']);
    Route::post('users/logout', [UserController::class, 'logout']);
});


//drivers application

Route::post('/drivers/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'guard:driver'])->group(function () {
    Route::post('drivers/logout', [AuthController::class, 'logout']);
});

