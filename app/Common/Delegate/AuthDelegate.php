<?php

namespace App\Common\Delegate;

class AuthDelegate
{
    public function registerUser($user)
    {
        $user->save();
        //
        return $user;
    }
}