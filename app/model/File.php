<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['order_id', 'order_no', 'file'];
}
