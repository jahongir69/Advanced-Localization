<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function success($data = [], $message = 'Success', $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => __($message),
            'data' => $data
        ], $status);
    }

    protected function error($message = 'Error', $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __($message),
            'data' => null
        ], $status);
    }
}
