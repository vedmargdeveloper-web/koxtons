<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['product_id', 'type', 'attribute_name', 'label'];
}
