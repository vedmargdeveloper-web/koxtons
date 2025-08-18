<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class WalletRelation extends Model
{
    protected $fillable = ['user_id', 'wallet_id', 'level', 'amount'];
}
