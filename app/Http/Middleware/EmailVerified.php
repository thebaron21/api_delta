<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        

            if(Auth::user()->email_verified != 0 ){
                return $next($request);
            }
            $info = [
                "email" => "email it's not verified"
            ];

            return new JsonResponse($info,422);
        
    }
}
