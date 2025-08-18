<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends Model
{
    protected $fillable = ['order_id', 'invoice_id'];
}
