<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable = ['user_id', 'amount', 'status', 'remark', 'response'];
}
