<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'parent_id', 'seen', 'seen_at'];
}
