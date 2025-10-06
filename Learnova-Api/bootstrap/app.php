<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'The requested page was not found.'
            ], 404);
        });

        // 401 - Unauthenticated
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'You must be authenticated to access this resource.'
            ], 401);
        });

        // 403 - Unauthorized
        $exceptions->render(function (AuthorizationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to access this resource.'
            ], 403);
        });

        // 422 - Validation Error
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'status' => false,
                'message' => 'The HTTP method used is not allowed for this route.',
                'allowed_methods' => $e->getHeaders()['Allow'] ?? []
            ], 405);
        });

    })
    ->create();
