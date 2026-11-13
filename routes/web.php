<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::post('/login',[LoginController::class, 'authenticate'])->name('login-form');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::get('/signup', function () {
    return view('auth.register');
})->name('signup');

Route::post('/signup', [RegisterController::class, 'signup'])->name('signup-form');

Route::get('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');