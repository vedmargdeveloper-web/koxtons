<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductPriceQuantity extends Model
{
    protected $fillable = ['product_id', 'amount', 'quantity', 'discount', 'start_time', 'end_time'];
}
