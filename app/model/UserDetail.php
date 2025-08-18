<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id', 
                            'tnc',
    						'gender',
                            'phonecode',
                            'mobile',
                            'country',
                            'state',
                            'city',
                            'address',
                            'landmark',
                            'pincode',
                            'alternate',
                            'gst',
                            'account_holder_name',
                            'bank_name',
                            'account_no',
                            'bank_ifsc',
                            'bank_address'
                    ];

}