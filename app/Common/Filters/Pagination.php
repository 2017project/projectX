<?php

namespace App\Common\Filters\Filters;

use Illuminate\Http\Request;

class Pagination extends Filters
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}