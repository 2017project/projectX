<?php

namespace App\Http\Controllers\Api;

use App\Common\Delegate\AuthDelegate;
use App\Common\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    protected $transform;

    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    protected function respondWithTransformer($data, $statusCode, $headers = [])
    {
        $this->checkTransform();

        if ($data instanceof Collection) {
            $data = $this->transform->collection($data);
        } else {
            $data = $this->transform->item($data);
        }
        return $this->respond($data, $statusCode, $headers);
    }


}

