<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent', 'description', 'feature_image','order_by','product_priority_desktop','product_priority_mobile', 'status','metatitle','metadescription','metakey','postmeta'];

    public function productMeta() {
		return $this->hasMany('App\model\ProductMeta');
	}

	public function productPriceQuantity() {
		return $this->hasMany('App\model\ProductPriceQuantity');
	}

	public function media() {
		return $this->hasMany('App\model\Media');
	}

	public function product_category() {
		return $this->belongsToMany('App\model\Category', 'category_products', 'product_id', 'category_id');
	}

	public function category_product() {
		return $this->belongsToMany('App\model\Product', 'category_products', 'category_id', 'product_id');
	}

	public function product() {
		return $this->hasMany('App\model\Product');
	}

}