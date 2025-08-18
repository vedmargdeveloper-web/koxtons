<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['user_id', 'code', 'discount', 'usage_number', 'usage_amount', 'discount_type', 'text', 'content', 'start', 'end', 'status'];
}
