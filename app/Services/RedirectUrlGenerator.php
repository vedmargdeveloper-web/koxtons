<?php

namespace App\Services;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RedirectUrlGenerator extends UrlGenerator
{
    public function to($path, $extra = [], $secure = null)
    {
        // Normalize path (remove domain if a full URL is passed)
        $parsed = parse_url($path, PHP_URL_PATH);
        $slug = trim($parsed ?? $path, '/');

        // Look for redirect in cache (1 hour cache)
        $redirect = Cache::remember("redirect:{$slug}", 3600, function () use ($slug) {
            return DB::table('redirect')->where('old_url', $slug)->first();
        });

        if ($redirect) {
            $path = ltrim($redirect->new_url, '/');
        }

        return parent::to($path, $extra, $secure);
    }
}
