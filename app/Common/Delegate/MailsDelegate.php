<?php

namespace App\Common\Delegate;

class MailsDelegate
{
    public function sendMails($mail, $userMails)
    {
        $mailsRepository = app()->make('IMailsRepository');

        $mail_id = $mailsRepository->saveMail($mail);

        $userMailsRepository = app()->make('IUserMailsRepository');

        $userMailsRepository->saveUserMails($userMails);
    }
}