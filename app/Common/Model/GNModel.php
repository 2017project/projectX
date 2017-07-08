<?php

namespace App\Common\Model;
use Illuminate\Database\Eloquent\Model;

abstract class GNModel extends Model
{
    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function scopePagination($query, $pagination)
    {
        return $pagination->apply($query);
    }
}
