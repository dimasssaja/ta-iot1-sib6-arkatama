<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LEDController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users', [UserController::class, 'update']);
// Route::get('/users', [UserController::class, 'destroy']);

// Controller yang dipanggil itu userController yang berada di folder controllers/usercontroller
// bukan yang ada di folder contollers/api/userconroller
Route::resource('users', UserController::class)
    ->except(['create','edit']);

//route sensor
Route::get('/sensor', [SensorController::class, 'index']);
Route::get('/sensor/{id}', [SensorController::class, 'show']);
Route::post('/sensor', [SensorController::class, 'store']);
Route::put('/sensor/{id}', [SensorController::class, 'update']);
Route::delete('/sensor/{id}', [SensorController::class, 'destroy']);

//route devices
Route::get('/devices', [DeviceController::class, 'index']);
Route::get('/devices/{id}', [DeviceController::class, 'show']);
Route::post('/devices', [DeviceController::class, 'store']);
Route::put('/devices/{id}', [DeviceController::class, 'update']);
Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);

//route leds
Route::get('/leds', [LEDController::class, 'index']);
Route::get('/leds/{id}', [LEDController::class, 'show']);
Route::post('/leds', [LEDController::class, 'store']);
Route::put('/leds/{id}', [LEDController::class, 'update']);
Route::delete('/leds/{id}', [LEDController::class, 'destroy']);

//route notifications
Route::get('/notifications', [NotificationsController::class, 'index']);
Route::get('/notifications/{id}', [NotificationsController::class, 'show']);
Route::post('/notifications', [NotificationsController::class, 'store']);
Route::put('/notifications/{id}', [NotificationsController::class, 'update']);
Route::delete('/notifications/{id}', [NotificationsController::class, 'destroy']);
