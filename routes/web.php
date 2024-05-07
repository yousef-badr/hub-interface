<?php

use App\Http\Controllers\AdminPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function (){
    Route::resource('admin',AdminPostController::class);
});

Route::middleware('auth')->group(function (){
    Route::resource('users',UserController::class);
    Route::resource('posts',PostController::class);
});

Route::put('posts/{post}/hide','PostController@hide')->name('posts.hide');


