<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        if ($exception instanceof BaseAppException) {
            return response()->json(['error' => $exception->getMessage()], $exception->statusCode());
        }

        return response()->json(['error' => 'An unexpected error occurred.', 'message' => $exception->getMessage()], 500);
    }
}
