<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Courses\CourseController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Lesson\LessonController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth:api', 'checkAdmin'])
    ->group(function () {

        Route::apiResource('instructors', InstructorController::class);
        Route::post('instructors/{instructor}/expertise', [InstructorController::class, 'addExpertise']);

        Route::apiResource('categories', CategoryController::class)
            ->only(['store', 'update', 'destroy']);

        Route::apiResource('courses', CourseController::class);

        Route::apiResource('contacts', ContactController::class)->except([
            'store',
        ]);

        Route::get('/orders', [OrderController::class, 'listOrders']);
        Route::post('/order/{order_id}/approve', [OrderController::class, 'approveOrder']);

        Route::put('/courses/lessons/{lesson}', [LessonController::class, 'update']);
        Route::post('/courses/lessons', [LessonController::class, 'store']);
        Route::delete('/courses/{courseId}/lessons/{lesson}', [LessonController::class, 'destroy']);

        // users
        Route::get('users', [UserController::class, 'index']);
    });
