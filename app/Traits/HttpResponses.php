<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses {
    protected function success($data, $code = 200) : JsonResponse
    {
        return response()->json([
            'status' => 'Request was successful',
            'message' => 'Request was successful',
            'data' => $data
        ], $code);
    }

    protected function error($data, $code = 200) : JsonResponse
    {
        return response()->json([
           'message' => 'Error has occurred...',
           'data' => $data
        ], $code);
    }
}
