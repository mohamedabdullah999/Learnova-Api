<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sessioncontroller;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Email\EmailController;
use App\Http\Controllers\Api\ForgetPaswordController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Courses\CourseController;

Route::get('/email/welcome', [EmailController::class, 'welcomeToDevelopers']);
Route::post('/register' , [Sessioncontroller::class , 'register']);
Route::post('/login' , [Sessioncontroller::class , 'login'])->name('login');
Route::post('/forgot-password', [ForgetPaswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgetPaswordController::class, 'resetPassword']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::group(['middleware' => ['auth:api']] , function(){
    Route::get('/profile' , [Sessioncontroller::class , 'profile']);
    Route::get('/refresh' , [Sessioncontroller::class , 'refresh']);
    Route::get('/logout' , [Sessioncontroller::class , 'logout']);
    Route::put('/user/profile' , [ProfileController::class , 'updateProfile']);
    Route::put('/user/avatar' , [ProfileController::class , 'updateAvatar']);
});


Route::group(['middleware' => ['auth:api','checkAdmin']] , function(){
    Route::apiResource('/instructors' , InstructorController::class);
    Route::apiResource('/categories', CategoryController::class)
    ->only('store', 'update', 'destroy');
    Route::apiResource('/courses', CourseController::class)
    ->only('store', 'update', 'destroy');
});

Route::apiResource('/courses', CourseController::class)
->only('index', 'show');


