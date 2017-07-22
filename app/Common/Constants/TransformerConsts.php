<?php

namespace App\Common\Constants;

/**
 * Class HttpStatusCodeConsts
 * @package App\Common\Constants
 */
class TransformerConsts
{
    public static $USER = [
        'REGISTER' => ['username', 'email'],
        'PROFILE' => ['username', 'email', 'bio'],
    ];

    public static $PROFILE = [
    ];
}