<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostCategory extends Model
{
    protected $table ='post_categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public static function boot() {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
