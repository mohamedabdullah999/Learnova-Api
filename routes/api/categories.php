<?php

use App\Http\Controllers\Api\CategoryController;

Route::middleware('throttle:cart')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);

});
