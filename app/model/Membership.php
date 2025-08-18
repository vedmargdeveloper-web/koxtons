<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['user_id', 'amount'];
}
