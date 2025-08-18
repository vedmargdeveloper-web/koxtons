<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Order;
use App\model\Complain;
use App\model\OrderCustomer;
use App\model\Meta;
use Auth;
use Session;
use Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function search_order( Request $request ) {

        if( !$request->ajax() )
            return response()->json(['error' => 'Page not found!'], 404);

        if( !$request->order_no )
            return response()->json(['order_no' => 'Order no. is required *'], 400);

        if( !$request->mobile )
            return response()->json(['mobile' => 'Mobile no. is required *'], 400);

        $order = Order::with(['order_customer', 'order_products'])->where(['mobile' => $request->mobile, 'order_id' => $request->order_no])->first();

        if( !$order )
            return response()->json(['error' => 'Order not found!'], 404);

        $array = [
                    'product' => $order->order_products[0]->variations,
                    'product_id' => $order->order_products[0]->product_id,
                    'product_no' => $order->order_products[0]->product_no,
                    'order_id' => $order->id,
                    'order_no' => $order->order_id,
                    'total_amount' => $order->total_amount,
                    'customer_name' => $order->order_customer[0]->first_name.' '.$order->order_customer[0]->last_name,
                    'email' => $order->order_customer[0]->email,
                    'address' => $order->address,
                    'pincode' => $order->order_customer[0]->pincode,
                    'mobile' => $order->order_customer[0]->mobile,
                    'order_date' => $order->created_at,
                    'order_status' => $order->order_status,
                    'payment_status' => $order->payment_status,
                ];

                //var_dump($order->order_products[0]->variations);

        return view( _template('return.form'), ['order' => $order]);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [  'order_id' => 'required',
                        'order_no' => 'required',
                        'return_type' => 'required|max:25',
                        'reason' => 'required|max:30',
                        'remark' => 'required|max:1000'
                    ];
        if( $request->return_type === 'refund' ) {
            $rules = [  'order_id' => 'required',
                        'order_no' => 'required',
                        'return_type' => 'required|max:25',
                        'reason' => 'required|max:30',
                        'remark' => 'required|max:1000',
                        'acc_holder_name' => 'required|max:255',
                        'account_no' => 'required|max:255',
                        'ifsc_code' => 'required|max:25',
                        'bank_name' => 'required|max:100'
                    ];
        }
        
        $validator = Validator::make( $request->all(), $rules, [
                                'order_id.required' => 'Something went wrong, please try again later!',
                                'order_no.required' => 'Something went wrong, please try again later!',
                                'return_type.required' => 'Please choose an option!',
                                'return_type.max' => 'Return type must be valid!',
                                'reason.required' => 'Please select an option!',
                                'reason.max' => 'Reason must be valid!',
                                'remark.required' => 'Please explain the reason!',
                                'remark.max' => 'Remark can have upto 255 characters!',
                                'acc_holder_name.required' => 'Account holder name is required *',
                                'acc_holder_name.max' => 'Account holder name can have upto 255 characters!',
                                'account_no.required' => 'Account no. is required *',
                                'account_no.max' => 'Account no. must be valid!',
                                'ifsc_code.required' => 'IFSC no. is required *',
                                'ifsc_code.max' => 'IFSC no. must be valid!',
                                'bank_name.required' => 'Bank name is required *',
                                'bank_name.max' => 'Bank name must be valid!',
                    ]);
        if( $validator->fails() )
            return response()->json(['errors' => $validator->errors()]);



        $order = Order::where(['id' => $request->order_id, 'order_id' => $request->order_no])->first();
        if( !$order )
            return response()->json(['errors' => ['error' => 'Something went wrong, please try again later!']]);

        $customer = OrderCustomer::where('order_id', $order->id)->first();
        if( !$customer )
            return response()->json(['errors' => ['error' => 'Something went wrong, please try again later!']]);

        $complain_no = Complain::latest()->value('complain_no');
        if( !$complain_no )
            $complain_no = 110001;
        else
            $complain_no++;
        
        Complain::create([
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'complain_no' => $complain_no,
                    'order_id' => $request->order_id,
                    'order_no' => $request->order_no,
                    'return_type' => $request->return_type,
                    'reason' => $request->reason,
                    'message' => $request->remark,
                    'acc_holder_name' => $request->acc_holder_name,
                    'ifsc_code' => $request->ifsc_code,
                    'account_no' => $request->account_no,
                    'bank_name' => $request->bank_name
                ]);

        $subject = 'A new complain for Order No: ' . $request->order_no;
        $body = view('emails.complain.complain', ['request' => $request, 'complain_no' => $complain_no])->render();
        $noreply = Meta::where('meta_name', 'noreply')->value('meta_value');

        $mail = new PHPMailer(true);
        try {
            
            $mail->setFrom($noreply, config('app.name'));
            $to = Meta::where('meta_name', 'order_email')->value('meta_value');
            $mail->addAddress('amitkumar@1solutions.biz', config('app.name'));
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();

        } catch (Exception $e) {
            return response()->json(['errors' => ['error' => 'Something went wrong, please try again later!']]);
        }

        $subject = 'Complain received for Order No: ' . $request->order_no;
        $body = view('emails.complain.customer-complain', ['request' => $request, 'complain_no' => $complain_no, 'customer' => $customer])->render();

        $mail = new PHPMailer(true);
        try {
            $mail->setFrom($noreply, config('app.name'));
            $mail->addAddress('amitkumar@1solutions.biz', $customer->first_name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();

            Session::flash('complain_msg', 'Your complain successfully sent!');
            return response()->json(['errors' => false, 'message' => 'success', 'url' => route('order.complain.success', $complain_no)]);
        } catch (Exception $e) {
            return response()->json(['errors' => ['error' => 'Something went wrong, please try again later!']]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if( !Session::has('complain_msg') )
            return redirect('/');

        $complain = Complain::where('complain_no', $id)->first();
        return view( _template('return.success'), ['title' => 'Complaint successfully sent', 'complain' => $complain] );
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
