<?php


namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data, $statusCode = 200)
    {
        return response()->json(['data' => $data], $statusCode);
    }

    protected function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }
}

