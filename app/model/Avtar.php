<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Avtar extends Model
{
    protected $fillable = ['user_id', 'filename'];
}
