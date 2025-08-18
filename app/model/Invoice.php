<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['order_id', 'order_no', 'invoice_no'];

    public function orders() {
		return $this->belongsToMany('App\model\Order', 'order_invoices', 'invoice_id', 'order_id');
	}
}
