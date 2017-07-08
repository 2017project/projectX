<?php

namespace App\Http\Controllers\Api;

use App\Common\Filters\Pagination;
use App\Common\Filters\UserFilters;
use App\Common\Model\User;
use App\Common\Transformers\UserTransformer;

class UsersController extends ApiController
{
    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('jwt.auth');
    }
    public function index(UserFilters $filters, Pagination $pagination)
    {
        $users = User::all(); //filter($filters); //->pagination($pagination);
//        $users = User::filter($filters)->pagination($pagination);

//        return $this->respondWithPagination($pagination);
        return $this->respondWithTransformer($users);
//        return $this->respond($users);
    }
}
