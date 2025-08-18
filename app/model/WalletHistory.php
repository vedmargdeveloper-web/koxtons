<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $fillable = ['user_id', 'wallet_id', 'order_id', 'order_no', 'salary_amount', 'reference_amount', 'membership_amount'];
}
