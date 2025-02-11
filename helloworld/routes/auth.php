<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Auth\RegisterController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store');
    });
});

Route::controller(\App\Http\Controllers\Auth\EmailVerificationController::class)->group(function () {
    Route::name('verification.')->prefix('/email')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/verify', 'notice')->name('notice');
            Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
            Route::post('/verification-notification', 'send')->name('send');
        });
    });
});

Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
    });

    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// Route::middleware('guest')->group(function () {
//     // Route::get('/regist', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('regist');
//     // Route::post('/regist', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);
//     Route::get('/login', [\App\Http\Controllers\Auth\RegisterController::class, 'login'])->name('login');
//     Route::post('/login', [\App\Http\Controllers\Auth\RegisterController::class, 'login_store']);
// });

// Route::get('/logout', [\App\Http\Controllers\Auth\RegisterController::class, 'logout'])->name('logout');

Route::controller(\App\Http\Controllers\Auth\SocialLoginController::class)->group(function () {
    Route::middleware('guest')->name('login.')->group(function () {
        Route::get('/login/{provider}', 'redirect')->name('social');
        Route::get('/login/{provider}/callback', 'callback')->name('social.callback');
    });
});

Route::controller(\App\Http\Controllers\Auth\PasswordResetController::class)->group(function () {
    Route::middleware('guest')->name('password.')->group(function () {
        Route::get('/forget-password', 'request')->name('request');
        Route::post('/forget-password', 'email')->name('email');
        Route::get('/reset-password/{token}', 'reset')->name('reset');
        Route::post('/reset-password', 'update')->name('update');
    });
});
