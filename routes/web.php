<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\PostController::class, 'index']);
Route::get('login',[\App\Http\Controllers\AuthController::class, 'login'])
    ->name('login');

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

Route::get('/register', [\App\Http\Controllers\RegistrationController::class, 'index'])->name('registration_form');
Route::post('/register', [\App\Http\Controllers\RegistrationController::class, 'register'])->name('register');

Route::get('my-posts', [\App\Http\Controllers\PostController::class, 'myPosts'])
    ->name('my_posts')
    ->middleware('auth');

Route::get('my-posts/{id}', [\App\Http\Controllers\PostController::class, 'showMyPost'])
    ->name('my_posts.show')
    ->middleware('auth');
