<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    protected $fillable = ['user_id', 'order_id', 'product_id', 'first_name', 'last_name', 'email', 'country', 'state', 'city', 'address', 'pincode', 'mobile'];
}
