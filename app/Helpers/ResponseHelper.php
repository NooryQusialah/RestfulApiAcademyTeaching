<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error($message, $status = 400)
    {
        return response()->json([
            'error' => $message,
        ], $status);
    }
}
