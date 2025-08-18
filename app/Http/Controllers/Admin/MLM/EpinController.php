<?php

namespace App\Http\Controllers\Admin\MLM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EpinRequest;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\model\Epin;
use App\model\Meta;
use App\User;
use App\model\Relation;
use Auth;
use Validator;

class EpinController extends Controller
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

        return view('gift.admin.mlm.epin.index', ['title' => 'Epins']);
    }

    public function requested()
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        return view('gift.admin.mlm.epin.requested', ['title' => 'Requested Epin']);
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

        return view('gift.admin.mlm.epin.create', ['title' => 'Sell Epin']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                                        'reference' => 'nullable',
                                        'package' => 'required',
                                        'amount' => 'required|numeric|max:10000000',
                                        'payment_mode' => 'required',
                                        'payment_date' => 'required',
                                        'image' => 'nullable|mimes:jpeg,jpg,png|max:2048'
                            ]);
        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        $user = false;
        if( $request->reference ) {
            $user = User::where('username', $request->reference)->first();
            if( !$user )
                return redirect()->back()->with('epin_err', 'Reference not found!');
        }

        $file = $request->hasFile('image') ? $request->file('image')->store('files', 'public') : null;
        $epin = uniqueEPIN(8);
        $epin_id = Epin::create([
                                    'reference_id' => Auth::id(),
                                    'user_id' => $user && $user->id ? $user->id : Auth::id(),
                                    'package' => $request->package,
                                    'epin_id' => $epin,
                                    'epins' => 1,
                                    'amount' => $request->amount,
                                    'payment_mode' => $request->payment_mode,
                                    'payment_date' => $request->payment_date,
                                    'remark' => $request->remark,
                                    'image' => $file ? $file : null,
                                    'status' => 'accepted',
                            ])->id;
        Relation::create([
                                'user_id' => $user && $user->id ? $user->id : Auth::id(),
                                'epin_id' => $epin_id
                    ]);

        return redirect()->back()->with('epin_msg', 'Epin successfully created, ID: '.strtoupper($epin));
    }



    public function check( Request $request ) {

        if( !User::isAdmin() )
            return response()->json(['auth' => 'failed']);

        $epin = Epin::where(['epin_id' => $request->epin_id])->first();

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


    public function view($id)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $epin = Epin::with('user')->where('id', $id)->first();
        return view('gift.admin.mlm.epin.view', ['title' => 'View Requested Epin', 'epin' => $epin]);
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

        $epin = Epin::with('user')->find($id);
        return view('gift.admin.mlm.epin.edit', ['title' => 'Edit Epin'])->with('epin', $epin);
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

        if( !User::isAdmin() )
            return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                                        'reference' => 'nullable',
                                        'package' => 'required',
                                        'epins' => 'required|numeric',
                                        'amount' => 'required|numeric|max:10000000',
                                        'payment_mode' => 'required',
                                        'payment_date' => 'required',
                                        'cheque_no' => 'nullable|max:255',
                            ]);
        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        $user = false;
        if( $request->reference ) {
            $user = User::where('username', $request->reference)->first();
            if( !$user )
                return redirect()->back()->with('epin_err', 'Reference not found!');
        }

        $epin = Epin::findOrFail( $id );

        $array = [
                        'reference_id' => Auth::id(),
                        'user_id' => $user && $user->id ? $user->id : Auth::id(),
                        'package' => $request->package,
                        'epin_id' => uniqueEPIN(8),
                        'epins' => $request->epins,
                        'amount' => $request->amount,
                        'payment_mode' => $request->payment_mode,
                        'payment_date' => $request->payment_date,
                        'remark' => $request->remark,
                        'status' => 'accepted',
                ];
        $epin->fill($array)->save();

        if( Relation::where( 'epin_id', $id )->first() ) {
            Relation::where('epin_id', $id)->update([
                                'user_id' => $user && $user->id ? $user->id : Auth::id()
                    ]);
        }
        else {
            Relation::create([
                                'user_id' => $user && $user->id ? $user->id : Auth::id(),
                                'epin_id' => $id
                    ]);
        }

        return redirect()->back()->with('epin_msg', 'Epin successfully updated!');
    }


    public function accept( $id ) {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $epin = Epin::find($id);
        if( !$epin )
            return redirect()->back()->with('epin_err', 'Epin not found!');

        $user = User::find( $epin->user_id );
        if( !$user )
            return redirect()->back()->with('epin_err', 'Member not found!');

        Epin::where('id', $id)->update(['status' => 'accepted']);


        $subject = 'Your EPIN Request Accepted - ' . config('app.name');
        $to = $user->email;
        $name = $user->first_name.' '.$user->last_name;
        $body = view('emails.member.epin-accept')->with(['epin' => $epin, 'user' => $user]);

        $this->sendMail( $subject, $body, $to, $name );

        return redirect()->back()->with('epin_msg', 'Epin request accepted!');
    }

    public function sendMail( $subject, $body, $to, $name ) {

        $mail = new PHPMailer(true);
        try {
            $noreply = Meta::where('meta_name', 'noreply')->value('meta_value');
            $noreply = $noreply ? $noreply : 'noreply@boomingmart.com';
            $mail->setFrom($noreply, config('app.name'));
            $mail->addAddress($to, $name);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }


    public function reject( $id ) {
        
        if( !User::isAdmin() )
            return redirect( url('/') );

        Epin::where('id', $id)->update(['status' => 'rejected']);
        return redirect()->back()->with('epin_msg', 'Epin request rejected!');
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
