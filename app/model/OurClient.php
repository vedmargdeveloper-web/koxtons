<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OurClient extends Model
{
    //
    protected $fillable = ['user_id', 'title','content', 'image','image_alt', 'status'];
}
