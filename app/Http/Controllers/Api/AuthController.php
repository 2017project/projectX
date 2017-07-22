<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Constants\TransformerConsts;
use App\Common\Delegate\AuthDelegate;
use App\Common\Model\User;
use App\Common\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{
    function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->middleware('jwt.auth')->except(['register', 'login']);
    }

    public function register(Request $request)
    {
        $user = request('user');
        $user = new User([
            'username' => $user['username'],
            'password' => bcrypt(request('user.password')),
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'middle_name' => $user['middle_name'],
            'last_name' => $user['last_name'],
        ]);

        $delegate = new AuthDelegate();

        try {
            $delegate->registerUser($user);
        } catch (\Exception $exception) {
            return $this->respondError($exception->getMessage(), HttpStatusCodeConsts::$UNPROCESSABLE_ENTITY_422);
        }

        return $this->respond([
            'token' => JWTAuth::fromUser($user),
            'user' => $this->transformer->transform($user, TransformerConsts::$USER['REGISTER'])
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
        JWTAuth::invalidate($token);
        return response()->json([
            'message' => 'Logout successfully'
        ], HttpStatusCodeConsts::$OK_200);
    }
}
