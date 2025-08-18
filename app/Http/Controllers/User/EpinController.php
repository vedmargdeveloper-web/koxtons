<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EpinRequest;
use App\model\Epin;
use App\model\Relation;
use Validator;
use Auth;
use App\User;

class EpinController extends Controller
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

        return view('gift.user.epin.index', ['title' => 'Epins']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( !User::isMember() )
            return redirect( url('/') );

        return view('gift.user.epin.create', ['title' => 'Request Epin']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpinRequest $request)
    {

        if( !User::isMember() )
            return redirect( url('/') );

        $user = User::where('username', Auth::user()->username)->first();
        if( !$user )
            return redirect()->back()->with('epin_err', 'Reference not found!');

        $file = $request->hasFile('image') ? $request->file('image')->store('files', 'public') : null;

        $epin = uniqueEPIN(8);
        $epin_id = Epin::create([
                                    'reference_id' => Auth::id(),
                                    'user_id' => $user->id,
                                    'epin_id' => $epin,
                                    'package' => $request->package,
                                    'epins' => 1,
                                    'amount' => $request->amount,
                                    'payment_mode' => $request->payment_mode,
                                    'payment_date' => $request->payment_date,
                                    'remark' => $request->remark,
                                    'image' => $file,
                                    'status' => 'pending',
                            ])->id;
        Relation::create([
                        'user_id' => Auth::id(),
                        'epin_id' => $epin_id
                ]);

        /*$subject = 'Thank you for joining our membership - ' . config('app.name');
        $to = $user->email;
        $name = $user->first_name.' '.$user->last_name;
        $body = view('emails.member.member-creation')->with(['request' => $request, 'username' => $username]);

        $this->sendMail( $subject, $body, $to, $name );*/

        return redirect()->back()->with('epin_msg', 'Epin successfully created, ID: '.strtoupper($epin));
    }


    public function check( Request $request ) {

        if( !User::isMember() )
            return;

        if( !Auth::check() )
            return response()->json(['auth' => 'failed']);

        $epin = Epin::where(['user_id' => Auth::id(), 'epin_id' => $request->epin_id])->first();

        if( !$epin )
            return response()->json(['validation' => 'failed', 'message' => 'Invalid Epin!']);

        if( $epin->status !== 'accepted' )
            return response()->json(['validation' => 'failed', 'message' => 'Epin is in pending!']);

        if( $epin->epins === $epin->used_epins )
            return response()->json(['validation' => 'failed', 'message' => 'Invalid Epin!']);

        return response()->json(['validation' => 'success', 'message' => 'Valid Epin!']);
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
