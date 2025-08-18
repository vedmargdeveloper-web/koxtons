<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class ShareBreadcrumbs
{
    public function handle($request, Closure $next)
    {
        // Example breadcrumbs (customize per route)
        $breadcrumbs = [
            ['name' => 'Home', 'path' => '/'],
            ['name' => 'Products', 'path' => '/products'],
            ['name' => 'Current Page', 'path' => $request->path()],
        ];

        View::share('breadcrumbItems', $breadcrumbs);
        return $next($request);
    }
}