<?php

use App\Http\Controllers\Lesson\LessonController;

Route::group(['middleware' => ['auth:api','checkAdmin']], function () {
    Route::post('/courses/lessons', [LessonController::class, 'store']);
    Route::put('/courses/lessons/{lesson}', [LessonController::class, 'update']);
    Route::delete('/courses/{courseId}/lessons/{lesson}', [LessonController::class, 'destroy']);
});
