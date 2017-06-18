<?php

namespace App\Common\Business\Repositories;

use App\Common\Business\Constracts\IMailsRepository;
use App\Common\Model\Mail;

class MailsRepositories implements IMailsRepository
{
    public function saveMail($mail)
    {
        try {
            
        } catch (\Exception $exception) {

        }

        return [
            'mail_id' => $mail->mail_id
        ];
    }
}