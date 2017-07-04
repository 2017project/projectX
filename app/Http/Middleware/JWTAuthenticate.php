<?php

namespace App\Http\Middleware;

use App\Common\Constants\HttpStatusCodeConsts;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;

class JWTAuthenticate extends BaseMiddleware

{
    public function handle($request, Closure $next, $optional = null)
    {
        $this->auth->setRequest($request);

        try {
            if (! $user = $this->auth->parseToken('token')->authenticate()) {
                return $this->respondError('JWT error: User not found');
            }
        } catch (TokenExpiredException $e) {
            return $this->respondError('JWT error: Token has expired');
        } catch (TokenInvalidException $e) {
            return $this->respondError('JWT error: Token is invalid');
        } catch (JWTException $e) {
            return $this->respondError('JWT error: Token is not provided');
        }
        return $next($request);
    }

    protected function respondError($message)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'status_code' => HttpStatusCodeConsts::$UNAUTHORIZED_401
            ]
        ], HttpStatusCodeConsts::$UNAUTHORIZED_401);
    }
}
