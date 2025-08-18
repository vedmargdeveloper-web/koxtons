<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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


        if( Auth::check() ) {

            if( Auth::user()->isAdmin() || Auth::user()->isAccountant() || Auth::user()->isEditor() ) {
                return $next($request);
            }

            return redirect()->route('admin');

        }

        return redirect()->route('admin');

        // if ( Auth::check() &&  )
        // {
            
        // }

        // if ( Auth::check() && Auth::user()->isVendor() )
        // {
        //     return $next($request);
        // }

        // return redirect( route('admin.home') );
    }
}
