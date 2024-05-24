<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.landing');
});

// welcome
Route::get('/dashboard', function () {
    return view('pages.coba');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pengguna', function () {
    return view('pages.pengguna');
})->middleware(['auth', 'verified']);

Route::get('/led', function () {
    return view('pages.led');
})->middleware(['auth', 'verified']);

Route::get('/sensor', function () {
    return view('pages.sensor');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
