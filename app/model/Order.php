<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'user_id', 'total_amount', 'membership_amount', 'coupon', 'coupon_discount_type', 'coupon_discount','c_coupon', 'gst_no', 'address', 'mobile', 'payment_mode', 'remark', 'member_coupon_amt', 'payment_status', 'order_status'];

    public function products() {
    	return $this->belongsToMany('App\model\Product', 'order_products', 'order_id', 'product_id');
    }

    public function product_category() {
		return $this->belongsToMany('App\model\Category', 'category_products', 'product_id', 'category_id');
	}

	public function order_products() {
		return $this->hasMany('App\model\OrderProduct');
	}

	public function order_customer() {
		return $this->hasMany('App\model\OrderCustomer');
	}

	public function category() {
		return $this->hasMany('App\model\Category');
	}

	public function invoice() {
		return $this->hasMany('App\model\Invoice');
	}

	public function payment() {
		return $this->hasOne('App\model\Payment')->orderby('id', 'DESC');
	}

	public function order_invoice() {
		return $this->belongsToMany('App\model\Invoice', 'order_invoices', 'order_id', 'invoice_id');
	}

}
