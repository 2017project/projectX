<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param null $user
     * @return array
     */
    public function authorizeUser($user = null)
    {
        $user = $user ? $user : create('App\Common\Model\User');

        return array($user, JWTAuth::fromUser($user));
    }

    protected function authorizationHeader($token)
    {
        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }
}
