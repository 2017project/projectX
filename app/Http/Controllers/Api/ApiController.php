<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Transformers\Transformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Mockery\Exception;

class ApiController extends Controller
{
    protected $transformer;

    /**
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * @param $data
     * @param $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithTransformer($data, $type, $statusCode = 200, $headers = [])
    {
        $this->checkTransform();
        if ($data instanceof Collection) {
            $data = $this->transformer->collection($data, $type);
        } else {
            $data = $this->transformer->item($data, $type);
        }
        return $this->respond($data, $statusCode, $headers);
    }

    /**
     * @param $pagination
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithPagination($pagination, $statusCode = 200, $headers = [])
    {
        $this->checkTransform();

        $data = $this->transformer->paginate($pagination);

        return $this->respond($data, $statusCode, $headers);
    }

    /**
     * respond sucess with no content
     */
    protected function respondSuccess()
    {
        $this->respond(null, HttpStatusCodeConsts::$OK_200);
    }

    /**
     * respond common error
     * @param $message
     * @param $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message, $statusCode)
    {
        return $this->respond([
            'errors' => [
                'message' => $message,
                'status_code' => $statusCode
            ]
        ], $statusCode);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, HttpStatusCodeConsts::$UNAUTHORIZED_401);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    /**
     * Respond with internal error.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, 500);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondFailedLogin()
    {
        return $this->respond([
            'errors' => [
                'email or password' => 'is invalid',
            ]
        ], HttpStatusCodeConsts::$UNPROCESSABLE_ENTITY_422);
    }

    /**
     * verify transformer is presented
     */
    private function checkTransform()
    {
        if ($this->transformer === null || ! $this->transformer instanceof Transformer) {
            throw new Exception('Invalid data transformer.');
        }
    }

}

