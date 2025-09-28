<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sessioncontroller;
use App\Http\Controllers\Api\User\ProfileController;


Route::post('/register' , [Sessioncontroller::class , 'register']);
Route::post('/login' , [Sessioncontroller::class , 'login']);

Route::group(['middleware' => ['auth:api']] , function(){
    Route::get('/profile' , [Sessioncontroller::class , 'profile']);
    Route::get('/refresh' , [Sessioncontroller::class , 'refresh']);
    Route::get('/logout' , [Sessioncontroller::class , 'logout']);
    Route::put('/user/profile' , [ProfileController::class , 'updateProfile']);
    Route::put('/user/avatar' , [ProfileController::class , 'updateAvatar']);
});
