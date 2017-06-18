<?php

namespace App\Common\Model;

use Illuminate\Notifications\Notifiable;

class Mail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_id', 'sender_id', 'title', 'content', 'attach_id', 'send_date', 'status', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
