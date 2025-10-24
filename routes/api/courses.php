<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Courses\CourseController;

Route::apiResource('/courses', CourseController::class)
    ->only('index', 'show');
