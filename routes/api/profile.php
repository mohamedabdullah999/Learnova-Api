<?php

use App\Http\Controllers\Api\Sessioncontroller;
use App\Http\Controllers\Api\User\ProfileController;

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [Sessioncontroller::class, 'profile']);
    Route::get('/refresh', [Sessioncontroller::class, 'refresh']);
    Route::get('/logout', [Sessioncontroller::class, 'logout']);

    Route::put('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::put('/user/avatar', [ProfileController::class, 'updateAvatar']);

    Route::get('/user/enrollments', [ProfileController::class, 'enrollments']);
});
