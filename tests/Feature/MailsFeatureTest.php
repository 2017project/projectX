<?php

namespace Tests\Feature;

use App\Common\Constants\HttpStatusCodeConsts;
use App\Common\Constants\RouteConsts;
use App\Common\Constants\ApplicationCommonConsts;
use App\Common\Model\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tymon\JWTAuth\Facades\JWTAuth;

// Bat buoc phai co chu Test
class MailsFeatureTest extends TestCase
{
    // Them vao de tao du lieu ao
    use DatabaseMigrations;

    /**
     * POST /mails/send
     * @test => bat buoc phai them vao*/
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

    /** @test */
    public function authorized_user_can_get_all_mails() {
        list($user, $token) = $this->authorizeUser();

        $sender1 = create('App\Common\Model\User');
        $sender2 = create('App\Common\Model\User');
        $sender3 = create('App\Common\Model\User');
        
        $mail1 = create('App\Common\Model\Mail', ['sender_id' => $sender1->id]);
        $mail2 = create('App\Common\Model\Mail', ['sender_id' => $sender2->id]);
        $mail3 = create('App\Common\Model\Mail', ['sender_id' => $sender3->id]);

        $usermail1 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender1->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail1->id,
                                     'title' => $mail1->title,
                                     'sent_date' => $mail1->sent_date,
                                     'type' => $mail1->type
                                    ]);

        $usermail2 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender2->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail2->id,
                                     'title' => $mail2->title,
                                     'sent_date' => $mail2->sent_date,
                                     'type' => $mail2->type, 
                                    ]);

        $usermail3 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender3->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail3->id,
                                     'title' => $mail3->title,
                                     'sent_date' => $mail3->sent_date,
                                     'type' => $mail3->type, 
                                    ]);

        $filter = [
            'destination' => ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX,
        ];

        $payload = $filter;

        $this
            ->post(route(RouteConsts::$MAILS_MAILBOX), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])->assertJson([
                'nbMails' => 3
            ]);
    }

    /** @test */
    public function authorized_user_can_get_unread_mails() {
        list($user, $token) = $this->authorizeUser();

        $sender1 = create('App\Common\Model\User');
        $sender2 = create('App\Common\Model\User');
        $sender3 = create('App\Common\Model\User');
        
        $mail1 = create('App\Common\Model\Mail', ['sender_id' => $sender1->id, 'title' => 'Title 1']);
        $mail2 = create('App\Common\Model\Mail', ['sender_id' => $sender2->id, 'title' => 'Title 2']);
        $mail3 = create('App\Common\Model\Mail', ['sender_id' => $sender3->id, 'title' => 'Title 3']);

        $usermail1 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender1->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail1->id,
                                     'title' => $mail1->title,
                                     'sent_date' => $mail1->sent_date,
                                     'type' => $mail1->type,
                                     'mark' => ApplicationCommonConsts::$MAIL_MARK_READ
                                    ]);

        $usermail2 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender2->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail2->id,
                                     'title' => $mail2->title,
                                     'sent_date' => $mail2->sent_date,
                                     'type' => $mail2->type, 
                                    ]);

        $usermail3 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender3->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail3->id,
                                     'title' => $mail3->title,
                                     'sent_date' => $mail3->sent_date,
                                     'type' => $mail3->type, 
                                    ]);

        $filter = [
            'destination' => ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX,
            'mark'        => ApplicationCommonConsts::$MAIL_MARK_UNREAD,
            // 'dateFrom'    => ApplicationCommonConsts::$MAIL_FILTER_DATE_FROM_ALL,
            // 'dateTo'      => ApplicationCommonConsts::$MAIL_FILTER_DATE_TO_ALL,
            // 'username'    => ApplicationCommonConsts::$MAIL_FILTER_USERNAME_ALL,
            // 'phrase'      => ApplicationCommonConsts::$MAIL_FILTER_PHRASE_ALL,
            // 'itemsPerPage'=> ApplicationCommonConsts::$MAIL_FILTER_ITEMS_PER_PAGE_ALL
        ];

        $payload = $filter;

        $this
            ->post(route(RouteConsts::$MAILS_MAILBOX), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])->assertJson([
                'nbMails' => 2
            ]);
    }

    /** @test */
    public function authorized_user_can_get_mails_by_period() {
        list($user, $token) = $this->authorizeUser();

        $sender1 = create('App\Common\Model\User');
        $sender2 = create('App\Common\Model\User');
        $sender3 = create('App\Common\Model\User');
        
        $mail1 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender1->id, 
                            'title' => 'Title 1',
                            'sent_date' => '2017-06-20 08:20:36']);
        $mail2 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender2->id, 
                            'title' => 'Title 2',
                            'sent_date' => '2017-06-20 19:12:45']);
        $mail3 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender3->id, 
                            'title' => 'Title 3',
                            'sent_date' => '2017-07-05 13:20:00']);

        $usermail1 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender1->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail1->id,
                                     'title' => $mail1->title,
                                     'sent_date' => $mail1->sent_date,
                                     'type' => $mail1->type,
                                     'mark' => ApplicationCommonConsts::$MAIL_MARK_READ
                                    ]);

        $usermail2 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender2->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail2->id,
                                     'title' => $mail2->title,
                                     'sent_date' => $mail2->sent_date,
                                     'type' => $mail2->type, 
                                    ]);

        $usermail3 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender3->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail3->id,
                                     'title' => $mail3->title,
                                     'sent_date' => $mail3->sent_date,
                                     'type' => $mail3->type, 
                                    ]);

        $filter = [
            'destination' => ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX,
            'dateFrom'    => '2017-06-20 05:00:00',
            'dateTo'      => '2017-07-05 13:19:00',
            // 'username'    => ApplicationCommonConsts::$MAIL_FILTER_USERNAME_ALL,
            // 'phrase'      => ApplicationCommonConsts::$MAIL_FILTER_PHRASE_ALL,
            // 'itemsPerPage'=> ApplicationCommonConsts::$MAIL_FILTER_ITEMS_PER_PAGE_ALL
        ];

        $payload = $filter;

        $this
            ->post(route(RouteConsts::$MAILS_MAILBOX), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])->assertJson([
                'nbMails' => 2
            ]);
    }

    /** @test */
    public function authorized_user_can_get_mails_by_period_and_user_name() {
        list($user, $token) = $this->authorizeUser();

        $sender1 = create('App\Common\Model\User', ['username' => 'longnt']);
        $sender2 = create('App\Common\Model\User');
        $sender3 = create('App\Common\Model\User');
        
        $mail1 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender1->id, 
                            'title' => 'Title 1',
                            'sent_date' => '2017-06-20 08:20:36']);
        $mail2 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender2->id, 
                            'title' => 'Title 2',
                            'sent_date' => '2017-06-20 19:12:45']);
        $mail3 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender3->id, 
                            'title' => 'Title 3',
                            'sent_date' => '2017-07-05 13:20:00']);

        $usermail1 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender1->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail1->id,
                                     'title' => $mail1->title,
                                     'sent_date' => $mail1->sent_date,
                                     'type' => $mail1->type,
                                     'mark' => ApplicationCommonConsts::$MAIL_MARK_READ
                                    ]);

        $usermail2 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender2->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail2->id,
                                     'title' => $mail2->title,
                                     'sent_date' => $mail2->sent_date,
                                     'type' => $mail2->type, 
                                    ]);

        $usermail3 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender3->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail3->id,
                                     'title' => $mail3->title,
                                     'sent_date' => $mail3->sent_date,
                                     'type' => $mail3->type, 
                                    ]);

        $filter = [
            'destination' => ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX,
            'dateFrom'    => '2017-06-20 05:00:00',
            'dateTo'      => '2017-07-05 13:19:00',
            'username'    => 'longnt',
            // 'phrase'      => ApplicationCommonConsts::$MAIL_FILTER_PHRASE_ALL,
            // 'itemsPerPage'=> ApplicationCommonConsts::$MAIL_FILTER_ITEMS_PER_PAGE_ALL
        ];

        $payload = $filter;

        $this
            ->post(route(RouteConsts::$MAILS_MAILBOX), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])->assertJson([
                'nbMails' => 1
            ]);
    }

    /** @test */
    public function authorized_user_can_get_mails_keyword() {
        list($user, $token) = $this->authorizeUser();

        $sender1 = create('App\Common\Model\User', ['username' => 'longnt']);
        $sender2 = create('App\Common\Model\User');
        $sender3 = create('App\Common\Model\User');
        
        $mail1 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender1->id, 
                            'title' => 'Title 1',
                            'sent_date' => '2017-06-20 08:20:36']);
        $mail2 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender2->id, 
                            'title' => 'Title 2',
                            'sent_date' => '2017-06-20 19:12:45']);
        $mail3 = create('App\Common\Model\Mail', 
                            ['sender_id' => $sender3->id, 
                            'title' => 'Title 3',
                            'sent_date' => '2017-07-05 13:20:00']);

        $usermail1 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender1->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail1->id,
                                     'title' => $mail1->title,
                                     'sent_date' => $mail1->sent_date,
                                     'type' => $mail1->type,
                                     'mark' => ApplicationCommonConsts::$MAIL_MARK_READ
                                    ]);

        $usermail2 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender2->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail2->id,
                                     'title' => $mail2->title,
                                     'sent_date' => $mail2->sent_date,
                                     'type' => $mail2->type, 
                                    ]);

        $usermail3 = create('App\Common\Model\UserMail', 
                                    ['sender_id' => $sender3->id,
                                     'receiver_id' => $user->id,
                                     'mail_id' => $mail3->id,
                                     'title' => $mail3->title,
                                     'sent_date' => $mail3->sent_date,
                                     'type' => $mail3->type, 
                                    ]);

        $filter = [
            'destination' => ApplicationCommonConsts::$MAIL_FILTER_DEST_INBOX,
            'phrase'      => 'tle 2',
        ];

        $payload = $filter;

        $this
            ->post(route(RouteConsts::$MAILS_MAILBOX), $payload, [
                'AUTHORIZATION' => 'Bearer ' . $token
            ])->assertJson([
                'nbMails' => 1
            ]);
    }
}
