<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = ['user_id', 'member_id', 'amount', 'type', 'action', 'remark', 'status'];
}
