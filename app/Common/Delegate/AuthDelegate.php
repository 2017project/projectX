<?php

namespace App\Common\Delegate;

class AuthDelegate
{
    public function registerUser($user)
    {
        $userRepository = app()->make('IUserRepository');

        return $userRepository->registerUser($user);
    }
}