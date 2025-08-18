<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Epin extends Model
{
    protected $fillable = ['reference_id', 'user_id', 'epin_id', 'package', 'epins', 'used_epins', 'amount', 'payment_mode', 'payment_date', 'remark', 'cheque_no', 'image', 'status', 'message'];



	public function user() {
		return $this->belongsToMany('App\User', 'relations', 'epin_id', 'user_id');
	}

}
