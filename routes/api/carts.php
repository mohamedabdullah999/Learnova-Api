<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Cart\CartController;

Route::middleware(['auth:api','throttle:cart'])->prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::get('/view', [CartController::class, 'viewCart']);
});
