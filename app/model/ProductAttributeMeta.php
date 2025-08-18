<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeMeta extends Model
{
    protected $fillable = ['product_id', 'product_attribute_id', 'type', 'name', 'value'];
}
