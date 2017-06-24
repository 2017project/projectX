<?php

namespace Tests\Feature;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Constants\RouteConsts;
use App\Common\Model\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tymon\JWTAuth\Facades\JWTAuth;

class MailsFeatureTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * POST /mails/send
     * @test */
    public function an_authorized_user_can_send_mail_to_an_other_user()
    {
        list($user, $token) = $this->authorizeUser();

        $receiver = create('App\Common\Model\User');

        $mail = make('App\Common\Model\Mail', ['sender_id' => $user->id]);

        $payload = array_merge($mail->toArray(), ['receiver_ids' => [$receiver->id]]);
        $this
            ->post(route(RouteConsts::$MAILS_SEND), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])
            ->assertJson([
                'success_count' => 1
            ]);
    }

    /**
     * POST /mails/send
     * @test */
    public function an_authorized_user_can_send_mail_to_many_users()
    {
        list($user, $token) = $this->authorizeUser();

        $receiver1 = create('App\Common\Model\User');
        $receiver2 = create('App\Common\Model\User');

        $mail = make('App\Common\Model\Mail', ['sender_id' => $user->id]);

        $payload = array_merge($mail->toArray(), [
                'receiver_ids' => [$receiver1->id, $receiver2->id]
        ]);

        $this
            ->post(route(RouteConsts::$MAILS_SEND), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])
            ->assertJson([
                'success_count' => 2
            ]);
    }

    /** @test */
    public function un_authorized_user_cannot_send_mail()
    {
        $this
            ->post(route(RouteConsts::$MAILS_SEND))
            ->assertStatus(HttpStatusCodeConsts::$BAD_REQUEST_400)
            ->assertJson([
                'error' => 'token_not_provided'
            ]);
    }
}
