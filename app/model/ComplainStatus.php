<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ComplainStatus extends Model
{
    protected $fillable = ['complain_id', 'message', 'status'];
}
