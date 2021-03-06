<?php

namespace App\Common\Model;


class Mail extends GNModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'title', 'content', 'attach_id', 'sent_date', 'status', 'type', 'thread_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function listSent()
    {
        return $this->hasMany(UserMail::class, 'mail_id');
    }

    public function addMailDetail($attributes)
    {
        $this->listSent()->create($attributes);
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function thread() {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
