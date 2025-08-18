<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Vendor
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
        //return $next($request);

        if ( Auth::check() && Auth::user()->isVendor() )
        {
            return $next($request);
        }

        return redirect( route('vendor.home') );
    }
}
