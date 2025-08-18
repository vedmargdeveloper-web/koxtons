<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['product_id', 'review_id', 'user_id'];
}
