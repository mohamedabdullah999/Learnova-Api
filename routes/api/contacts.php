<?php

use App\Http\Controllers\Api\Contact\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:contact'])->group(function () {
    Route::apiResource('contacts', ContactController::class)->only('store');
});
