<?php

use App\Http\Controllers\Api\Courses\CourseController;

Route::get('allCourses', [CourseController::class, 'allCourses']);
