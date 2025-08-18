<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'description', 'feature_image', 'icon'];


    public function brand_product() {
		return $this->belongsToMany('App\model\Product', 'brand_relations', 'brand_id', 'product_id');
	}
}
