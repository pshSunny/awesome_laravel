<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\RegisterController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/regist', 'create')->name('regist');
        Route::post('/regist', 'store');
    });
});

Route::middleware('guest')->group(function () {
    // Route::get('/regist', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('regist');
    // Route::post('/regist', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);
    Route::get('/login', [\App\Http\Controllers\Auth\RegisterController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\RegisterController::class, 'login_store']);
});

Route::get('/logout', [\App\Http\Controllers\Auth\RegisterController::class, 'logout'])->name('logout');