<?php

namespace App\Http\Controllers\Api;

use App\Common\Delegate\AuthDelegate;
use App\Common\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register()
    {
        dd('hit');
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

        return response()->json([
            'token' => JWTAuth::fromUser($user)
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json([
            'user' => [
                'token' => $token
            ]
        ], 200);
    }

    public function logout()
    {
        $user = $this->getAuthorizedUser();
        $token = JWTAuth::getToken();
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->accepted()->header('Authorization', '');
        return response()->json([
            'message' => 'Logout successfully'
        ], 200);
    }
}
