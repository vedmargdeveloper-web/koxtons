<?php

namespace App\Http\Controllers\Admin\MLM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Wallet;
use App\model\PayoutRequest;
use App\User;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.wallet.index', ['title' => 'Wallet']);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        $user = User::with('wallet')->find($id);
        return view('gift.admin.mlm.wallet.show', ['title' => 'View wallet', 'user' => $user]);
    }


    public function requested()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        $payouts = PayoutRequest::all();
        return view('gift.admin.mlm.wallet.requested', ['title' => 'Payout Requests', 'payouts' => $payouts]);
    }


    public function update_status( Request $request ) {


        PayoutRequest::where('id', $request->id)->update(['status' => $request->status, 'response' => $request->remark]);
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
