<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'showRegistrationForm'])->name('home');
Route::post('/register', [RegistrationController::class, 'registerUser'])->name('register');

Route::get('/{token}', [MainController::class, 'show'])->name('main.page')->middleware('validate.link');;

Route::post('/play', [MainController::class, 'playRandom'])->name('play.random');
Route::get('/history/{token}', [MainController::class, 'history'])->name('history');

Route::get('/result', [MainController::class, 'history'])->name('result');
Route::post('/deactivate', [LinkController::class, 'deactivate'])->name('deactivate.link');
Route::post('/regenerate/{token}', [LinkController::class, 'regenerateLink'])->name('regenerate.link');
