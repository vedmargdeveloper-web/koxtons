<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'amount', 'reference_amount', 'salary_amount', 'membership_amount', 'joining_cashback'];

    public function relation() {
        return $this->hasMany('App\model\WalletRelation');
    }
}
