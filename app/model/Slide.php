<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = ['user_id', 'title','type', 'position', 'description', 'see_more', 'see_more_link', 'content', 'image', 'status'];
}
