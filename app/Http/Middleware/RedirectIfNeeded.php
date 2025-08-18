<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RedirectIfNeeded
{
    // Maximum redirect depth to prevent loops
    const MAX_REDIRECT_DEPTH = 5;

    public function handle(Request $request, Closure $next)
    {
        // Get current request details
        $currentPath = '/' . ltrim($request->path(), '/');
        $fullUrl = $request->fullUrl();
        $redirectDepth = $request->attributes->get('redirect_depth', 0);

        // Prevent infinite redirect loops
        if ($redirectDepth >= self::MAX_REDIRECT_DEPTH) {
            Log::warning('Maximum redirect depth reached', [
                'path' => $currentPath,
                'depth' => $redirectDepth
            ]);
            return $next($request);
        }

        try {
            // Get cached redirects or query database
            $redirect = Cache::remember("redirect:{$fullUrl}", 3600, function () use ($fullUrl, $currentPath) {
                return $this->findRedirectRule($fullUrl, $currentPath);
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

    /**
     * Find matching redirect rule in database
     */
    protected function findRedirectRule(string $fullUrl, string $currentPath)
    {
        return DB::table('redirect')
            ->where(function ($query) use ($fullUrl, $currentPath) {
                $query->where('new_url', $fullUrl)
                      ->orWhere('new_url', $currentPath)
                      ->orWhere('new_url', ltrim($currentPath, '/'));
            })
            ->first();
    }

    /**
     * Process the redirect
     */
    protected function handleRedirect(Request $request, object $redirect, int $redirectDepth)
    {
        $oldUrl = $redirect->old_url;
        $statusCode = $redirect->status_code ?? 301;

        Log::debug('Processing redirect', [
            'from' => $request->fullUrl(),
            'to' => $oldUrl,
            'type' => $statusCode
        ]);

        // Parse destination URL
        $destination = $this->parseDestinationUrl($oldUrl, $request);

        // For internal redirects
        if ($this->isInternalUrl($destination, $request)) {
            return $this->createInternalRequest($request, $destination, $redirectDepth);
        }

        // For external redirects
        return redirect()->away(
            $destination,
            $statusCode,
            $request->headers->all()
        );
    }

    /**
     * Parse and normalize destination URL
     */
    protected function parseDestinationUrl(string $url, Request $request): string
    {
        if (str_starts_with($url, 'http')) {
            return $url;
        }

        // Ensure proper path format
        $url = '/' . ltrim($url, '/');

        // Convert to full URL if relative
        if (!str_starts_with($url, 'http')) {
            return $request->getSchemeAndHttpHost() . $url;
        }

        return $url;
    }

    /**
     * Check if URL is internal
     */
    protected function isInternalUrl(string $url, Request $request): bool
    {
        $parsed = parse_url($url);
        return ($parsed['host'] ?? null) === $request->getHost();
    }

    /**
     * Create internal request
     */
    protected function createInternalRequest(
        Request $request, 
        string $destination,
        int $redirectDepth
    ) {
        $parsed = parse_url($destination);
        $path = $parsed['path'] ?? '/';
        $query = [];

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $query);
        }

        // Merge with existing query parameters
        $query = array_merge($query, $request->query());

        $newRequest = Request::create(
            $path,
            $request->method(),
            $request->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent()
        );

        $newRequest->query->replace($query);
        $newRequest->headers->replace($request->headers->all());
        $newRequest->attributes->set('redirect_depth', $redirectDepth + 1);

        return Route::dispatch($newRequest);
    }
}