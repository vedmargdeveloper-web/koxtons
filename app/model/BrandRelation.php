<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class BrandRelation extends Model
{
    protected $fillable = ['brand_id', 'product_id'];
}
