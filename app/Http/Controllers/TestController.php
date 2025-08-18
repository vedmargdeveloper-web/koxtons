<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\OrderRequest;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
use App\model\Category;

use Validator;
use App\User;
use Cookie;
use Hash;
use View;
use Mail;
use Auth;

class TestController extends Controller
{

    protected $endPoint = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
    protected $working_key = 'E69FA483143006C636559A46681C3570';//Shared by CCAVENUES
    protected $access_code = 'AVLL79FH73AU11LLUA';//Shared by CCAVENUES
    protected $merchant_data = '';
    protected $merchant_id = 186786;
    protected $redirect_url = 'https://surprisegenie.com/response/ccavResponseHandler.php';
    protected $cancel_url = 'https://surprisegenie.com/response/ccavResponseHandler.php';
    protected $currency = 'INR';
    protected $language = 'EN';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !Auth::check() )
            return redirect()->route('login');

        return view('gift.order.index');
    }

    public function orders()
    {
        return view(  _admin('order.index'), ['title' => 'Orders']);
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
            return redirect()->back()->with(['pincode' => 'Delivery is not available on this area!'])->withInput();
        }

        $order_id = Order::orderby('order_id', 'DESC')->value('order_id');
        if( !$order_id )
            $order_id = Meta::where('meta_name', 'init_order_id')->value('meta_value');
        else
            $order_id++;

        $total_amount = 0;

        $coupon = Coupon::where(['code' => $request->coupon, 'status' => 'active'])
                                    ->orderby('id', 'DESC')->limit(1)->first(['id', 'usage_number', 'discount', 'usage_amount', 'start', 'end', 'discount_type']);
        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode( $cookie );
            foreach( $cookieObj as $coo ) {

                $price = round( $coo->price );

                if( isset($coo->discount) && $coo->discount )
                  $price = round( $price - ( $price * $coo->discount ) / 100 ) * $coo->quantity;
                else
                  $price = $price * $coo->quantity;

                $total_amount += $price;
            }
        }


        $discount = 0;
        $type = false;
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
                $array = array(
                                'order_id' => $order_id,
                                'coupon_id' => $coupon->id,
                                'discount' => $coupon->discount,
                                'discount_type' => $coupon->discount_type
                            );
                if( OrderMeta::where('order_id', $order_id)->first() )
                    OrderMeta::where('order_id', $order_id)->update( $array );
                else
                    OrderMeta::create( $array );
            }
            else
                return redirect()->back()->with(['coupon' => 'Coupon has been expired!'])->withInput();
        }


        

        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode( $cookie );
            foreach( $cookieObj as $coo ) {

                $price = round( $coo->price );

                if( isset($coo->discount) && $coo->discount )
                  $price = round( $price - ( $price * $coo->discount ) / 100 ) * $coo->quantity;
                else
                  $price = $price * $coo->quantity;

                $order = new Order();
                $order->order_id = $order_id;
                $order->product_id = $coo->product_id;
                $order->quantity = $coo->quantity;
                $order->price = $coo->price;
                $order->discount = $coo->discount;
                $order->user_id = Auth::check() ? Auth::id() : null;
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->email = $request->email;
                $order->country_id = $request->country;
                $order->state_id = $request->state;
                $order->city = $request->city;
                $order->address = json_encode($request->address);
                $order->pincode = $request->pincode;
                $order->mobile = $request->mobile;
                
                $order->payment_mode = $request->payment_method;
                $order->save();

                $product_quantity = Product::where('product_id', $coo->product_id)->value('quantity');
                $available = $product_quantity ? $product_quantity - $coo->quantity : 0;
                Product::where('product_id', $coo->product_id)->update(['available' => $available]);
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

        if( $request->payment_method === 'ccavenue' && $total_amount ) {

            $array = ['request' => $request, 'coupon' => $coupon, 'order_id' => $order_id];
            $subject = 'Thankyou for your order';
            $content = View::make('emails.order-mail', $array);
            $body = $content->render();
            $to = $request->email;
            $name = $request->first_name.' '. $request->last_name;
            $this->sendMail( $subject, $body, $to, $name );

            $subject = 'A new order placed';
            $to =  'surprisegeniegifts@gmail.com'; //Meta::where('meta_name', 'order_email')->value('meta_value');
            $name = 'surpriseGenie';

            $content = View::make('emails.admin-order-mail', $array);
            $body = $content->render();
            $this->sendMail( $subject, $body, $to, $name );


            if( !Auth::check() && $request->createaccount ) {
                $this->create_user( $request );
            }

            $parameters = [
                              'tid' => date('dmy').time(),
                              'merchant_id' => $this->merchant_id,
                              'order_id' => $order_id,
                              'amount' => $total_amount,
                              'currency' => $this->currency,
                              'redirect_url' => $this->redirect_url,
                              'cancel_url' => $this->cancel_url,
                              'language' => $this->language,
                              'billing_name' => $request->first_name . ' ' . $request->last_name,
                              'billing_address' => implode(', ', $request->address),
                              'billing_city' => $request->city,
                              'billing_state' => State::where('id', $request->state)->value('name'),
                              'billing_zip' => $request->pincode,
                              'billing_country' => Country::where('id', $request->country)->value('name'),
                              'billing_tel' => $request->mobile,
                              'billing_email' => $request->email,
                            ];

            return redirect()->route('payment')->with(['parameters' => $parameters, 'order_success' => 'Order placed successfully!'])->withCookie(Cookie::forget('customerCartProductList'));

        }
        else if( $request->payment_method === 'cod' && $total_amount ) {

            $payment_id = Payment::orderby('id', 'DESC')->limit(1)->value('payment_id');
            $token = strtolower(randomString(32));

            $paymentData = array(
                                  'payment_id' => $payment_id++,
                                  'token' => $token,
                                  'order_id' => $order_id,
                                  'payment_mode' => $request->payment_method,
                                  'order_status' => 'Pending'
                            );
            Payment::create( $paymentData );


            $array = ['request' => $request, 'coupon' => $coupon, 'order_id' => $order_id];
            $subject = 'Thankyou for your order';
            $content = View::make('emails.order-mail', $array);
            $body = $content->render();
            $to = $request->email;
            $name = $request->first_name.' '. $request->last_name;
            $this->sendMail( $subject, $body, $to, $name );

            $subject = 'A new order placed';
            $to =  'surprisegeniegifts@gmail.com'; //Meta::where('meta_name', 'order_email')->value('meta_value');
            $name = 'surpriseGenie';

            $content = View::make('emails.admin-order-mail', $array);
            $body = $content->render();
            //$this->sendMail( $subject, $body, $to, $name );

            return redirect()->route('order.success', $order_id)->with(['order_success' => 'Order has been placed successfully!'])->withCookie(Cookie::forget('customerCartProductList'));

        }

        return redirect()->back()->with(['order_err' => 'Order could not place!'])->withInput();
    }


    public function ccavenue( $request, $order_id, $amount ) {

        

        foreach ($parameters as $key => $value){
          
          $this->merchant_data.=$key.'='.$value.'&';
        }

        $encrypted_data = $this->encrypt($this->merchant_data, $this->working_key);

        $array = array(
                        'endPoint' => $this->endPoint,
                        'access_code' => $this->access_code,
                        'encrypted_data' => $encrypted_data
                    );

        return view('gift/cc/ccform', $array);
    }

    public function create_user( $request ) {
        $from = Meta::where('meta_name', 'noreply')->value('meta_value');
        $app_name = Meta::where('meta_name', 'app_name')->value('meta_value');
        $password = randomString(10);

        $to = $request->email;

        if( User::where('email', $request->email)->first() ) {
            $array = ['request' => $request];
            $subject = 'Already customer';
            $content = View::make('emails.login-exist-mail', $array);
            $body = $content->render();
            $to = $request->email;
            $name = $request->first_name.' '. $request->last_name;
            $this->sendMail( $subject, $body, $to, $name );
            return true;
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make( $password );
        $user->save();
    }

    public function sendMail( $subject, $body, $to, $name ) {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'surprisegeniegifts@gmail.com';                 // SMTP username
            $mail->Password = '*9634625229*';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('surprisegeniegifts@gmail.com', 'SurpriseGenie');
            $mail->addAddress($to, $name);     // Add a recipient
            

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
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

        if( !$request->session()->has('order_success') )
            return redirect( url('/') );

        return view('gift.order.success', ['order_id' => $id]);
    }


    public function show( $order_id ) {
        return view(  _admin('order.view'), ['title' => 'View Order', 'order_id' => $order_id]);
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



    public function view_product( $category, $slug, $id )
    {

        $product = Product::where('product_id', $id)->with(['productMeta', 'media', 'product_category'])->first();

        $title = $product ? $product->title : 'Oops! content not found';
        return view( _template('test.view-product'), ['title' => $title, 'product' => $product] );

    }


    public function store_test(Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        if( !$request->id || !$request->product_id )
            return json_encode(['response' => false]);

        $product = Product::with('product_meta')->where(['id' => $request->id, 'product_id' => $request->product_id])->first();

        if( !$product )
            return json_encode(['response' => false]);

        $color = '';
        if( isset($product->product_meta[0]->color) && $product->product_meta[0]->color ) {
          $colors = explode(',', $product->product_meta[0]->color);
          $color = isset($colors[0]) ? $colors[0] : '';
        }
        $size = '';
        if( isset($product->product_meta[0]->size) && $product->product_meta[0]->size ) {
          $sizes = explode(',', $product->product_meta[0]->size);
          $size = isset($sizes[0]) ? $sizes[0] : '';
        }
        $varid = 0;
        $cat_slug = Category::find($product->category_id)->slug;
        $url = url('/' . $cat_slug . '/' . $product->slug . '/' . $request->product_id . '?source=cart');

        $quantity = $request->quantity ? $request->quantity : 1;


        

        /*$cookie = Cookie::forget('customerCartProductListTest');
        return response()->json('foot')->withCookie($cookie);*/

        //return response()->json($data[, 200][, $headers]);

        $data = array();
        $found = false;
        $color_found = false;
        
        if( $cookie = $request->cookie('customerCartProductListTest') ) {
          $cookieObj = json_decode( $cookie );
          foreach( $cookieObj as $coo ) {

            $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'discount' => isset($coo->discount) ? $coo->discount : 0,
                                'price' => $coo->price,
                                'quantity' => $coo->quantity,
                                'variations' => json_encode($variationArray)
                            );
            
            //if( $coo->product_id === $request->product_id ) {

                /*$variationArray = [];

                if( $coo->variations ) {
                  $variation = json_decode( $coo->variations );
                  if( $variation && count( $variation ) > 0 ) {
                    foreach( $variation as $c ) {
                      if( $c->color === $request->color && $c->size === $request->size  ) {
                        $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity + $request->quantity];
                        $color_found = true;
                      }
                      else {
                        //$variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                        $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                      }
                    }
                  }
                }
                if( !$color_found ) {
                  $variationArray[] = ['id' => ++$varid, 'color' => $request->color, 'size' => $request->size, 'quantity' => $request->quantity];
                }

                $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'discount' => isset($coo->discount) ? $coo->discount : 0,
                                'price' => $coo->price,
                                'quantity' => $coo->quantity + 1,
                                'variations' => json_encode($variationArray),
                            );
                $found = true;*/
            //}
            //else {
                /*$variationArray = [];

                if( $coo->variations ) {
                  $variation = json_decode( $coo->variations );
                  if( $variation && count( $variation ) > 0 ) {
                    foreach( $variation as $c ) {
                      if( $c->color === $request->color && $c->size === $request->size  ) {
                        $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity + $request->quantity];
                        $color_found = true;
                      }
                      else {
                        //$variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                        $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                      }
                    }
                  }
                }

                $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'discount' => isset($coo->discount) ? $coo->discount : 0,
                                'price' => $coo->price,
                                'quantity' => $coo->quantity,
                                'variations' => json_encode($variationArray)
                            );*/
            //}
          }
        }
        else {
          $cartProduct = array(
                                'id' => $request->id,
                                'product_id' => $request->product_id,
                                'title' => $product->title,
                                'url' => $url,
                                'feature_image' => asset('public/'.product_file(thumb($product->feature_image, 130, 140))),
                                'price' => $product->price,
                                'discount' => $product->discount,
                                'quantity' => $request->quantity,
                                'color' => $request->color,
                                'size' => $request->size,
                            );
            array_push($data, $cartProduct);
        }

        /*$variations = $color || $size ? [ 0 => ['id' => ++$varid, 'color' => $request->color ? $request->color : $color, 'size' => $request->size ? $request->size : $size, 'quantity' => $quantity] ] : null;

        if( !$found ) {
            $cartProduct = array(
                                'id' => $request->id,
                                'product_id' => $request->product_id,
                                'title' => $product->title,
                                'url' => $url,
                                'feature_image' => asset('public/'.product_file(thumb($product->feature_image, 130, 140))),
                                'price' => $product->price,
                                'discount' => $product->discount,
                                'quantity' => $quantity,
                                'variations' => $variations ? json_encode($variations) : null
                            );
            array_push($data, $cartProduct);
        }*/

        var_dump($data);
        
        /*$json = json_encode( $data );
        $response = new Response('Added to Cart');
        $response->withCookie( cookie()->forever('customerCartProductListTest', $json) );
        return $response;*/

    }


    public function view_cart() {
      return view('gift/test/view-cart', ['title' => 'Cart items']);
    }


     public function getCartItems( Request $request ) {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        if( $cookie = $request->cookie('customerCartProductListTest') ) {
            $cookieObj = json_decode( $cookie );
            return response()->json($cookieObj);
        }
    }


    public function remove_cart( Request $request, $id)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }
       
        if( !$request->id || !$request->product_id )
            return json_encode(['response' => false]);

        $product = Product::where(['id' => $request->id, 'product_id' => $request->product_id])->first();

        if( !$product )
            return response()->json(['response' => false, 'response_msg' => 'Product not found!']);

        $data = array();
        $varid = 0;
        if( $cookie = $request->cookie('customerCartProductListTest') ) {
            $cookieObj = json_decode( $cookie );
            $countVar = 0;
            $variationArray = [];
            foreach( $cookieObj as $coo ) {

                if( $coo->product_id == $request->product_id ) {
                  if( isset( $coo->variations ) && $coo->variations ) {
                    $variation = json_decode( $coo->variations );
                    $countVar = count( $variation );
                    if( $variation && count( $variation ) ) {
                      foreach( $variation as $key => $c ) {
                        if( $request->key == $c->id ) {
                        }
                        else {
                          $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                        }
                      }
                    }
                  }

                  if( $countVar > 1 ) {
                    $data[] = array(
                                  'id' => $coo->id,
                                  'product_id' => $coo->product_id,
                                  'title' => $coo->title,
                                  'url' => $coo->url,
                                  'feature_image' => $coo->feature_image,
                                  'discount' => isset($coo->discount) ? $coo->discount : 0,
                                  'price' => $coo->price,
                                  'quantity' => $coo->quantity,
                                  'variations' => $variationArray ? json_encode($variationArray) : null,
                              );
                  }

                }
                else {
                    $variationArray = [];
                    if( isset( $coo->variations ) && $coo->variations ) {
                      $variation = json_decode( $coo->variations );
                      if( $variation && count( $variation ) ) {
                        foreach( $variation as $key => $c ) {
                          if( $request->key == $c->id ) {
                          }
                          else {
                            $variationArray[] = ['id' => ++$varid, 'color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                          }
                        }
                      }
                    }
                  
                    $data[] = array(
                                    'id' => $coo->id,
                                    'product_id' => $coo->product_id,
                                    'title' => $coo->title,
                                    'url' => $coo->url,
                                    'feature_image' => $coo->feature_image,
                                    'price' => $coo->price,
                                    'quantity' => $coo->quantity,
                                    'discount' => isset($coo->discount) ? $coo->discount : 0,
                                    'variations' => $variationArray ? json_encode($variationArray) : null,
                                );
                }
            }
        }        

        $response = new Response('Cart item deleted!');

        $json = json_encode( $data );
        $response->withCookie( cookie()->forever('customerCartProductListTest', $json) );
        return $response;
    }


    public function update_cart(Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        $validator = Validator::make( $request->all(),[
                                'id' => 'required|array',
                                'id.*' => 'required|numeric|min:1',
                                'product_id' => 'required|array',
                                'product_id.*' => 'required|numeric|min:1',
                                'quantity' => 'required|array|min:1',
                                'quantity.*' => 'required|numeric|min:1',
                        ]);
        if( $validator->fails() ) {
            return json_encode(['response' => false, 'response_msg' => 'Something went wrong, cart could not update!']);
        }

        
        /*$data = array();
        $color_found = false;
        if( $cookie = $request->cookie('customerCartProductListTest') ) {
          $cookieObj = json_decode( $cookie );
          foreach( $cookieObj as $coo ) {
            
            if( $coo->product_id === $request->product_id ) {
                $variationArray = [];

                if( $coo->variations ) {
                  $variation = json_decode( $coo->variations );
                  if( $variation && count( $variation ) > 0 ) {
                    foreach( $variation as $c ) {
                      if( $c->color === $request->color && $c->size === $request->size  ) {
                        $variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity + $request->quantity];
                        $color_found = true;
                      }
                      else {
                        //$variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                        $variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                      }
                    }
                  }
                }
                if( !$color_found && $variations ) {
                  $variationArray[] = ['color' => $request->color, 'size' => $request->size, 'quantity' => $request->quantity];
                }

                $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'discount' => isset($coo->discount) ? $coo->discount : 0,
                                'price' => $coo->price,
                                'quantity' => $coo->quantity + 1,
                                'variations' => json_encode($variationArray),
                            );
                $found = true;
            }
            else {
                $variationArray = [];

                if( $coo->variations ) {
                  $variation = json_decode( $coo->variations );
                  if( $variation && count( $variation ) > 0 ) {
                    foreach( $variation as $c ) {
                      if( $c->color === $request->color && $c->size === $request->size  ) {
                        $variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity + $request->quantity];
                        $color_found = true;
                      }
                      else {
                        //$variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                        $variationArray[] = ['color' => $c->color, 'size' => $c->size, 'quantity' => $c->quantity];
                      }
                    }
                  }
                }

                $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'discount' => isset($coo->discount) ? $coo->discount : 0,
                                'price' => $coo->price,
                                'quantity' => $coo->quantity,
                                'variations' => json_encode($variationArray)
                            );
            }
          }
        }*/
        

        $data = [];
        $variationArray = [];
        $varid = 0;


        if( $cookie = $request->cookie('customerCartProductListTest') ) {
            $cookieObj = json_decode( $cookie );
            foreach( $cookieObj as $key => $coo ) {

              if( array_search( $coo->product_id, $request->product_id ) !== false ) {
                $variationArray = $this->createVariation( $request, $coo );

                $ik = array_search($coo->id, $request->id);
                $data[] = array(
                                'id' => $coo->id,
                                'product_id' => $coo->product_id,
                                'title' => $coo->title,
                                'url' => $coo->url,
                                'feature_image' => $coo->feature_image,
                                'price' => $coo->price,
                                'discount' => $coo->discount,
                                'quantity' => isset($request->quantity[$ik]) ? $request->quantity[$ik] : $coo->quantity,
                                'variations' => count($variationArray) > 0 ? json_encode($variationArray) : '',
                        );
              }

                
            }
        }

        $response = new Response('Cart Updated');
        $json = json_encode( $data );
        $response->withCookie( cookie()->forever('customerCartProductListTest', $json) );
        return $response;

    }


    public function createVariation( $request, $coo ) {

      $variations = [];
        if( isset($coo->variations) && $coo->variations && $request->itemKey && count( $request->itemKey ) > 0 ) 
        {

          //var_dump($request->itemKey);
          $variation = json_decode( $coo->variations );
          foreach ($variation as $key => $var) {

            $ik = array_search($var->id, $request->itemKey);
            $q = isset($request->quantity[$ik]) ? $request->quantity[$ik] : 0;
            $variations[] = ['id' => $var->id, 'color' => isset($var->color) ? $var->color : null, 'size' => isset($var->size) ? $var->size : null, 'quantity' => $q];

            //echo $var->id.' '. $request->quantity[$ik].' ';

            /*if( in_array($var->id,  $request->itemKey) ) {
              
            }*/

            
            
          }
        }
        return $variations;
              
       
        /*$data[] = array(
                        'id' => $coo->id,
                        'product_id' => $coo->product_id,
                        'title' => $coo->title,
                        'url' => $coo->url,
                        'feature_image' => $coo->feature_image,
                        'price' => $coo->price,
                        'discount' => $coo->discount,
                        'quantity' => $request->quantity[$key] ? $request->quantity[$key] : $coo->quantity,
                        'variations' => count($variationArray) > 0 ? json_encode($variationArray) : '',
                );*/
          
    }

}