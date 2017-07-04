<?php

namespace App\Http\Controllers\Api;

use App\Common\Filters\UserFilters;
use App\Common\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    public function index(UserFilters $filters)
    {
        return auth()->user();
//        $users = User::filter($filters)->get();
//
//        return $this->respond($users);
    }
}
