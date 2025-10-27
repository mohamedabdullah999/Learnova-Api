<?php

use App\Http\Controllers\Api\ForgetPaswordController;
use App\Http\Controllers\Api\Sessioncontroller;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [Sessioncontroller::class, 'register'])->middleware('throttle:register');
    Route::post('/login', [Sessioncontroller::class, 'login'])->middleware('throttle:login')->name('login');
    Route::post('/forgot-password', [ForgetPaswordController::class, 'sendResetLink'])->middleware('throttle:forgot');
    Route::post('/reset-password', [ForgetPaswordController::class, 'resetPassword'])->middleware('throttle:reset');
});
