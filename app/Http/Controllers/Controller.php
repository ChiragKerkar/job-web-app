<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Firebase\JWT\JWT;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function jsonResponse($data, $status = 200, $message = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
