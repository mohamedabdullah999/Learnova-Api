<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__.'/api/auth.php';
    require __DIR__.'/api/categories.php';
    require __DIR__.'/api/courses.php';
    require __DIR__.'/api/carts.php';
    require __DIR__.'/api/orders.php';
    require __DIR__.'/api/profile.php';
    require __DIR__.'/api/lessons.php';
    require __DIR__.'/api/admin.php';
    require __DIR__.'/api/contacts.php';
    require __DIR__.'/api/instructors.php';
});
