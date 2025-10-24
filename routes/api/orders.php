<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Order\OrderController;

Route::middleware('auth:api')->prefix('orders')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])
        ->middleware('throttle:checkout');
});
