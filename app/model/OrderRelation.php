<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderRelation extends Model
{
    protected $fillable = ['user_id', 'product_id', 'order_id'];
}
