<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;

class DemoMode
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
        if($request->method() == 'POST' || $request->method() == 'PUT' || $request->method() == 'DELETE') {
            Toastr::error('This functionality is disabled in demo mode!', 'Error');
            return back();
        }
        return $next($request);
    }
}
