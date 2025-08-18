<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMrp extends Model
{

    protected $table = 'product_mrps';
    protected $fillable = [
        'model',
        'item_name',
        'qty',
        'qty_metric',
        'size',
        'code',
        'mfg_date',
        'mrp',
        'barcode',
        'paper_size',
    ];

   
  
}
