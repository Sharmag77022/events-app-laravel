<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Organizer\EventsController;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::post('/login',[LoginController::class, 'authenticate'])->name('login-form');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
->middleware('auth')->name('dashboard');

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

Route::get('/switch-dashboard', [DashboardController::class, 'switchDashboard'])
    ->name('dashboard.switch');

Route::post('/organizer/register', [RegisterController::class, 'registerOrganizer'])
    ->name('organizer.store');

Route::get('/organizer/register', [RegisterController::class, 'registerOrganizerView'])
->middleware('auth')->name('organizer.register');

Route::get('/organizer/create-event', [EventsController::class,'create'])
->middleware('auth')->name('events.create.page');

Route::post('/organizer/create-event', [EventsController::class,'store'])
->middleware('auth')->name('organizer.events.store');

Route::post('/organizer/events/upload-image', [EventsController::class, 'uploadTrixImage'])
    ->name('organizer.events.upload-image');

Route::get('/organizer/events', [EventsController::class,'getEvents'])
->middleware('auth')->name('organizer.list.events');

Route::patch('/organizer/events/{id}/publish', [EventsController::class, 'publish'])
->middleware('auth')->name('organizer.events.publish');