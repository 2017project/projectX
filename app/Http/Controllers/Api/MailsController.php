<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\RouteConsts;
use App\Common\Delegate\MailsDelegate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Model\Mail;

class MailsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function sendMail(Request $request)
    {
        // nhan du lieu tu nguoi dung
        // 1. Thong tin main
        $mail = new Mail([
            'sender_id' => "1",
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'attach_id' => $request->input('attach_id'),
            'type' => $request->input('type'),
            'send_date' => Carbon::now()
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
}
