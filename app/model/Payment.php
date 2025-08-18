<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_id', 'token', 'tid', 'order_id', 'amount', 'currency', 'language', 'bank_ref_no', 'card_name', 'payment_mode', 'order_status', 'failure_message', 'status_message', 'trans_date', 'billing_notes', 'status'];
}
