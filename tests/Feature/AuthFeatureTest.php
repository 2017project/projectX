<?php

namespace Tests\Feature;

use App\Common\Constants\HttpStatusCodeConsts;
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

        $response = $this
            ->post(route(RouteConsts::$REGISTER), ['user' => $user->toArray()])
            ->assertStatus(HttpStatusCodeConsts::$OK_200)
            ->assertJsonStructure([
                'token',
                'user'
            ])
        ;

        $this
            ->assertDatabaseHas('users', $user->toArray())
            ->assertTrue(count(explode('.', $response->json()['token'])) ===  3)
            ;
    }

    /**
     * POST /logout
     * @test */
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

    /**
     * POST /login
     * @test */
    public function guest_can_log_in_valid()
    {
        $user = create('App\Common\Model\User', [
            'password' => bcrypt('123456')
        ]);
        $credentials = [
            'email' => $user->email,
            'password' => '123456'
        ];

        $resposne = $this->post(route(RouteConsts::$LOGIN, $credentials, ['Content-Type' => 'application/json']))
            ->assertStatus(HttpStatusCodeConsts::$OK_200)
            ->assertJsonStructure([
                'token'
            ]);
        // valid token
        $this->assertTrue(count(explode('.', $resposne->json()['token'])) === 3);
    }

    /**
     * POST /login
     * @test */
    public function guest_can_log_in_invalid()
    {
        $user = create('App\Common\Model\User', [
            'password' => bcrypt('123456')
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'wrong'
        ];

        $this->post(route(RouteConsts::$LOGIN, $credentials, ['Content-Type' => 'application/json']))
            ->assertStatus(HttpStatusCodeConsts::$UNPROCESSABLE_ENTITY_422)
            ->assertJson([
                'errors' => [
                    'email or password' => 'is invalid',
                ]
            ]);

    }
}
