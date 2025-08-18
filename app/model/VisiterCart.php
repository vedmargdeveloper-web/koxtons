<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class VisiterCart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'token', 'product_no', 'variations'];
}
