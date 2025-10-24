<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Courses\CourseController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Lesson\LessonController;

Route::prefix('admin')
    ->middleware(['auth:api','checkAdmin'])
    ->group(function () {

        Route::apiResource('instructors', InstructorController::class);

        Route::apiResource('categories', CategoryController::class)
            ->only(['store', 'update', 'destroy']);

        Route::apiResource('courses', CourseController::class)
            ->only(['store', 'update', 'destroy']);

        Route::get('/orders', [OrderController::class, 'listOrders']);
        Route::post('/order/{order_id}/approve', [OrderController::class, 'approveOrder']);

        Route::put('/courses/lessons/{lesson}', [LessonController::class, 'update']);
        Route::post('/courses/lessons', [LessonController::class, 'store']);
        Route::delete('/courses/{courseId}/lessons/{lesson}', [LessonController::class, 'destroy']);
});
