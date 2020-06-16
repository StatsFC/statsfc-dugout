<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DeprecatedController extends Controller
{
    public function index(): JsonResponse
    {
        header_remove('X-Powered-By');

        return response()->json([
            'error' => [
                'message'    => 'v1 is now deprecated. Please upgrade to v2',
                'statusCode' => 503,
            ],
        ], 503);
    }
}
