<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\RouteConsts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Model\Mail;

class MailsController extends Controller
{
    public function sendMail(Request $request)
    {
        $mail = new Mail([
            'sender_id' => $request->input('sender_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'attach_id' => $request->input('attach_id'),
            'type' => $request->input('type'),
        ]);

        $receivers = $request->input('receiver_ids');

        $userMails = [];

        foreach($receivers as $recv) {
            $userMail = new UserMail([
                'sender_id' =>
            ])
        }

        $delegate = new MailsDelegate();

        $sentMailInfo = $delegate->sendMails($mail);

        return response()->json([
                'sentMailInfo' => [
                'status' => $sentMailInfo->status,
                'nbMailsSent' => $sentMailInfo->nbMailsSent,
                'nbMailsUnsent' => $sentMailInfo->nbMailsUnsent,
            ]
        ]);
    }
}
