<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\OrderRequest;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Mailer;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\MailController;
use App\model\Product;
use App\model\Order;
use App\model\Meta;
use App\model\Pincode;
use App\model\Coupon;
use App\model\OrderMeta;
use App\model\Country;
use App\model\State;
use App\model\City;
use App\model\Payment;
use App\model\File;
use App\model\Wallet;
use App\model\OrderRelation;
use App\model\OrderProduct;
use App\model\OrderCustomer;
use App\model\VisiterCart;
use App\model\WalletHistory;
use App\model\MemberCoupon;
use App\model\MemberCouponHistory;
use App\model\ProductAttributeMeta;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use PaytmWallet;

use App\User;
use Cookie;
use Hash;
use View;
use Mail;
use Auth;
use Image;
use Validator;
use Session;

class OrderController extends Controller
{

    protected $_KEY = 'rzp_live_7n9npVNnpqyqfz';  //Koxton live key
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


    public function emailtestinghere(){
         $body = view('emails.test', ['order' => '','request'=> '','cart' => ''])->render();
            $array = [
                            // 'to' => $meta->where('meta_name', 'order_email')->first()->meta_value,
                            'to' => 'mohit@techdost.com',
                            'name' => config('app.name'),
                            'subject' => 'Jtin this enjoy your trip',
                            'message' => $body
                    ];

            $mail = new Mailer();
            if($mail->sendMail($array)){
                echo "string";
            }else{
                echo"not";
            }
    }


    public function index()
    {
        if( !Auth::check() )
            return redirect()->route('login');

        return view('gift.order.index');
    }

    public function orders()
    {
        if( !Auth::check() )
            return redirect( url('/') );

        //return view(  _admin('order.index'), ['title' => 'Orders']);
    }


     public function my_profile(){
        if( !Auth::check() )
            return redirect( url('/') );

        return view('gift.order.my_profile', ['title' => 'My Profile']);   
    }



    public function my_profile_update(Request $request){
        if( !Auth::check() )
            return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                    'first_name' => 'required|max:255|string',
                    'last_name' => 'required|max:255|string',
                    'email' => 'required|email|unique:users,email,'.Auth::id(),
                    'mobile' => 'required|digits_between:10,10',
        ]);


        $user = User::find(Auth::id());
        if( count( $validator->errors() ) < 1 ) {

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            if( $request->password ){
                $user->password = Hash::make( $request->password );
            }
            $user->save();

            $request->session()->flash('profile_msg', 'Profile successfully updated!');
            Auth::setUser($user);
        }

        $old = $request->flash();

        return redirect()->back()->with('msg','Profile Updated!');
    }

    public function my_profile_password(){
        if( !Auth::check() )
            return redirect( url('/') );

        return view('gift.order.change_password', ['title' => 'Change Password']);   
    }

     public function my_profile_update_password(Request $request){
        if( !Auth::check() )
            return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                    'password' => 'required|min:8|max:255'
        ]);


        $user = User::find(Auth::id());
        if( count( $validator->errors() ) < 1 ) {

            if( $request->password ){
                $user->password = Hash::make( $request->password );
            }
            $user->save();

            $request->session()->flash('profile_msg', 'Password successfully updated!');
            Auth::setUser($user);
        }

        $old = $request->flash();

        return redirect()->back()->with('msg','Profile Updated!');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
          
        if( !Pincode::where('pincode', $request->pincode)->first() ) {
            //return redirect()->back()->with(['pincode' => 'Delivery is not available on this area!'])->withInput();
        }
        // $cookie = $request->cookie('customerCartProductList');
         $cookie  = Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
        if( !$cookie )
            return redirect()->back();

        $order_no =Order::orderby('order_id', 'DESC')->value('order_id');
        // Force cast to string explicitly before passing it to Razorpay
        // $order_no = (string) $order_no;

        // If $order_no is null or not valid, fallback to a default string
        // $order_no = $order_no ? $order_no : 'order_'.time();  // Fallback with a timestamp to ensure it's unique

        if( !$order_no )
            $order_no = Meta::where('meta_name', 'init_order_id')->value('meta_value');
        else
            $order_no++;

        $total_amount = $discount = 0;
        $coupon = $request->coupon ? Coupon::where(['code' => $request->coupon, 'status' => 'active'])
                                    ->orderby('id', 'DESC')->limit(1)->first() : false;

        $cookieObj = json_decode( $cookie );
        if( !isset( $cookieObj->token ) || !$cookieObj->token )
            return redirect()->back();

        $cart = VisiterCart::where('token', $cookieObj->token)->get();
        if( !$cart || count( $cart ) < 1 ) {
            return redirect()->back();
        }

            // $total_amount = 0;

        foreach ($cart as $coo) {
            $variation = json_decode($coo->variations);
            $price = $variation->price ? round($variation->price) : $variation->original_price;

            // Apply discount if it exists
            if (isset($variation->discount) && $variation->discount) {
                $price = round($price - ($price * $variation->discount) / 100);
            }

            // Apply tax if it exists
            if (isset($variation->tax) && $variation->tax) {
                $price = round($price + ($price * $variation->tax) / 100);
            }

            // Multiply by quantity
            $price = $price * $variation->quantity;

            // Add shipping charge if it exists
            if (isset($variation->shipping_charge)) {
                $price += $variation->shipping_charge;
            }

            // Add to total amount
            $total_amount += $price;
        }

        // echo "Total Amount: " . $total_amount;




        $type = false;
        $validCoupon = false;
        if( $coupon ) {
            $count = OrderMeta::where('coupon_id', $coupon->id)->get()->count();
            if( $coupon->usage_number && $count >= $coupon->usage_number ) {
                return redirect()->back()->with(['coupon' => 'Coupon has been expired!'])->withInput();
            }

            $start = new \DateTime( date('Y-m-d H:i:s', strtotime($coupon->start)) );
            $end = new \DateTime( date('Y-m-d H:i:s', strtotime($coupon->end)) );
            $current = new \DateTime( date('Y-m-d H:i:s') );
            if( $start < $current && $end > $current ) {
                if( $coupon->usage_amount ) {
                    if( $coupon->usage_amount > $total_amount ) {
                        return redirect()->back()->with(['coupon' => 'This coupon can be applied when you shopping more than '.$coupon->usage_amount])->withInput();
                    }
                }

                $discount = $coupon->discount;
                $type = $coupon->discount_type;
                $validCoupon = json_encode([
                                'coupon_id' => $coupon->id,
                                'discount' => $coupon->discount,
                                'discount_type' => $coupon->discount_type
                            ]);
            }
            else {
                return redirect()->back()->with(['coupon' => 'Coupon has been expired!'])->withInput();
            }
        }

        if( $type && $discount ) {
            if( $type === 'percent' ) {
                $total_amount = round($total_amount - ( $total_amount * $discount ) / 100);
            }
            else if( $type === 'inr' ) {
                $total_amount = $total_amount - $discount;
            }
        }
        // $total_amount = 1;
        $dis_amt = $used_amount = $left_amount = 0;
        $memCoupon = false;

        $country = Country::where('id', $request->country)->value('name');
        $state = State::where('id', $request->state)->value('name');
        $meta = Meta::all();
        
        
        

        if( $request->payment_method === 'razorpay' && $total_amount ) {
            $order_id = Order::create([
                            'user_id' => Auth::check() ? Auth::id() : null,
                            'order_id' => $order_no,
                            'total_amount' => $total_amount,
                            'coupon' => $coupon ? $request->coupon : null,
                            'coupon_discount_type' => $type,
                            'coupon_discount' => $discount,
                            'payment_mode' => $request->payment_method,
                            'order_status' => 'pending',
                            'address' => implode(', ', $request->address) . ', ' . $request->city . ' ' . $state . ' ' . $country.' - '.$request->pincode,
                            'mobile' => $request->mobile,
                            'alternate' => $request->alternate,
                            'remark' => $request->remark,
                            'gst_no' => $request->gst_no,
                    ])->id;
            foreach( $cart as $coo ) {
                OrderProduct::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                        'seller_id' => Product::where('id', $coo->product_id)->value('user_id'),
                                        'product_no' => $coo->product_no,
                                        'variations' => $coo->variations,
                                        'coupon' => $validCoupon ? $validCoupon : null,
                                ]);
                $var = json_decode($coo->variations);

                if( $var ) {
                    
                    if( $var->size ) {
                        $meta = ProductAttributeMeta::where('id', $var->size)->first();
                        if( $meta ) {
                            $value = json_decode($meta->value);
                            $stock = isset($value->stock) ? $value->stock - $var->quantity : 0;
                            $json = json_encode(['name' => $value->name, 'stock' => $stock, 'price' => $value->price]);
                            ProductAttributeMeta::where('id', $var->size)->update(['value' => $json]);
                        }
                    }
                }
                if( $available = Product::where('id', $coo->product_id)->value('available') ) {
                    Product::where('id', $coo->product_id)->update(['available' => --$available]);
                }

                OrderRelation::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                ]);
            }
            
            OrderCustomer::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'first_name' => $request->first_name,
                                        'last_name' => $request->last_name,
                                        'email' => $request->email,
                                        'country' => $country,
                                        'state' => $state,
                                        'city' => $request->city,
                                        'address' => json_encode($request->address),
                                        'pincode' => $request->pincode,
                                        'mobile' => $request->mobile
                                ]);
            if( !Auth::check() ) {
                $user = $this->create_user( $request, $meta );
                Auth::login($user);
                if( $user ) {
                    Order::where('id', $order_id)->update(['user_id' => $user->id]);
                }
            }
            
            $api = new Api( $this->_KEY, $this->_SECRET );
            
            $order  = $api->order->create([
                          'receipt'         =>"$order_no",
                          'amount'          => 100 * $total_amount,
                          'currency'        => 'INR',
                          'payment_capture' =>  '1'
                ]);
            $request->session()->put('order_id', $order->id);
            Payment::create([
                                    'user_id' => Auth::check() ? Auth::id() : null,
                                    'order_id' => $order_id,
                                    'payment_id' => $order->id,
                                    'amount'    => $total_amount,
                                    'currency'        => 'INR',
                                    'payment_mode' => 'online',
                            ]);
            
           
            
            $tmp = $cookieObj->token;

            VisiterCart::where('token', $cookieObj->token)->delete();
            
            return view( 'gift.payment.payment-form', [
                                    'title' => 'Checkout',
                                    'request' => $request,
                                    'state' => $state,
                                    'country' => $country,
                                    'order' => $order,
                                    'cooked' => $tmp,
                                    'key' => $this->_KEY,
                                    'secret' => $this->_SECRET
                        ]);
        }

        // paytm gateway 
        else if( $request->payment_method === 'paytm' && $total_amount ) {


            $order_id = Order::create([
                            'user_id' => Auth::check() ? Auth::id() : null,
                            'order_id' => $order_no,
                            'total_amount' => $total_amount,
                            'coupon' => $coupon ? $request->coupon : null,
                            'coupon_discount_type' => $type,
                            'coupon_discount' => $discount,
                            'payment_mode' => $request->payment_method,
                            'order_status' => 'pending',
                            'address' => implode(', ', $request->address) . ', ' . $request->city . ' ' . $state . ' ' . $country.' - '.$request->pincode,
                            'mobile' => $request->mobile,
                            'alternate' => $request->alternate,
                            'remark' => $request->remark,
                            'gst_no' => $request->gst_no,
                    ])->id;

          
            
            foreach( $cart as $coo ) {
                OrderProduct::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                        'seller_id' => Product::where('id', $coo->product_id)->value('user_id'),
                                        'product_no' => $coo->product_no,
                                        'variations' => $coo->variations,
                                        'coupon' => $validCoupon ? $validCoupon : null,
                                ]);
                $var = json_decode($coo->variations);
                if( $var ) {
                    if( $var->size ) {
                        $meta = ProductAttributeMeta::where('id', $var->size)->first();
                        if( $meta ) {
                            $value = json_decode($meta->value);
                            $stock = isset($value->stock) ? $value->stock - $var->quantity : 0;
                            $json = json_encode(['name' => $value->name, 'stock' => $stock, 'price' => $value->price]);
                            ProductAttributeMeta::where('id', $var->size)->update(['value' => $json]);
                        }
                    }
                }
                if( $available = Product::where('id', $coo->product_id)->value('available') ) {
                    Product::where('id', $coo->product_id)->update(['available' => --$available]);
                }

                OrderRelation::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                ]);
            }

            if( !Auth::check() ) {
                $user = $this->create_user( $request, $meta );
                Auth::login($user);
                if( $user ) {
                    Order::where('id', $order_id)->update(['user_id' => $user->id]);
                }
            }
            

            OrderCustomer::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'first_name' => $request->first_name,
                                        'last_name' => $request->last_name,
                                        'email' => $request->email,
                                        'country' => $country,
                                        'state' => $state,
                                        'city' => $request->city,
                                        'address' => json_encode($request->address),
                                        'pincode' => $request->pincode,
                                        'mobile' => $request->mobile
                                ]);
            
            // $api = new Api( $this->_KEY, $this->_SECRET );
            // $order  = $api->order->create([
            //               'receipt'         => $order_no,
            //               'amount'          => 100 * $total_amount,
            //               'currency'        => 'INR',
            //               'payment_capture' =>  '0'
            //     ]);

           

            Payment::create([
                                    'user_id' => Auth::check() ? Auth::id() : null,
                                    'order_id' => $order_id,
                                    'payment_id' => $order_id,
                                    'amount'    => $total_amount,
                                    'currency'        => 'INR',
                                    'payment_mode' => 'online',
                            ]);

            // session('set_request',$request);
            Session::put('set_request',$request->all());

            $request->session()->put('order_id', $order_id);
            $payment = PaytmWallet::with('receive');
                $payment->prepare([
                  'order' => $order_id,
                  'user' => Auth::check() ? Auth::id() : null,
                  'mobile_number' => $request->mobile,
                  'email' => $request->email,
                  'amount' => $total_amount,
                  'token_cookie'=> $cookieObj->token,
                  'callback_url' => 'https://koxtonsmart.com/paytm/payment/status?aa='.$cookieObj->token
                ]);
             return  $payment->receive();
            
           
            
            $tmp = $cookieObj->token;



            // VisiterCart::where('token', $cookieObj->token)->delete();

            // return view( 'gift.payment.payment-form-paytm', [
            //                     'title' => 'Checkout',
            //                     'request' => $request,
            //                     'state' => $state,
            //                     'country' => $country,
            //                     'order' => $order,
            //                     'cooked' => $tmp,
            //                     'key' => $this->_KEY,
            //                     'secret' => $this->_SECRET
            //         ]);
        }
        // paytm gateway 
        else if( $request->payment_method === 'cod' && $total_amount ) {

            
            $order_id = Order::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_no,
                                        'total_amount' => $total_amount,
                                        'coupon' => $coupon ? $request->coupon : null,
                                        'coupon_discount_type' => $type,
                                        'coupon_discount' => $discount,
                                        'payment_mode' => $request->payment_method,
                                        'order_status' => 'processing',
                                        'address' => implode(', ', $request->address) . ', ' . $request->city . ' ' . $state . ' ' . $country.' - '.$request->pincode,
                                        'mobile' => $request->mobile,
                                        'remark' => $request->remark,
                                        'gst_no' => $request->gst_no,
                                ])->id;

            foreach( $cart as $coo ) {
                OrderProduct::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                        'product_no' => $coo->product_no,
                                        'variations' => $coo->variations,
                                        'coupon' => $validCoupon ? $validCoupon : null,
                                ]);
                $var = json_decode($coo->variations);
                if( $var ) {
                    if( $var->size ) {
                        $meta = ProductAttributeMeta::where('id', $var->size)->first();
                        if( $meta ) {
                            $value = json_decode($meta->value);
                            $stock = isset($value->stock) ? $value->stock - $var->quantity : 0;
                            $json = json_encode(['name' => $value->name, 'stock' => $stock, 'price' => $value->price]);
                            ProductAttributeMeta::where('id', $var->size)->update(['value' => $json]);
                        }
                    }
                }
                if( $available = Product::where('id', $coo->product_id)->value('available') ) {
                    Product::where('id', $coo->product_id)->update(['available' => --$available]);
                }
                OrderRelation::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'product_id' => $coo->product_id,
                                ]);
            }
            OrderCustomer::create([
                                        'user_id' => Auth::check() ? Auth::id() : null,
                                        'order_id' => $order_id,
                                        'first_name' => $request->first_name,
                                        'last_name' => $request->last_name,
                                        'email' => $request->email,
                                        'country' => $country,
                                        'state' => $state,
                                        'city' => $request->city,
                                        'address' => json_encode($request->address),
                                        'pincode' => $request->pincode,
                                        'mobile' => $request->mobile
                                ]);
            $payment_id = 'order_'.randomString(16);
            Payment::create([
                                    'user_id' => Auth::check() ? Auth::id() : null,
                                    'order_id' => $order_id,
                                    'payment_id' => $payment_id,
                                    'amount'    => $total_amount,
                                    'currency'        => 'INR',
                                    'payment_mode' => 'cod',
                                    'status'        => 'pending',
                            ]);

            $order = Order::with(['order_customer', 'order_products'])->find($order_id);
            $body = view('emails.order-mail', ['order' => $order,'request' => $request,'cart' => $cart])
                                ->render();
            $array = [
                            'to' => $request->email,
                            'name' => $request->first_name.' '. $request->last_name,
                            'subject' => 'Thank you for Order - OR' . $order->order_id,
                            'message' => $body
                    ];



            $mail = new Mailer();
            $mail->sendMail($array);

            $body = view('emails.admin-order-mail', ['order' => $order,'request'=> $request,'cart' => $cart])
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

            // if( !Auth::check() && $request->createaccount ) {

            if( !Auth::check() ) {
                $user = $this->create_user( $request, $meta );
                Auth::login($user);
                if( $user ) {
                    Order::where('id', $order_id)->update(['user_id' => $user->id]);
                }
            }

         $data_dd =  Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
            VisiterCart::where('token', $cookieObj->token)->delete();
            


            return redirect()->route('payment.status', $payment_id)
                                ->with([
                                            'status' => 'success',
                                            'message' => 'Order successfully placed!'
                                // ])->withCookie(Cookie::forget('customerCartProductList'));
                                ])->withCookie($data_dd);
        }

        return redirect()->back()->with(['order_err' => 'Order could not place!'])->withInput();
    }


    // public function ccavenue( $request, $order_id, $amount ) {

    //     foreach ($parameters as $key => $value){
    //       $this->merchant_data.=$key.'='.$value.'&';
    //     }
    //     $encrypted_data = $this->encrypt($this->merchant_data, $this->working_key);
    //     $array = array(
    //                     'endPoint' => $this->endPoint,
    //                     'access_code' => $this->access_code,
    //                     'encrypted_data' => $encrypted_data
    //                 );
    //     return view('gift/cc/ccform', $array);
    // }

    public function create_user( $request, $meta ) {
        
        if( $user = User::where('email', $request->email)->first() ) {
            Auth::loginUsingId($user->id);
            User::where('email', $request->email)->update(['role' => 'customer']);
            $body = view('emails.login-exist-mail', ['request' => $request])->render();
            $array = [
                            'to' => $request->email,
                            'name' => $request->first_name.' '. $request->last_name,
                            'subject' => 'You are our already customer - '.config('app.name'),
                            'message' => $body
                    ];

            // $mail = new MailController();
            // $mail->sendAutoMail($array);
            $mail = new Mailer();
            $mail->sendMail($array);
            return $user;
        }
        $password = randomString(10);
        $user = new User();
        $user->role = 'customer';
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->uid = uniqueID(8);
        $user->password = Hash::make( $password );
        $user->save();
        $body = view('emails.login-mail', ['password' => $password, 'request' => $request])
                                ->render();
        $array = [
                        'to' => $request->email,
                        'name' => $request->first_name,
                        'subject' => 'Thank you for becoming our customer - '.config('app.name'),
                        'message' => $body
                ];

        // $mail = new MailController();
        // $mail->sendAutoMail($array);
        $mail = new Mailer();
        $mail->sendMail($array);
        return $user;
    }

    public function sendMail__( $subject, $body, $to, $name ) {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '';                 // SMTP username
            $mail->Password = '';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $noreply = 'noreply@koxtonsmart.com';
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

    public function upload( $image ) {

        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        $resize = Image::make( $image->getRealPath() )
                                    ->encode($image->getClientOriginalExtension());
        $resize->save( public_path( 'images/' ) . $filename );

        return $filename;
    }

    public function send_mail( $request, $message, $subject, $array, $from, $to, $app_name ) {
        $name = $request->first_name;
        Mail::send($message, $array, function($message) use ($from, $to, $name, $subject, $app_name)
        {
            $message->from( $from, $app_name );
            $message->to($to, $name);
            $message->subject($subject. ' - '.$app_name);
        });
    }


    public function success( Request $request, $id ) {

        /*if( !$request->session()->has('order_success') )
            return redirect( url('/') );*/

        return view('gift.order.success', ['order_id' => $id]);
    }


    public function show( $order_id ) {
        return view(  _admin('order.view'), ['title' => 'View Order', 'order_id' => $order_id]);
    }


    public function orderPaymentRequest( $order_id ) {

        $order = Order::where('order_id', $order_id)->first();

        if( $order ) {

            $orders = Order::where('order_id', $order->order_id)->get();
            $orderMeta = OrderMeta::where('order_id', $order->order_id)->first();
            $coupon = $orderMeta ? Coupon::where('id', $orderMeta->coupon_id)->first() : false;
            $price = 0; $total_amount = 0;

            if( $orders && count( $orders ) ) {
                foreach( $orders as $o ) {
                    $product = Product::where('id', $o->product_id)->first();
                    $price = $product ? $product->price : 0;
                    if( $product && $product->discount )
                        $total_amount += $price - ($price * $product->discount) / 100;
                    else
                        $total_amount += $product ? $product->price : 0;
                }
            }
            if( $orderMeta ) {
                if( $orderMeta->discount_type == 'inr' )
                    $total_amount = $total_amount - $orderMeta->discount;
                else
                    $total_amount = $total_amount - ($total_amount * $orderMeta->discount) / 100;
            }           

            $parameters = [
                              'tid' => date('dmy').time(),
                              'merchant_id' => $this->merchant_id,
                              'order_id' => $order_id,
                              'amount' => round($total_amount, 0),
                              'currency' => $this->currency,
                              'redirect_url' => $this->redirect_url,
                              'cancel_url' => $this->cancel_url,
                              'language' => $this->language,
                              'billing_name' => $order->first_name . ' ' . $order->last_name,
                              'billing_address' => $order->address,
                              'billing_city' => $order->city,
                              'billing_state' => State::where('id', $order->state_id)->value('name'),
                              'billing_zip' => $order->pincode,
                              'billing_country' => Country::where('id', $order->country)->value('name'),
                              'billing_tel' => $order->mobile,
                              'billing_email' => $order->email,
                            ];

            return redirect()->route('payment')->with(['parameters' => $parameters, 'order_success' => 'Order placed successfully!']);
        }

        return redirect( url('/') );
    }


    public function encrypt($plainText,$key)
    {
      $encryptionMethod = "AES-128-CBC";
      $secretKey = $this->hextobin(md5($key));
      $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
      $encryptedText = openssl_encrypt($plainText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
      return bin2hex($encryptedText);

    }

    public function decrypt($encryptedText,$key)
    {
      $encryptionMethod   = "AES-128-CBC";
      $secretKey    = $this->hextobin(md5($key));
      $initVector     =  pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
      $encryptedText    = $this->hextobin($encryptedText);
      $decryptedText    =  openssl_decrypt($encryptedText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
      return $decryptedText;
    }

    public function pkcs5_pad ($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

  //********** Hexadecimal to Binary function for php 4.0 version ********

    public function hextobin($hexString) 
    { 
          $length = strlen($hexString); 
          $binString="";   
          $count=0; 
          while($count<$length) 
          {       
              $subString =substr($hexString,$count,2);           
              $packedString = pack("H*",$subString); 
              if ($count==0)
              {
                $binString=$packedString;
              } 
                    
              else 
              {
                $binString.=$packedString;
              } 
                    
              $count+=2; 
          } 
          return $binString; 
    }


    public function upload_files( $order_id ) {
        $order = Order::where(['order_id' => $order_id])->first();
        if( !$order )
            return redirect( url('/') );

        return view(  _template('order.files'), ['title' => 'Upload files', 'order' => $order]);
    }


    public function store_file( Request $request ) {

        $validator = Validator::make($request->all(), [
                                'order_id' => 'required',
                                'orderno' => 'required',
                                'files' => 'required|array|max:20',
                                'files.*' => 'required|mimes:jpg,jpeg,png,gif|max:1024'
                    ],[
                            'files.*.required' => 'File is required *',
                            'files.required' => 'File is required *',
                            'files.array' => 'File is required *',
                            'files.*.mimes' => 'File must be a jpeg, jpg, png or gif only!',
                            'files.*.max' => 'Each file size must be less than 1MB',
                    ]);
        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator);
        }

        $order = Order::where(['id' => $request->order_id, 'order_id' => $request->orderno])->first();
        if( !$order )
            return redirect()->back()->with('file_status', 'File could not upload!');

        $files = [];
        if( $request->hasFile('files') ) {
            foreach ($request->file('files') as $file) {
                $file = $this->upload( $file );
                $files[] = $file;
                File::create([
                                'order_id' => $request->order_id,
                                'order_no' => $request->orderno, 
                                'file' => $file
                        ]);
            }
        }

        $body = view('emails.order-files', ['request' => $request, 'files' => $files, 'order' => $order])->render();

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            
            /*$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'surprisegeniegifts@gmail.com';                 // SMTP username
            $mail->Password = '*9634625229*';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to*/

            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', 'koxtonsmart');
            //$mail->addAddress('surprisegeniegifts@gmail.com', 'koxtonsmart');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'File upload for order - '.$request->orderno;
            $mail->Body    = $body;

            $mail->send();
            
        } catch (Exception $e) {
            
        }

        return redirect()->back()->with('file_success', 'File uploaded successfully!');
    }


    public function cancel( Request $request ) {

        if( !Auth::check() ) {
            return redirect('/');
        }

        if( $request->ajax() )
            return;

        if( !$request->id || !$request->order_id )
            return redirect()->back()->withErrors(['can_err' => 'Order could not cancel!']);

        if( !Order::where(['id' => $request->id, 'order_id' => $request->order_id])->update(['order_status' => 'cancel']) )
            return redirect()->back()->withErrors(['can_err' => 'Order could not cancel!']);

        $body = view('emails.order-cancel-request', ['request' => $request])->render();
        $subject = 'Order Cancellation Request, Ordr No:'.$request->order_id;
        $to =  'admin@koxtonsmart.com';
        $name = config('app.name');
        
        $this->sendMail__( $subject, $body, $to, $name );

        return redirect()->back()->withErrors(['can_msg' => 'Order cancellation request sent! ID:'.$request->order_id]);
    }

}