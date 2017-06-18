<?php

namespace App\Common\Business\Repositories;

use App\Common\Business\Constracts\IMailsRepository;
use App\Common\Model\UserMail;

class MailsRepositories implements IUserMailsRepository
{
    public function saveUserMails($userMails)
    {
        try {
            
        } catch (\Exception $exception) {

        }

        return [
            'username' => $user->username,
            'email' => $user->email,
        ];
    }
}