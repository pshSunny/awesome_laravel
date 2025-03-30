<?php

use Illuminate\Support\Facades\Route;

Route::get('/blogs', \App\Http\Controllers\Dashboard\BlogController::class)->name('dashboard.blogs');

// 내 구독자
Route::get('/subscribers', \App\Http\Controllers\Dashboard\SubscriberController::class)->name('dashboard.subscribers');

// 내가 구독한 블로그
Route::get('/subscriptions', \App\Http\Controllers\Dashboard\SubscriptionController::class)->name('dashboard.subscriptions');