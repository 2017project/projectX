<?php

namespace App\Http\Controllers;

use App\Common\Constants\HttpStatusCodeConsts;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getAuthorizedUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'User not found'
                ], HttpStatusCodeConsts::$NOT_FOUND_404);
            }
        } catch (\Exception $exception) {
            abort(HttpStatusCodeConsts::$FORBIDDEN_403, 'Unauthorized');
        }

        return $user;
    }
}
