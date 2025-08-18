<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    protected $fillable = ['product_id', 'color', 'width', 'height', 'length', 'size'];
}
