<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class product_meta_colors extends Model
{
    
     /**
     * The table associated with the model.
     *
     * @var string
     */
     
    protected $table = 'product_meta_colors';
    protected $fillable = ['product_id', 'color', 'su_code', 'images', 'color_image_alt'];
}
