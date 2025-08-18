<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\model\UserDetail;
use App\User;

use Hash;
use Auth;

class VendorController extends Controller
{


    public function __construct() {

        $this->middleware('admin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('vendor.index'), ['title' => 'Vendors'] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('vendor.create'), ['title' => 'Create Vendor'] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $array = array(
                            'role' => 'vendor',
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password)
                    );

        $user_id = User::create( $array )->id;

        if( !$user_id )
            return redirect()->back()->with('vendor_err', 'Vendor could not create!')->withInput();


        $array = array(
                            'user_id' => $user_id,
                            'firm_name' => $request->firm_name,
                            'city' => $request->city,
                            'state' => $request->state,
                            'address' => $request->address,
                            'pin' => $request->pin,
                            'phone' => $request->phone
                    );

        UserDetail::create( $array );
        return redirect()->back()->with('vendor_msg', 'Vendor created successfully!');
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
        if( !User::isAdmin() )
            return redirect( url('/') );

        $user = User::with('userdetail')->where('id', $id)->first();
        return view( _admin('vendor.edit'), ['title' => 'Edit Vendor', 'user' => $user] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );
        
        $array = array(
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password)
                    );

        User::where('id', $id)->update( $array );

        $array = array(
                            'user_id' => $id,
                            'firm_name' => $request->firm_name,
                            'city' => $request->city,
                            'state' => $request->state,
                            'address' => $request->address,
                            'pin' => $request->pin,
                            'phone' => $request->phone
                    );

        UserDetail::where('user_id', $id)->update( $array );
        return redirect()->back()->with('vendor_msg', 'Vendor updated successfully!');
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
