<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DeviceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sensor', [SensorController::class, 'index']);
Route::get('/sensor/{id}', [SensorController::class, 'show']);
Route::post('/sensor', [SensorController::class, 'store']);
Route::put('/sensor/{id}', [SensorController::class, 'update']);
Route::delete('/sensor/{id}', [SensorController::class, 'destroy']);
Route::get('/devices', [DeviceController::class, 'index']);
Route::get('/devices/{id}', [DeviceController::class, 'show']);
Route::post('/devices', [DeviceController::class, 'store']);
Route::put('/devices/{id}', [DeviceController::class, 'update']);
Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);
