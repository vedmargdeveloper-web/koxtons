<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    //
    protected $fillable = ['user_id', 'remark', 'status', 'working_id','old_data','new_data'];



    public function posts() {
        return $this->hasOne('App\model\Post','id','working_id');
    }

    public function users() {
        return $this->hasOne('App\User','id','user_id');
    }

    public function billing() {
        return $this->hasOne('App\model\Billing','id','working_id');
    }

    public function complain() {
        return $this->hasOne('App\model\Complain','id','working_id');
    }

    public function invoice() {
        return $this->hasOne('App\model\Invoice','id','working_id');
    }

    public function order() {
        return $this->hasOne('App\model\Order','id','working_id');
    }

    public function product() {
        return $this->hasOne('App\model\Product','id','working_id');
    }

    public function review() {
        return $this->hasOne('App\model\Review','id','working_id');
    }


}



