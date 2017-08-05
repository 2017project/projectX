<?php

namespace App\Common\Model;


class Thread extends GNModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function listMails()
    {
        return $this->hasMany(Mail::class, 'thread_id');
    }
}
