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

Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index'])->name('blog_index');
Route::get('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'create']);
Route::post('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'store']);
Route::get('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show']);
Route::get('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'edit']);
Route::put('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'update']);
Route::delete('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'destroy']);
Route::post('/comment', [\App\Http\Controllers\CommentController::class, 'store']);
