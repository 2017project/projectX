<?php

namespace App\Http\Controllers\Api;

use App\Common\Delegate\AuthDelegate;
use App\Common\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
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

        return response()->json([
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
            ]
        ]);
    }
}
