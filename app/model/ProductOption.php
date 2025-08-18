<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = ['product_id', 'type', 'name', 'value'];
}
