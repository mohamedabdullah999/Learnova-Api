<?php

use App\Http\Controllers\Api\Courses\CourseController;

Route::middleware('throttle:cart')->prefix('courses')->group(function () {
    Route::get('/allCourses', [CourseController::class, 'allCourses']);
    Route::get('/showCourse/{course}', [CourseController::class, 'show']);
});
