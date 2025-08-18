<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = ['complain_no', 'order_id', 'order_no', 'account_no', 'acc_holder_name', 'ifsc_code', 'bank_name', 'user_id', 'return_type', 'reason', 'message', 'status'];
}
