<?php

namespace mms80\TodoApi\Http\Middleware;

use Closure;
use mms80\TodoApi\User;
use Illuminate\Support\Facades\Auth;

class ApiAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        if($token){
            $user = User::where('token',$token)->first();
            if($user){
                Auth::setUser($user);
                return $next($request);
            }
        }
        return abort(401);
    }
}
