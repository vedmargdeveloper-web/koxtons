<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\model\Complain;
use App\model\Meta;
use App\model\ComplainStatus;
use App\model\OrderCustomer;

use App\User;
use Auth;
use App\model\LogsModel;


class ComplainController extends Controller
{


    public function __construct() {

        // $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        return view( _admin('complain.contact'), ['title' => 'Complains'] );
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

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $complain = Complain::find( $id );
        return view( _admin('complain.show'), ['title' => 'View Complain', 'complain' => $complain] );
    
    }

    public function update_status( Request $request ) {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        if( $request->ajax() )
            return response()->json('', 404);
        
        $request->validate([
                                'status' => 'required|max:50',
                                'message' => 'required|max:1000',
                ]);


        $complain = Complain::find( $request->complain_id );
        if( !$complain )
            return redirect()->back()->withErrors(['error' => 'Complain not found!'])->withInput();

        $customer = OrderCustomer::where('order_id', $complain->order_id)->first();
        if( !$customer )
            return redirect()->back()->withErrors(['error' => 'Customer details not found!'])->withInput();


        $subject = 'Complain updation Order No: ' . $complain->order_no . ', Complain No: ' . $complain->complain_no ;
        $body = view('emails.complain.complain-update', ['request' => $request, 'complain' => $complain, 'customer' => $customer])->render();
        $noreply = Meta::where('meta_name', 'noreply')->value('meta_value');

        $mail = new PHPMailer(true);
        try {
            $mail->setFrom($noreply, config('app.name'));
            $mail->addAddress($customer->email, ucwords($customer->first_name.' '.$customer->last_name) );
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['complain_err', 'Something went wrong, please try again later!'])->withInput();
        }

        $complain->status = $request->status;
        $complain->save();

        ComplainStatus::create([
                                    'complain_id' => $request->complain_id,
                                    'status' => $request->status,
                                    'message' => $request->message,
                            ]);

        LogsModel::create(['user_id' => Auth::id(),'remark'=>'Complain update','status'=>'complain', 'working_id' => $request->complain_id]);

        return redirect()->back()->with(['message' => 'Status successfully updated, Complain No:'.$complain->complain_no]);
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
