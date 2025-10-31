<?php

use App\Http\Controllers\Api\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'throttle:cart'])->prefix('user')->group(function () {
    // get all pending orders of user
    Route::get('orders/pending', [OrderController::class, 'myPendingOrders']);
});
