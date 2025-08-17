<?php

use Illuminate\Support\Facades\Route;

// 블로그 리소스 리우트 & 컨터롤러
Route::resource('blogs', \App\Http\Controllers\BlogController::class);

// 구독/취소 라우트 & 컨트롤러
Route::controller(\App\Http\Controllers\SubscribeController::class)->group(function () {
    Route::post('subscribe', 'subscribe')->name('subscribe');
    Route::post('unsubscribe', 'unsubscribe')->name('unsubscribe');
});

// 글 얕은 중첩 리소스 라우트 & 컨트롤러
Route::resource('blogs.posts', \App\Http\Controllers\PostController::class)->shallow();

// 댓글 얕은 중첩 리소스 라우트 & 컨트롤러
Route::resource('posts.comments', \App\Http\Controllers\CommentController::class)->shallow()->only(['store', 'update', 'destroy']);
