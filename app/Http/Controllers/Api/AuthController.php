<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Delegate\AuthDelegate;
use App\Common\Model\User;
use App\Common\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function register()
    {
        $user = new User([
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'email' => request('email'),
            'first_name' => request('first_name'),
            'middle_name' => request('middle_name'),
            'last_name' => request('last_name'),
        ]);

        $delegate = new AuthDelegate();

        $delegate->registerUser($user);

        return $this->respond([
            'token' => JWTAuth::fromUser($user)
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->respondFailedLogin();
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->respondInternalError('Could not create token');
        }

        // if no errors are encountered we can return a JWT
        return $this->respond([
            'token' => $token
        ]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        $payload = JWTAuth::getPayload($token);
        JWTAuth::invalidate($token);
//        dd(JWTAuth::getBlacklist()->has($payload));
        return response()->json([
            'message' => 'Logout successfully'
        ], 200);
    }
}
