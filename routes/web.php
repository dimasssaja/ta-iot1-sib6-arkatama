<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LEDController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\NotificationsController;

Route::get('/', function () {
    return view('layouts.landing');
});

// welcome
Route::get('/dashboard', function () {
    $data['title'] = 'Dashboard';
        $data['breadcrumbs'][]=[
            'title' => 'Dashboard',
            'url'   => route('dashboard')
        ];
    return view('pages.dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/latest-notification', [NotificationsController::class, 'latest'])->name('notifications.latest');
Route::get('/latest-leds', [LEDController::class, 'latestleds'])->name('leds.latest');

Route::get('/pengguna', function () {
    return view('pages.pengguna');
})->middleware(['auth', 'verified']);

Route::get('/datalog', function () {
    $data['title'] = 'Dashboard';
    $data['breadcrumbs'][]=[
        'title' => 'Dashboard',
        'url'   => route('datalog')
    ];
    return view('pages.datalog',$data);
})->middleware(['auth', 'verified']);

Route::get('/led', function () {
    $data['title'] = 'Dashboard';
    $data['breadcrumbs'][]=[
        'title' => 'Dashboard',
        'url'   => route('led')
    ];
    return view('pages.led',$data);
})->middleware(['auth', 'verified'])->name('led');;

Route::put('leds/{id}', [LEDController::class, 'update'])->name('led.update');
// Route::get('/dashboard', [LEDController::class, 'dashboard1'])->middleware(['auth', 'verified'])->name('dashboard1');
// route ini nanti ganti karena tabrakan

Route::get('/sensor', function () {
    $data['title'] = 'Dashboard';
    $data['breadcrumbs'][]=[
        'title' => 'Dashboard / Sensor',
        'url'   => route('sensor')
    ];
    return view('pages.sensor',$data);
})->middleware(['auth', 'verified'])->name('sensor');;


//route yg hanya diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('users',[UserController::class,'index'])->name('users.index');
    Route::get('leds',[LEDController::class,'index'])->name('leds.led');
    Route::get('sensors',[SensorController::class,'index'])->name('sensors.sensor');


});



require __DIR__.'/auth.php';
