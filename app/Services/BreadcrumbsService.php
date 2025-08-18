<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;

class BreadcrumbsService
{
    public static function generate(array $items): array
    {
        $position = 1;
        return array_map(function ($item) use (&$position) {
            return [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'item' => URL::to($item['path']), // Generate full URL
            ];
        }, $items);
    }
}