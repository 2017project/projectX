<?php

namespace Tests\Feature;

use App\Common\Constants\RouteConsts;
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
        // Arrange
        $user = create('App\Common\Model\User');
        $token = JWTAuth::fromUser($user);
        $payload = JWTAuth::getPayload($token);
        $headers = ['AUTHORIZATION' => 'Bearer ' . $token];

        // Assert
        $this->post(route(RouteConsts::$LOGOUT), [], $headers);

        // Verify on the back-end that the token is blacklisted
        $this->assertTrue(JWTAuth::getBlacklist()->has($payload));
    }
}
