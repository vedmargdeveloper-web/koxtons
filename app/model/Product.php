<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
	protected $fillable = ['product_id','category_id', 'user_id', 'type', 'title', 'slug','short_content', 'content','faq', 'excerpt', 'payment_option', 'tags', 'brand', 'feature_image','feature_image_alt', 'file_alt','price','product_code', 'seller_price', 'price_range', 'mrp', 'buy_also', 'shipping_charge', 'tax', 'gst', 'discount', 'quantity', 'available','delivery_time', 'status', 'remark','metatitle','metakey','metadescription','postmeta'];

	public function productMeta() {
		return $this->hasMany('App\model\ProductMeta');
	}

	public function productPriceQuantity() {
		return $this->hasMany('App\model\ProductPriceQuantity');
	}

	public function product_meta() {
		return $this->hasMany('App\model\ProductMeta');
	}

	public function product_attribute() {
		return $this->hasMany('App\model\ProductAttribute');
	}

	public function product_attribute_meta() {
		return $this->hasMany('App\model\ProductAttributeMeta')->orderBy('id', 'ASC');
	}

	public function media() {
		return $this->hasMany('App\model\Media')->orderBy('created_at', 'DESC');
	}

	public function orders() {
		return $this->hasMany('App\model\Order');
	}

	public function product_category() {
		return $this->belongsToMany('App\model\Category', 'category_products', 'product_id', 'category_id');
	}

	public function product_brand() {
		return $this->belongsToMany('App\model\Brand', 'brand_relations', 'product_id', 'brand_id');
	}

	public function product_brand_id() {
		return $this->belongsToMany('App\model\Brand', 'brand_relations', 'product_id', 'brand_id');
	}

	public function order_product() {
		return $this->hasMany('App\model\OrderProduct');
	}

	public function category() {
		return $this->hasMany('App\model\Category');
	}

	public function user() {
		return $this->belongsToMany('App\User', 'product_users', 'product_id', 'user_id');
	}

	public function review() {
		return $this->belongsToMany('App\model\Review', 'product_reviews', 'product_id', 'review_id');
	}

}
