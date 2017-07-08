<?php

namespace App\Common\Filters;

use Illuminate\Http\Request;

/**
 *
 * Class Pagination
 * @package App\Common\Filters
 */
class Pagination
{
    protected $builder;
    protected $limit;
    protected $page;
    protected $total;

    /**
     * Pagination constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->limit = $request->has('limit') ? $request->input('limit') : 10;
        $this->page = $request->has('page') ? $request->input('page') : 1;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        $this->total = $builder->count();

        $offset = ($this->page - 1) * $this->limit;

        $this->data = $this->builder->limit($this->limit)->offset($offset)->get();
    }

    public function data()
    {
        return $this->data;
    }

    public function total()
    {
        return $this->total;
    }

    public function perPage()
    {
        return $this->limit;
    }

    public function page()
    {
        return $this->page;
    }

}