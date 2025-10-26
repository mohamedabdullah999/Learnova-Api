<?php

use App\Http\Controllers\Api\InstructorController;

Route::group(['middleware' => ['checkAdmin']], function () {
    Route::apiResource('/instructors', InstructorController::class);
});
