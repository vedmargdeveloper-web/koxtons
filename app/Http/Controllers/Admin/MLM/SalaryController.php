<?php

namespace App\Http\Controllers\Admin\MLM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Carbon\Carbon;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        $this->middleware('auth');
    }

    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.salary.index', ['title' => 'Salary']);
    }


    public function upcoming()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.salary.upcoming', ['title' => 'Upcoming payouts']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cashbacks()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.salary.cashbacks', ['title' => 'Cashbacks']);
    }

    public function coupons()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.salary.coupons', ['title' => 'Coupons']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
