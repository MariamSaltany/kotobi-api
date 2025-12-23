<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function sendResponse($result, $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'errors'  => null,
        ], $code);
    }

    public function sendError($error, $errorMessages = [], int $code = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data'    => null,
            'message' => $error,
            'errors'  => $errorMessages,
        ], $code);
    }
}
