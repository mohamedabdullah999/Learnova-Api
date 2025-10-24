<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the rate limiting settings for your application.
    | You can define different rate limits for various actions such as login,
    | registration, password resets, and more.
    |
    */

    'limits' => [
        'login' => 10,          // Max 10 attempts per minute for login
        'register' => 5,        // Max 5 attempts per minute for registration
        'forgot' => 3,          // Max 3 attempts per minute for password reset requests
        'reset' => 5,           // Max 5 attempts per minute for password resets
        'contact' => 15,        // Max 15 contact form submissions per minute
        'cart' => 20,           // Max 20 cart actions per minute
        'checkout' => 10,       // Max 10 checkout attempts per minute
    ],

];
