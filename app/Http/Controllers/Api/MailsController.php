<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\RouteConsts;
use App\Common\Delegate\MailsDelegate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Model\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Common\Filters\MailFilters;
use App\Http\Requests\GetMailsRequest;

class MailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function sendMail(Request $request)
    {
        // nhan du lieu tu nguoi dung
        // 1. Thong tin main
        $mail = new Mail([
            'sender_id' => $this->getAuthorizedUser()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'attach_id' => $request->input('attach_id'),
            'type' => $request->input('type'),
            'sent_date' => time()
        ]);
        // 2. Thong tin luu vao user_mail
        // bao gom receiver_ids
        $toReceivers = $request->input('receiver_ids');

        // gui cho delegate
        $delegate = new MailsDelegate();
        $sentMailInfo = $delegate->sendMail($mail, $toReceivers);

        // phan hoi
        return response()->json($sentMailInfo, 200);
    }

    public function getMailBox(GetMailsRequest $request, MailFilters $mailFilters) {        
        $userId = $this->getAuthorizedUser()->id;

        $delegate = new MailsDelegate();

        $mailBox = $delegate->getMailBox($mailFilters);

        $result = [
            'nbMails' => 0,
            'mails' => []
        ];

        $count = 0;

        foreach($mailBox as $aMail) {
            $element = [
                'sender' => $aMail->sender->username,
                'mail' => $aMail->mail_id,
                'title' => $aMail->title,
                'sent_date' => $aMail->sent_date,
                'mark' => $aMail->mark
            ];

            $result['mails'] = array_add($result['mails'], $count, $element);

            $result['nbMails']++;
            $count++;
        }

        return response()->json($result, 200);
    }
}
