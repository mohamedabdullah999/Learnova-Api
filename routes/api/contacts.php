<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Contact\ContactController;

Route::middleware(['auth:api','checkAdmin','throttle:contact'])->group(function () {
    Route::apiResource('contacts', ContactController::class);
});
