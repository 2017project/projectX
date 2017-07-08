<?php

namespace App\Common\Model;

class UserMail extends GNModel
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

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function mail() {
        return $this->belongsTo(Mail::class, 'mail_id');
    }
}
