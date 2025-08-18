<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductUser extends Model
{
    protected $fillable = ['user_id', 'product_id'];
}
