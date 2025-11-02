<?php

use App\Http\Controllers\Api\InstructorController;

Route::middleware(['throttle:cart'])->group(function () {
    Route::apiResource('instructors', InstructorController::class)->only(['index', 'show']);
});
