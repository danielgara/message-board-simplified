<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    public function sendResponse(array $response, int $statusCode = 200): JsonResponse
    {
        return response()->json(
            $response, $statusCode
        );
    }

    public function sendResponseError(array $response, int $statusCode = 404): JsonResponse
    {
        return response()->json(
            $response, $statusCode
        );
    }
}
