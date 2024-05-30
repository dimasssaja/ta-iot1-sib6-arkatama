<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LEDController;

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

Route::get('/pengguna', function () {
    return view('pages.pengguna');
})->middleware(['auth', 'verified']);

Route::get('/led', function () {
    $data['title'] = 'Dashboard';
    $data['breadcrumbs'][]=[
        'title' => 'Dashboard',
        'url'   => route('led')
    ];
    return view('pages.led',$data);
})->middleware(['auth', 'verified'])->name('led');;

Route::get('/sensor', function () {
    return view('pages.sensor');
})->middleware(['auth', 'verified'])->name('sensor');;

//route yg hanya diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('users',[UserController::class,'index'])->name('users.index');
    Route::get('leds',[LEDController::class,'index'])->name('leds.led');
});



require __DIR__.'/auth.php';
