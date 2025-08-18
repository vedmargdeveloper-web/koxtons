<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'blog_id', 'email', 'name','file', 'review', 'rating'];


    public function product() {
		return $this->belongsToMany('App\model\Product', 'product_reviews', 'review_id', 'product_id');
	}
}
