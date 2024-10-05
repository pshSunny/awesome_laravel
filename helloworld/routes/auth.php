<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/regist', 'create')->name('regist');
        Route::post('/regist', 'store');
    });
});

Route::middleware('guest')->group(function () {
    // Route::get('/regist', [\App\Http\Controllers\AuthController::class, 'create'])->name('regist');
    // Route::post('/regist', [\App\Http\Controllers\AuthController::class, 'store']);
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login_store']);
});

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');