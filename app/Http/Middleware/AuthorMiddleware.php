<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    //After Middleware Creation Always register middleware into kenel.php into $routemiddleware
    public function handle($request, Closure $next)
    {
        //check user authenticated or not. If authenticated then it's redirect into author url
        if (Auth::check() && Auth::user()->role->id ==2){

            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
