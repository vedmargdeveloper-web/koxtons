<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Editor
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
       // return $next($request);

        if ( Auth::check() && Auth::user()->isEditor() )
        {
            return $next($request);
        }

        return redirect( route('admin.login') );
    }
}
