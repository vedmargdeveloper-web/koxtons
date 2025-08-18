<?php

namespace App\Http\Controllers\Admin\MLM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\model\State;
use App\model\City;
use Auth;
use App\User;

class MainController extends Controller
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

        return view('gift.admin.mlm.home', ['title' => 'MLM']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


    public function check_username( Request $request ) {

        if( !$request->ajax() )
            return;

        if( !User::isAdmin() )
            return;

        $user = User::where('username', $request->username)->first();

        if( !$user )
            return response()->json(['status' => 'failed', 'message' => 'Username not found!']);

        return response()->json(['status' => 'success', 'name' => ucwords( $user->first_name.' '.$user->last_name ) ]);
    }



    public function get_state( Request $request, $country_id ) {
        if( !User::isAdmin() )
            return;

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }
        $states = State::where('country_id', $country_id)->get();
        return response()->json(['states' => $states, 200]);
    }

    public function get_city( Request $request, $state_id ) {

        if( !User::isAdmin() )
            return;

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        $cities = City::where('state_id', $state_id)->get();
        return response()->json(['cities' => $cities, 200]);
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
