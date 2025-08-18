<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\model\Payment;
use App\model\Order;
use App\model\OrderProduct;
use App\model\OrderCustomer;
use App\model\OrderRelation;
use App\model\Coupon;
use App\model\Meta;
use App\model\Wallet;
use App\model\Membership;
use App\User;
use Mail;
use View;
use Auth;
use Hash;

class CCAvenueController extends Controller
{

  protected $endPoint = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
  protected $working_key = 'FC8404E4DEA84E14091EA7D07F52D619';//Shared by CCAVENUES
  protected $access_code = 'AVIN84GC02BD17NIDB';//Shared by CCAVENUES
  protected $merchant_data = '';
  protected $merchant_id = 211703;
  protected $initialAmount = 7000;
  protected $membershipAmount = 3000;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( Request $request )
    {

        if( $request->session()->has('parameters') ) {

            $parameters = $request->session()->get('parameters');
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
        else
          return redirect()->route('payment.error')->with('pay_error', 'Something went wrong, payment could not be made!');
    }


    public function ccresponse( Request $request ) {
      var_dump($_POST);
    }

    public function response( Request $request, $token, $payment_id, $order_no ) {

      $payment = Payment::where(['payment_id' => $payment_id, 'token' => $token])->first();

      if( $payment && isset($payment->status) && $payment->status === 'success' ) {
        return redirect( url('/') );
      }

      if( !$payment ) {
        $order = Order::where('order_id', $order_no)->first();
        if( $order ) {
          Order::where('id', $order->id)->delete();
          OrderProduct::where('order_id', $order->id)->delete();
          OrderRelation::where('order_id', $order->id)->delete();
          OrderCustomer::where('order_id', $order->id)->delete();
        }
      }

      $title = 'Payment Failed';

      if( $payment && $payment->order_status === 'Success' ) {
        $order = Order::with(['order_products', 'order_customer'])->where('order_id', $order_no)->first();
        $order->payment_status = 'paid';
        $order->save();
        if( !Auth::check() ) {
          if( $order && $order->membership ) {
            $role = 'member';
            $customer = OrderCustomer::where('order_id', $order->id)->first();
            $this->create_user( $customer, $role );
          }
        }
        else {
          User::where('id', Auth::id())->update(['role' => 'member']);
        }

        $title = 'Order successfully placed';
        Payment::where('payment_id', $payment_id)->update(['status' => 'success']);

        $coupon = $order && $order->coupon ? Coupon::where(['code' => $order->coupon, 'status' => 'active'])
                                ->orderby('id', 'DESC')->limit(1)->first() : false;

        $array = ['payment' => $payment, 'coupon' => $coupon, 'order' => $order];

        if( isset($order->order_customer[0]->email) ) {
          $subject = 'Thankyou for shopping with '.config('app.name');
          $name = $order->order_customer[0]->first_name . ' ' . $order->order_customer[0]->last_name;
          $to = $order->order_customer[0]->email;
          $body = View::make('emails.cc-order-mail', $array)->render();
          $this->sendMail( $subject, $body, $to, $name );
        }

        $subject = 'A New Order ID: ' . $payment->order_id;
        $name = config('app.name');
        $to =  Meta::where('meta_name', 'order_email')->value('meta_value');
        $body = View::make('emails.cc-admin-mail', $array)->render();
        $this->sendMail( $subject, $body, $to, $name );
      }
      if( $request->session()->has('membership') ) {
        $this->create_user( $order->order_customer[0] );
        $request->session()->flush('membership');
      }

      return view( 'gift.payment.view', ['payment' => $payment, 'title' => $title] );
    }

    public function create_user( $request, $role = 'customer' ) {

      $username = generate_username();
      $password = randomString(10);
      $user = User::where('email', $request->email)->first();
      if( $user ) {
          $a = ['role' => 'member', 'username' => $username];
          $user->fill($a)->save();

          $u = !Auth::check() ? Auth::login($user) : '';
      }
      else {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->uid = uniqueID(8);
        $user->password = Hash::make( $password );
        $user->username = $username;
        $user->role = 'member';
        $user->save();
        $u = !Auth::check() ? Auth::login($user) : '';
      }

      if( $wallet = Wallet::where('user_id', $user->id)->first() ) {

        Wallet::where('user_id', $user->id)->update(['joining_cashback' => $this->initialAmount, 'membership_amount' => $this->initialAmount]);
      }
      else {
        Wallet::create(['user_id' => $user->id, 'joining_cashback' => $this->initialAmount, 'membership_amount' => $this->initialAmount]);
      }
      Membership::create(['user_id' => $user->id, 'amount' => $this->membershipAmount]);

      $array = ['request' => $request, 'username' => $username];
      $subject = 'Thankyou for joining our membership';
      $content = View::make('emails.membership-mail', $array);
      $body = $content->render();
      $to = $request->email;
      $name = $request->first_name.' '. $request->last_name;
      $this->sendMail( $subject, $body, $to, $name );
      
      $subject = 'A customer joined membership';
      $content = View::make('emails.admin-membership', $array);
      $body = $content->render();
      $name = config('app.name');
      $to = Meta::where('meta_name', 'order_email')->value('meta_value');
      $this->sendMail( $subject, $body, $to, $name );
      return true;
    }


    public function sendMail( $subject, $body, $to, $name ) {

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
            $noreply = Meta::where('meta_name', 'noreply')->value('meta_value');
            $noreply = $noreply ? $noreply : 'noreply@boomingmart.com';

            $mail->setFrom($noreply, 'BoomingMart');
            $mail->addAddress($to, $name);     // Add a recipient
            

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }


    public function send_mail( $message, $subject, $array, $from, $to, $name, $app_name ) {
        Mail::send($message, $array, function($message) use ($from, $to, $name, $subject, $app_name)
        {
            $message->from( $from, $app_name );
            $message->to($to, $name);
            $message->subject($subject. ' - '.$app_name);
        });
    }


    public function error() {

      return view('gift.payment.error');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        // For default Gateway
        //$response = Indipay::response($request);
        
        // For Otherthan Default Gateway
        //$response = Indipay::gateway('CCAvenue')->response($request);

        var_dump($request);

        //dd($response);
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

}