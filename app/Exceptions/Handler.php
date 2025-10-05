<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception;

class Handler
{
    public static function handle(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found.'], 404);
        }

        if ($exception instanceof ValidationException) {
            return response()->json(['error' => $exception->errors()], 422);
        }

        if ($exception instanceof HttpException) {
            return response()->json(['error' => $exception->getMessage()], $exception->getStatusCode());
        }

        return response()->json(['error' => 'An unexpected error occurred.','message'=>$exception->getMessage()], 500);
    }
}
