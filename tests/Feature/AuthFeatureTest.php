<?php

namespace Tests\Feature;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Constants\RouteConsts;
use Illuminate\Routing\Route;
use Namshi\JOSE\JWT;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthFeatureTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * POST /register
     * @test */
    public function guest_can_register_new_account()
    {
        $user = make('App\Common\Model\User');

        $this
            ->post(route(RouteConsts::$REGISTER), $user->toArray())
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
        ;

        $this->assertDatabaseHas('users', $user->toArray());
    }

    /** @test */
    public function authorized_user_can_log_out()
    {
        list($user, $token) = $this->authorizeUser();
        $payload = JWTAuth::getPayload($token);

        $this
            ->post(route(RouteConsts::$LOGOUT), [], $this->authorizationHeader($token))
        ;

        $this->assertTrue(JWTAuth::getBlacklist()->has($payload));

    }
}
