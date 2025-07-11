<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
//        $middleware->append(\App\Http\Middleware\OneBasicMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->renderable(function(NotFoundHttpException $e) {
            return response()->json([
                'error'=>'data not found ',
            ],404);
        });
        $exceptions->renderable(function (MethodNotAllowedHttpException $e) {
            return response()->json([
               'error'=>' Not True Request Type ',
            ],405);
        });
        $exceptions->renderable(function (Throwable $e) {
            return response()->json([
                'error'=>'some thing went wrong',
            ],500);
        });

    })->create();
