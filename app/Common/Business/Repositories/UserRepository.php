<?php

namespace App\Common\Business\Repositories;

use App\Common\Business\Constracts\IUserRepository;
use App\Common\Model\User;

class UserRepository implements IUserRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function registerUser($user)
    {
        try {
            $user->save();
        } catch (\Exception $exception) {

        }

        return [
            'username' => $user->username,
            'email' => $user->email,
        ];
    }
}