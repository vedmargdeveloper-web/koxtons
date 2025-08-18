<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    protected $fillable = ['order_id', 'coupon_id', 'discount', 'discount_type'];
}
