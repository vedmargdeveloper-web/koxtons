<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $fillable = ['user_id', 'epin_id'];
}
