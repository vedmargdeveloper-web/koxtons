<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
     protected $table ='redirect';
     protected $fillable = ['old_url', 'new_url', 'status_code'];

      protected $casts = [
        'status_code' => 'integer',
    ];

   
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('redirects');
        });
        static::deleted(function () {
            Cache::forget('redirects');
        });
    }
}
