<?php

namespace App\Http\Controllers\Api;

use App\Common\Constants\RouteConsts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        return redirect(route('long'));
    }
}
