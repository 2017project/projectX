<?php

namespace App\Common\Delegate;

class AuthDelegate
{
    public function registerUser($user)
    {
        try {
            $user->save();
        } catch (\Exception $exception) {
//            dd($exception->getMessage());
            throw $exception;
        }

        return $user;
    }
}