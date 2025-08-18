<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['parent_id', 'user_id', 'level'];
}
