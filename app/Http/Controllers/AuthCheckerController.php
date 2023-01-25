<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AuthCheckerController extends Controller
{
    public function isAllowed(): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'Response successful'
        ]);
    }

    public function isAlive(): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'This service is up and running!'
        ]);
    }
}
