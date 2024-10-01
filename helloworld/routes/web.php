<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    //return redirect()->route('blog_index');
});

Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index'])->name('blog_index');
Route::get('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'create']);
Route::post('/blog/create', [\App\Http\Controllers\BlogPostController::class, 'store']);
Route::get('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show']);
Route::get('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'edit']);
Route::put('/blog/edit/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'update']);
Route::delete('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'destroy']);
Route::post('/comment', [\App\Http\Controllers\CommentController::class, 'store']);

Route::get('/auth/regist', [\App\Http\Controllers\AuthController::class, 'create']);
Route::post('/auth/regist', [\App\Http\Controllers\AuthController::class, 'store']);
Route::get('/auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login_store']);
Route::get('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
});