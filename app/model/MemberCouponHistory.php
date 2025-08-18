<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MemberCouponHistory extends Model
{
    protected $fillable = ['user_id', 'member_coupon_id', 'amount'];
}
