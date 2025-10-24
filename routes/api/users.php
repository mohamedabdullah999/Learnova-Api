<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sessioncontroller;
use App\Http\Controllers\Api\User\ProfileController;

Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::get('/profile', [Sessioncontroller::class, 'profile']);
    Route::get('/refresh', [Sessioncontroller::class, 'refresh']);
    Route::get('/logout', [Sessioncontroller::class, 'logout']);

    Route::put('/profile', [ProfileController::class, 'updateProfile']);
    Route::put('/avatar', [ProfileController::class, 'updateAvatar']);
    Route::get('/enrollments', [ProfileController::class, 'enrollments']);
});
