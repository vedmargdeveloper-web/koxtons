<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['user_id', 'order_id', 'product_id', 'product_no', 'seller_id', 'variations', 'coupon'];

    public function products() {
    	return $this->belongsToMany('App\model\Product', 'order_products', 'order_id', 'product_id');
    }
}
