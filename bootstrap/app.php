<?php

use App\Http\Middleware\CheckAdminRole;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->append(\App\Http\Middleware\OneBasicMiddleware::class);
         $middleware->alias([
            'check.admin' => CheckAdminRole::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

          // 404 Not Found
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['error' => 'data not found'], 404);
            }
        });

        // 405 Wrong method
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['error' => 'Not True Request Type'], 405);
            }
        });

        // 401 Unauthorized (no token)
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['error' => 'unauthorized'], 401);
            }
        });

        // 403 Forbidden (Policy Deny)
        $exceptions->renderable(function (AuthorizationException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage() ?: 'Forbidden',
                ], 403);
            }
        });
    })
    ->create();
