<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'role', 'last_name', 'epin_id', 'parent_id', 'level', 'member_level', 'ref_id', 'uid', 'mobile','username', 'email', 'password',
    ];

    protected $rules = [
            'email' => 'sometimes|required|email|unique:users',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin' ? true : false; // this looks for an admin column in your users table
    }

    public static function isMember()
    {
        return Auth::check() && Auth::user()->role === 'member' ? true : false; // this looks for an admin column in your users table
    }

    public function isEditor()
    {
        return Auth::check() && Auth::user()->role === 'editor' ? true : false; // this looks for an admin column in your users table
    }

    public static function isCustomer()
    {
        return Auth::check() && Auth::user()->role === 'customer' ? true : false; // this looks for an admin column in your users table
    }


    public static function isAccountant()
    {
        return Auth::check() && Auth::user()->role === 'accountant' ? true : false; // this looks for an admin column in your users table
    }


    public function userdetail() {
        return $this->hasMany('App\model\UserDetail');
    }

    public function relations() {
        $this->belongsToMany('App\model\Epin', 'relations', 'user_id', 'epin_id');
    }


    public function epins() {
        return $this->belongsToMany('App\model\Epin', 'relations', 'user_id', 'epin_id');
    }

    public function level() {
        return $this->hasMany('App\model\Level');
    }

    public function avtar() {
        return $this->hasMany('App\model\Avtar');
    }

    public function document() {
        return $this->hasMany('App\model\Document');
    }

    public function wallet() {
        return $this->hasMany('App\model\Wallet');
    }

    public function products() {
        return $this->hasMany('App\model\Product');
    }
    public function membership() {
        return $this->hasMany('App\model\Membership');
    }

    public function orderuserdetail() {
        return $this->hasOne('App\model\Order');
    }


    public function user_mobile() {
        return $this->hasMany('App\model\UserDetail');
    }
}
