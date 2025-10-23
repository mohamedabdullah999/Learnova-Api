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
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Lesson\LessonController;

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
    Route::patch('/user/profile' , [ProfileController::class , 'updateProfile']);
    Route::post('/user/avatar' , [ProfileController::class , 'updateAvatar']);

    //Cart Routes
    Route::post('/cart/add' , [CartController::class , 'addToCart']);
    Route::get('/cart/view' , [CartController::class , 'viewCart']);

    //checkout
    Route::post('/order/checkout' , [OrderController::class , 'checkout']);

    //User Enrollments
    Route::get('/user/enrollments' , [ProfileController::class , 'enrollments']);
});


Route::group(['middleware' => ['auth:api','checkAdmin']] , function(){
    Route::apiResource('/instructors' , InstructorController::class);
    Route::apiResource('/categories', CategoryController::class)
    ->only('store', 'update', 'destroy');
    Route::apiResource('/courses', CourseController::class)
    ->only('store', 'update', 'destroy');

    //Admin Order Routes
    Route::get('/orders', [OrderController::class, 'listOrders']);
    Route::post('/order/{order_id}/approve', [OrderController::class, 'approveOrder']);

    Route::apiResource('contacts', ContactController::class)->except(['store']);

    Route::put('/courses/lessons/{lesson}', [LessonController::class, 'update']);
    Route::post('/courses/lessons', [LessonController::class, 'store']);
    Route::delete('/courses/{courseId}/lessons/{lesson}', [LessonController::class, 'destroy']);
});

Route::apiResource('/courses', CourseController::class)
->only('index', 'show');

Route::post('contacts', [ContactController::class, 'store']);
