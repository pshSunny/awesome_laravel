<?php

use Illuminate\Support\Facades\Route;

Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index'])->name('blog_index');
Route::get('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'create']);
Route::post('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'store']);
Route::get('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show']);
Route::get('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'edit']);
Route::put('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'update']);
Route::delete('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'destroy']);
Route::post('/comment', [\App\Http\Controllers\CommentController::class, 'store']);
