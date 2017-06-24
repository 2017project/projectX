<?php

namespace App\Common\Model;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_id', 'sender_id', 'title', 'content', 'attach_id', 'sent_date', 'status', 'type'
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
}
