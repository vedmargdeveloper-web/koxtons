<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'content', 'excerpt', 'type', 'feature_image','feature_image_alt', 'status','metatitle','metakey','metadescription','views'];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }


     
}
