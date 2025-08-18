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

use App\User;
use Cookie;
use App\model\VisiterCart;
use App\model\OrderCustomer;
use App\model\OrderProduct;
use PaytmWallet;



class PaytmController extends Controller
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


    public function makeorder()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $order->id,
          'user' => $user->id,
          'mobile_number' => $user->phonenumber,
          'email' => $user->email,
          'amount' => $order->amount,
          'callback_url' => 'https://koxtonsmart.com/paytm/payment/status'
        ]);
        return $payment->receive();
    }

    // public function order()
    // {
    //     $payment = PaytmWallet::with('receive');
    //     $payment->prepare([
    //       'order' => $order->id,
    //       'user' => $user->id,
    //       'mobile_number' => $user->phonenumber,
    //       'email' => $user->email,
    //       'amount' => $order->amount,
    //       'callback_url' => 'http://example.com/paytm/payment/status'
    //     ]);
    //     return $payment->view('your_custom_view')->receive();
    // }


    public function paymentCallback( Request $request)
    {
        $transaction = PaytmWallet::with('receive');
        
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        $token_cookieObj =  $_GET['aa'];
    

        if( isset($response['ORDERID']) ) {
            $payment = Payment::where('payment_id', $response['ORDERID'])->first();
            if($response['STATUS'] == 'TXN_SUCCESS'){
                $payment->status = 'success';
            }if($response['STATUS'] == 'TXN_FAILURE'){
                $payment->status ='failed';
            }
            $payment->razorpay_payment_id = $response['TXNID'];
            $payment->razorpay_order_id = $response['TXNID'];
            $payment->paytm = json_encode($response);
            $payment->save();
        }

        if($transaction->isSuccessful()){
      
            return $this->success_order($response['ORDERID'], $response['TXNID'], $token_cookieObj);

          //Transaction Successful
        }else if($transaction->isFailed()) {

            return $this->order_fail($response['ORDERID'], $response['TXNID'], $token_cookieObj );

        }else if($transaction->isOpen()){
          //Transaction Open/Processing
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id
    }    

    
    public function success_order($order_id, $txn_id, $token_cookieObj){
        $user = User::with('userdetail')->where('id', Auth::id())->first();
        $order = Order::with(['order_products', 'order_customer'])->find( $order_id );
        $payment = Payment::where('payment_id', $order_id)->first();
        $order->order_status = 'processing';
            $order->payment_status = 1;
            $order->save();
            // $cookie = $request->cookie('customerCartProductList');
            // $cookie = $request->cookie('customerCartProductList_buynow') ? $request->cookie('customerCartProductList_buynow') : $request->cookie('customerCartProductList');
            $cookie = $token_cookieObj;
            $cookieObj = json_decode( $cookie );
            $cart = VisiterCart::where('token', $cookie)->get();
            $cart = OrderProduct::where('order_id',  $order_id)->get();

            $array = ['payment' => $payment, 'order' => $order];

            $meta = Meta::all();
            $body = view('emails.order-mail', ['payment' => $payment, 'cart' => $cart, 'order' => $order,'request'=> Session::get('set_request')])
                                ->render();


            $array = [
                            'to' => $order->order_customer[0]->email,
                            'name' => $order->order_customer[0]->first_name.' '. $order->order_customer[0]->last_name,
                            'subject' => 'Thankyou for Order - OR' . $order->order_id,
                            'message' => $body
                    ];

            $mail = new Mailer();
            $mail->sendMail($array);

            $body = view('emails.admin-order-mail', ['payment' => $payment,'cart' => $cart, 'order' => $order,'request'=> Session::get('set_request')])
                                        ->render();
            $array = [
                            // 'to' => $meta->where('meta_name', 'order_email')->first()->meta_value,
                            'to' => 'admin@koxtonsmart.com',
                            'name' => config('app.name'),
                            'subject' => 'You have a new order - OR' . $order->order_id,
                            'message' => $body
                    ];

            $mail = new Mailer();
            $mail->sendMail($array);
            // $data_dd =  Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
            $cookie = $token_cookieObj;
            VisiterCart::where('token', $cookie)->delete();
            Cookie::forget($cookie);
            return redirect()->route('payment.status', $txn_id )
                                ->with([
                                            'status' => 'success',
                                            'message' => 'Payment was successfully done!'
                                ])->withCookie($cookie);
    }

    public function order_fail($order_id, $txn_id, $token_cookieObj){

        $order = Order::find( $order_id );
        $order->order_status = 'processing';
        $order->payment_status = 'failed';
        $order->save();
        $cookie = $token_cookieObj;

        VisiterCart::where('token', $cookie)->delete();
        Cookie::forget($cookie);
        return redirect()->route('payment.status', $txn_id)
                            ->with([
                                        'status' => 'failed',
                                        'message' => 'Payment was not successfully done!'
                            ])->withCookie(Cookie::forget($cookie));
                                
    }



    public function statusCheck(){
        $status = PaytmWallet::with('status');
        $status->prepare(['order' => $order->id]);
        $status->check();
        
        $response = $status->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=txn-status-api-description
        
        if($status->isSuccessful()){
          //Transaction Successful
        }else if($status->isFailed()){
          //Transaction Failed
        }else if($status->isOpen()){
          //Transaction Open/Processing
        }
        $status->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $status->getOrderId(); // Get order id
        $status->getTransactionId(); // Get transaction id
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
