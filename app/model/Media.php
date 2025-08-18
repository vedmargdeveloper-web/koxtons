<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['product_id', 'type', 'files'];
}
