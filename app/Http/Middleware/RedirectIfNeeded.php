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
//     // Maximum redirect depth to prevent loops
//     const MAX_REDIRECT_DEPTH = 5;

//     public function handle(Request $request, Closure $next)
//     {
//         // Get current request details
//         $currentPath = '/' . ltrim($request->path(), '/');
//         $fullUrl = $request->fullUrl();
//         $redirectDepth = $request->attributes->get('redirect_depth', 0);

//         // Prevent infinite redirect loops
//         if ($redirectDepth >= self::MAX_REDIRECT_DEPTH) {
//             Log::warning('Maximum redirect depth reached', [
//                 'path' => $currentPath,
//                 'depth' => $redirectDepth
//             ]);
//             return $next($request);
//         }

//         try {
//             // Get cached redirects or query database
//             $redirect = Cache::remember("redirect:{$fullUrl}", 3600, function () use ($fullUrl, $currentPath) {
//                 return $this->findRedirectRule($fullUrl, $currentPath);
//             });

//             if ($redirect) {
//                 return $this->handleRedirect($request, $redirect, $redirectDepth);
//             }

//         } catch (\Exception $e) {
//             Log::error('Redirect middleware error', [
//                 'error' => $e->getMessage(),
//                 'path' => $currentPath
//             ]);
//         }

//         return $next($request);
//     }

//     /**
//      * Find matching redirect rule in database
//      */
//     protected function findRedirectRule(string $fullUrl, string $currentPath)
//     {
//         return DB::table('redirect')
//             ->where(function ($query) use ($fullUrl, $currentPath) {
//                 $query->where('new_url', $fullUrl)
//                       ->orWhere('new_url', $currentPath)
//                       ->orWhere('new_url', ltrim($currentPath, '/'));
//             })
//             ->first();
//     }

//     /**
//      * Process the redirect
//      */
    
//      protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
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


//     /**
//      * Parse and normalize destination URL
//      */
//     protected function parseDestinationUrl(string $url, Request $request): string
//     {
//         if (str_starts_with($url, 'http')) {
//             return $url;
//         }

//         // Ensure proper path format
//         $url = '/' . ltrim($url, '/');

//         // Convert to full URL if relative
//         if (!str_starts_with($url, 'http')) {
//             return $request->getSchemeAndHttpHost() . $url;
//         }

//         return $url;
//     }

//     /**
//      * Check if URL is internal
//      */
//     protected function isInternalUrl(string $url, Request $request): bool
//     {
//         $parsed = parse_url($url);
//         return ($parsed['host'] ?? null) === $request->getHost();
//     }

//     /**
//      * Create internal request
//      */
//     protected function createInternalRequest(
//         Request $request, 
//         string $destination,
//         int $redirectDepth
//     ) {
//         $parsed = parse_url($destination);
//         $path = $parsed['path'] ?? '/';
//         $query = [];

//         if (isset($parsed['query'])) {
//             parse_str($parsed['query'], $query);
//         }

//         // Merge with existing query parameters
//         $query = array_merge($query, $request->query());

//         $newRequest = Request::create(
//             $path,
//             $request->method(),
//             $request->all(),
//             $request->cookies->all(),
//             $request->files->all(),
//             $request->server->all(),
//             $request->getContent()
//         );

//         $newRequest->query->replace($query);
//         $newRequest->headers->replace($request->headers->all());
//         $newRequest->attributes->set('redirect_depth', $redirectDepth + 1);

//         return Route::dispatch($newRequest);
//     }
// }

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

    // protected function findRedirectRule(string $currentPath)
    // {
    //     // Try different path variations
    //     $pathsToTry = [
    //         '/' . $currentPath,          // with leading slash
    //         $currentPath,                 // as is
    //         '/' . trim($currentPath, '/') // normalized
    //     ];

    //     // Remove duplicates
    //     $pathsToTry = array_unique($pathsToTry);

    //     foreach ($pathsToTry as $path) {
    //         $redirect = DB::table('redirect')
    //             ->where('old_url', $path)
    //             ->first();
                
    //         if ($redirect) {
    //             return $redirect;
    //         }
    //     }

    //     return null;
    // }
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

    // protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
    // {
    //     $statusCode = $redirect->status_code ?? 301;
    //     $newPath = $redirect->new_url;

    //     // Ensure new path has proper format
    //     $newPath = '/' . ltrim($newPath, '/');
        
    //     // Get base URL from app config (app.url)
    //     $baseUrl = rtrim(Config::get('app.url'), '/');
        
    //     // Build full URL
    //     $newUrl = $baseUrl . $newPath;

    //     // Preserve query string
    //     if ($queryString = $request->getQueryString()) {
    //         $newUrl .= (str_contains($newUrl, '?') ? '&' : '?') . $queryString;
    //     }

    //     Log::info('Internal redirect', [
    //         'from' => $request->path(),
    //         'to' => $newPath,
    //         'full_url' => $newUrl,
    //         'status' => $statusCode,
    //         'app_url' => $baseUrl
    //     ]);

    //     return redirect()->to($newUrl, $statusCode);
    // }
//     protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
// {
//     $statusCode = $redirect->status_code ?? 301;
    
//     // ✅ Get the destination from NEW_URL column, not old_url
//     $newPath = $redirect->new_url;

//     // Validate destination URL
//     if (empty($newPath)) {
//         Log::error('Redirect destination URL is empty', [
//             'redirect_id' => $redirect->id,
//             'from_url' => $request->fullUrl()
//         ]);
//         return $next($request);
//     }

//     // Ensure new path has proper format
//     $newPath = '/' . ltrim($newPath, '/');
    
//     // Get base URL from app config (app.url)
//     $baseUrl = rtrim(Config::get('app.url'), '/');
    
//     // Build full URL
//     $newUrl = $baseUrl . $newPath;

//     // Preserve query string
//     if ($queryString = $request->getQueryString()) {
//         $newUrl .= (str_contains($newUrl, '?') ? '&' : '?') . $queryString;
//     }

//     Log::info('Internal redirect', [
//         'from' => $request->path(),
//         'to' => $newPath,
//         'full_url' => $newUrl,
//         'status' => $statusCode
//     ]);

//     return redirect()->to($newUrl, $statusCode);
// }
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