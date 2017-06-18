<?php

namespace App\Common\Model;

use Illuminate\Notifications\Notifiable;

class UserMail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'mail_id', 'send_date', 'title', 'status', 'type', 'mark'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
