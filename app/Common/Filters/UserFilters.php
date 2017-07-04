<?php

namespace App\Common\Filters;

use Illuminate\Http\Request;

class UserFilters extends Filters
{
    protected $filters = [
        'username'
    ];

    protected function username($username)
    {
        return $this->builder->where(['username' => $username]);
    }


}