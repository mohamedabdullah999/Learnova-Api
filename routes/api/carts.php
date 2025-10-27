<?php

use App\Http\Controllers\Api\Cart\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'throttle:cart'])->prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::get('/view', [CartController::class, 'viewCart']);
    Route::delete('/deleteCourse/{course_id}', [CartController::class, 'deleteCourseFromCart']);
    Route::delete('/clear', [CartController::class, 'clearCart']);
});
