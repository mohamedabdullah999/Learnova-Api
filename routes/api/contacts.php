<?php

use App\Http\Controllers\Api\Contact\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'checkAdmin', 'throttle:contact'])->group(function () {
    Route::get('contacts', [ContactController::class, 'index']);
});
