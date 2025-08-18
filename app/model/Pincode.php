<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = ['pincode', 'city', 'cod', 'state_code', 'prepaid', 'reverse_pickup', 'repl'];
}
