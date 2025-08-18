<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Http\Controllers\Mailer;
use Session;
use App\model\Payment;
use App\model\Order;
use App\model\Meta;
use Auth;
use Cookie;
use App\model\VisiterCart;
use App\model\OrderCustomer;
use App\model\OrderProduct;
class PaymentController extends Controller
{
  
    protected $_KEY = 'rzp_live_7n9npVNnpqyqfz';//Koxton live key
    protected $_SECRET = 'ScA5FkwDdHnUc5Xlqvgu38YE';  //koxton live secret key

    // protected $_KEY = 'rzp_test_WtohVWH0Upoc4p';
    // protected $_SECRET = 'Fs4aebJTZvPgVS6EOKVpLv73';



    // protected $_KEY = 'rzp_test_QQOFoOB15oZ7eY';
    // protected $_SECRET = '5CRij0JMMeKpaaTbdVO1Bts1';        //jatin


    


    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct() {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        //
    }

    public function success( Request $request ){

        if( !$request->razorpay_payment_id || !$request->razorpay_order_id ) {
            return redirect('/')->with([
                                            'status' => 'failed',
                                            'message' => 'Payment was not successfully done!'
                                ]);
        }
        $payment = Payment::where('payment_id', $request->razorpay_order_id)->first();
        if( !$payment ) {
            return redirect('/')->with([
                                            'status' => 'failed',
                                            'message' => 'Payment was not successfully done!'
                                ]);
        }

        $order = Order::with(['order_products', 'order_customer'])->find( $payment->order_id );
        // dd($order->order_id); die();

        $api = new Api($this->_KEY, $this->_SECRET);
        $success = false;
        try {
            $attributes  = array('razorpay_signature'  => $request->razorpay_signature,
                                    'razorpay_payment_id'  => $request->razorpay_payment_id,
                                    'razorpay_order_id' => $request->razorpay_order_id
                            );

            $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        }
        catch(SignatureVerificationError $e) {
            $success = false;
        }

        $payment->status = $success ? 'success' : 'failed';
        $payment->razorpay_signature = $request->razorpay_signature;
        $payment->razorpay_payment_id = $request->razorpay_payment_id;
        $payment->razorpay_order_id = $request->razorpay_order_id;
        $payment->save();
        if( $success ) {

            $order->order_status = 'processing';
            $order->payment_status = 1;
            $order->save();
            $cookie = $request->cookie('customerCartProductList');
            $cookie = $request->cookie('customerCartProductList_buynow') ? $request->cookie('customerCartProductList_buynow') : $request->cookie('customerCartProductList');

            $cookieObj = json_decode( $cookie );
            $cart = VisiterCart::where('token', $request->cookie)->get();
            $cart = OrderProduct::where('order_id',  $order->id)->get();

            $array = ['payment' => $payment, 'order' => $order];

            $meta = Meta::all();
            $body = view('emails.order-mail', ['payment' => $payment, 'cart' => $cart, 'order' => $order,'request'=>$request])
                                ->render();
            $array = [
                            'to' => $order->order_customer[0]->email,
                            'name' => $order->order_customer[0]->first_name.' '. $order->order_customer[0]->last_name,
                            'subject' => 'Thankyou for Order - OR' . $order->order_id,
                            'message' => $body
                    ];
            
            $mail = new Mailer();
            $mail->sendMail($array);
           
            $body = view('emails.admin-order-mail', ['payment' => $payment,'cart' => $cart, 'order' => $order,'request'=>$request])
                                        ->render();
            $array = [
                            'to' => $meta->where('meta_name', 'order_email')->first()->meta_value,
                            // 'to' => 'admin@koxtonsmart.com',
                            'name' => config('app.name'),
                            'subject' => 'You have a new order - OR' . $order->order_id,
                            'message' => $body
                    ];

            $mail = new Mailer();
            // dd("Mail is ",$mail);
            $mail->sendMail($array);

            $data_dd =  Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
            return redirect()->route('payment.status', $request->razorpay_order_id)
                                ->with([
                                            'status' => 'success',
                                            'message' => 'Payment was successfully done!'
                                ])->withCookie($data_dd);
        }
        else {
            $data_dd1 =  Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
            return redirect()->route('payment.status', $request->razorpay_order_id)
                                ->with([
                                            'status' => 'failed',
                                            'message' => 'Payment was not successfully done!'
                                // ])->withCookie(Cookie::forget('customerCartProductList'));
                                    ])->withCookie($data_dd1);
        }

    }

    public function cancel()
    {
        $order_id = Session::get('order_id');
        if( !$order_id ) {
            return redirect()->route('user.home');
        }
        $payment = Payment::where('payment_id', $order_id)->first();
        if( !$payment ) {
            return redirect()->route('payment.status', $order_id)
                                ->with([
                                            'status' => 'failed',
                                            'message' => 'Payment was not successfully done!'
                                ]);
        }

        $payment->status = 'cancelled';
        $payment->save();
        $data_dd =  Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
        return redirect()->route('payment.status', $order_id)
                                ->with([
                                            'status' => 'cancelled',
                                            'message' => 'Payment was cancelled!'
                                ])->withCookie($data_dd);
    }

     public function status( $uuid )
    {
        $payment = Payment::where('razorpay_payment_id', $uuid)->first();

        if(!$payment){
            $payment = Payment::where('payment_id', $uuid)->first();
        }
        // dd("Payment status",$payment);
        return view('gift.payment.status', ['payment' => $payment, 'title' => 'Payments']);
       // return view( _template('payment.status'), ['payment' => $payment, 'title' => 'Payments']);
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
