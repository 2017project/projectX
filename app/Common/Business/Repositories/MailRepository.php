<?php

namespace App\Common\Business\Repositories;

use App\Common\Business\Constracts\IMailsRepository;
use App\Common\Model\Mail;

class MailRepository implements IMailsRepository
{
    public function saveMail($mail)
    {
        try {
            $mail->save();
        } catch (\Exception $exception) {

        }

        return [
            'mail_id' => $mail->mail_id
        ];
    }
}