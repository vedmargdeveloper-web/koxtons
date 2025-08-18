<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['user_id', 'name', 'filename', 'status', 'remark'];
}
