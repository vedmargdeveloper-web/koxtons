<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


// class RedirectIfNeeded
// {
//     // prevent redirect loops
//     const MAX_REDIRECT_DEPTH = 5;

//     public function handle(Request $request, Closure $next)
//     {
//         $currentPath = '/' . ltrim($request->path(), '/');
//         $fullUrl     = $request->fullUrl();
//         $redirectDepth = $request->attributes->get('redirect_depth', 0);

//         if ($redirectDepth >= self::MAX_REDIRECT_DEPTH) {
//             Log::warning('Redirect loop stopped', [
//                 'path' => $currentPath,
//                 'depth' => $redirectDepth,
//             ]);
//             return $next($request);
//         }

//         try {
//             // check cache first
//             $redirect = Cache::remember("redirect:{$fullUrl}", 3600, function () use ($fullUrl, $currentPath) {
//                 return $this->findRedirectRule($fullUrl, $currentPath);
//             });

//             if ($redirect) {
//                 return $this->handleRedirect($request, $redirect, $redirectDepth);
//             }
//         } catch (\Exception $e) {
//             Log::error('Redirect middleware error', [
//                 'error' => $e->getMessage(),
//                 'path'  => $currentPath,
//             ]);
//         }

//         return $next($request);
//     }

//     /**
//      * Find redirect rule in DB
//      */
//     protected function findRedirectRule(string $fullUrl, string $currentPath)
//     {
//         $parsed = parse_url($fullUrl);
//         $path   = $parsed['path'] ?? $currentPath;

//         return DB::table('redirect')
//             ->where('old_url', $fullUrl)       // in case full URL stored
//             ->orWhere('old_url', $path)        // path with leading slash
//             ->orWhere('old_url', ltrim($path, '/')) // path without slash
//             ->first();
//     }

    
//    protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
//     {
//         $statusCode = $redirect->status_code ?? 301;

//         // Preserve query string
//         $newUrl = $redirect->new_url;
//         if ($request->getQueryString()) {
//             $newUrl .= (str_contains($newUrl, '?') ? '&' : '?') . $request->getQueryString();
//         }

//         \Log::debug('Redirecting...', [
//             'from' => $request->fullUrl(),
//             'to'   => $newUrl,
//             'type' => $statusCode
//         ]);

//         return redirect()->to($newUrl, $statusCode);
//     }


// }

class RedirectIfNeeded
{
    const MAX_REDIRECT_DEPTH = 5;

    public function handle(Request $request, Closure $next)
    {
        $currentPath = $request->path();
        
        // Skip for static assets and admin routes
        if ($this->shouldSkipRedirect($currentPath)) {
            return $next($request);
        }

        $redirectDepth = $request->attributes->get('redirect_depth', 0);
        
        if ($redirectDepth >= self::MAX_REDIRECT_DEPTH) {
            Log::warning('Maximum redirect depth reached', ['path' => $currentPath]);
            return $next($request);
        }

        try {
            $redirect = Cache::remember("redirect:{$currentPath}", 3600, function () use ($currentPath) {
                return $this->findRedirectRule($currentPath);
            });

            if ($redirect) {
                return $this->handleRedirect($request, $redirect, $redirectDepth);
            }

        } catch (\Exception $e) {
            Log::error('Redirect middleware error', [
                'error' => $e->getMessage(),
                'path' => $currentPath
            ]);
        }

        return $next($request);
    }

    protected function shouldSkipRedirect(string $path): bool
    {
        // Skip static assets
        if (preg_match('/\.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/i', $path)) {
            return true;
        }

        // Skip admin routes
        if (str_starts_with($path, 'bm/-/admin/') || str_starts_with($path, 'admin/')) {
            return true;
        }

        // Skip API routes
        if (str_starts_with($path, 'api/')) {
            return true;
        }

        return false;
    }

   
    protected function findRedirectRule(string $currentPath)
{
    // Try different variations of the path
    $pathsToTry = [
        '/' . $currentPath,                    // with leading slash
        $currentPath,                          // as is
        '/' . trim($currentPath, '/'),         // normalized
        trim($currentPath, '/')                // without leading slash
    ];

    // Remove duplicates
    $pathsToTry = array_unique($pathsToTry);
    
    Log::debug('Looking for redirect', [
        'current_path' => $currentPath,
        'paths_tried' => $pathsToTry
    ]);

    foreach ($pathsToTry as $path) {
        $redirect = DB::table('redirect')
            ->where('old_url', $path)
            ->first();
            
        if ($redirect) {
            Log::debug('Redirect found', [
                'old_url' => $redirect->old_url,
                'new_url' => $redirect->new_url,
                'matched_path' => $path
            ]);
            return $redirect;
        }
    }

    Log::debug('No redirect found for path: ' . $currentPath);
    return null;
}

   
protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
{
    $statusCode = $redirect->status_code ?? 301;

    $newSlug = ltrim($redirect->new_url, '/');  // example: "newblogs"
    $oldSlug = ltrim($redirect->old_url, '/');  // example: "blogs"

    // Preserve query string
    $newUrl = url($newSlug);
    if ($request->getQueryString()) {
        $newUrl .= '?' . $request->getQueryString();
    }

    \Log::debug('Redirecting...', [
        'from' => $request->fullUrl(),
        'to'   => $newUrl,
        'status' => $statusCode,
        'map_old_to' => $oldSlug,
    ]);

    // 👉 Pass along the "original slug" so controller knows what data to load
    session(['original_slug' => $oldSlug]);

    return redirect()->to($newUrl, $statusCode);
}


}