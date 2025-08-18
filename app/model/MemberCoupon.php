<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MemberCoupon extends Model
{
    protected $fillable = ['user_id', 'coupon', 'status', 'amount', 'used_amount', 'left_amount'];
}
