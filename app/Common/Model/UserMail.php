<?php

namespace App\Common\Model;


use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'mail_id', 'sent_date', 'title', 'type', 'mark'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
