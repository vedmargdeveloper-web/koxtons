<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\PayoutRequest;
use App\model\Wallet;
use App\User;
use Validator;
use Auth;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');    
    }

    
    public function index()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.wallet.index', ['title' => 'Wallet']);
    }


    public function transfer() {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.wallet.transfer', ['title' => 'Transfer/Withdraw']);
    }

    public function transfer_store( Request $request ) {

        if( !User::isMember() )
            return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                                    'amount' => 'required|numeric|max:10000000',
                                    'remark' => 'nullable|max:255'
                        ], [
                                    'amount.required' => 'Amount is required *',
                                    'amount.numeric' => 'Amount must be numeric value!',
                                    'amount.max' => 'Amount must be valid!',
                                    'remark.max' => 'Remark can have upto 255 characters!'
                        ]);
        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        $wallet = Wallet::where('user_id', Auth::id())->first();

        if( !$wallet )
            return redirect()->back()->with('req_err', 'You do not have amount in your wallet!');

        if( $wallet->amount < $request->amount )
            return redirect()->back()->with('req_err', 'You do not have enough amount in your wallet!');

        PayoutRequest::create([
                                    'user_id' => Auth::id(),
                                    'amount' => $request->amount,
                                    'remark' => $request->remark,
                                    'status' => 'pending',
                    ]);

        return redirect()->back()->with('req', 'Payout request successfully sent!');

            /*$user = User::find(Auth::id());
            if( count( $validator->errors() ) < 1 ) {

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $request->session()->flash('profile_msg', 'Profile successfully updated!');
                Auth::setUser($user);
            }*/
    }


    public function payout_request() {

        if( !User::isMember() )
            return redirect( url('/') );

        $payouts = PayoutRequest::where('user_id', Auth::id())->get();
        return view('gift.user.wallet.payout', ['title' => 'Payout Requests'])->with('payouts', $payouts);
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
