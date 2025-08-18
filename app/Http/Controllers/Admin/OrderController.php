<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\Mailer;
use App\model\Order;
use App\User;
use App\model\LogsModel;
use Auth;
use View;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        // $this->middleware('admin');
    }

    public function index()
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $orders = Order::with(['invoice', 'payment'])->orderby('id', 'DESC')->get();
        // $orders = Order::with('invoice')->orderby('id', 'DESC')->get();
        return view('gift.admin.order.index')->with(['orders' => $orders, 'title' => 'Orders']);
    }

    public function orders($name)
    {

        // if( !User::isAdmin() )
        //     return redirect( url('/') );

        $orders = Order::with(['invoice', 'payment'])->orderby('id', 'DESC')->get();

        // $orders = Order::with('invoice')->where('order_status', $name)->orderby('id', 'DESC')->get();

        return view('gift.admin.order.index')->with(['orders' => $orders, 'title' => ucfirst($name) . ' Orders']);
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

    public function update_status(Request $request)
    {

        if (!$request->ajax())
            return;

        if (!User::isAdmin())
            return;

        if (!$request->id || !$request->status)
            return;


        Order::where('id', $request->id)->update(['order_status' => $request->status, 'order_remark' => $request->remark]);
        $order = Order::with('order_customer')->where('id', $request->id)->first();

        if ($request->status == 'cancelled') {
            // dd('cancel');
            $subject = 'Order is ' . $request->status ?? '';
            $to = $order->order_customer[0]->email ?? '';
            $body = View::make('emails.order-cancel-by-admin', ['order' => $order])->render();

            // $this->sendMailToUser($subject, $body, $to, $order->order_customer[0]->first_name);
            $array = [
                            'to' => $to,
                            'name' => $order->order_customer[0]->first_name.' '. $order->order_customer[0]->last_name,
                            'subject' => $subject,
                            'message' => $body
                    ];

            $mail = new Mailer();
            $mail->sendMail($array);
        }

        if ($request->status == 'delivered' or $request->status == 'shipped') {

            $subject = 'Order is ' . $request->status ?? '';
            $to = $order->order_customer[0]->email ?? '';
            $status = $request->status ?? '';
            $body = View::make('emails.order-status-by-admin', ['order' => $order, 'status' => $status])->render();

            // $this->sendMailToUser($subject, $body, $to, $order->order_customer[0]->first_name);

             $array = [
                            'to' => $to,
                            'name' => $order->order_customer[0]->first_name.' '. $order->order_customer[0]->last_name,
                            'subject' => $subject,
                            'message' => $body
                    ];

            $mail = new Mailer();
            $mail->sendMail($array);
        }

        LogsModel::create(['user_id' => Auth::id(), 'remark' => 'Order update', 'status' => 'order', 'working_id' => $request->id]);

        return response()->json(['message' => 'success']);
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

        $order = Order::with(['order_products', 'order_customer', 'payment'])->find($id);

        return view('gift.admin.order.view')->with(['title' => 'View Order', 'order' => $order]);
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

    // public function emailtestinghere(){
    //      $body = view('emails.test', ['order' => '','request'=> '','cart' => ''])->render();
    //         $array = [
    //                         // 'to' => $meta->where('meta_name', 'order_email')->first()->meta_value,
    //                         'to' => 'mohit@techdost.com',
    //                         'name' => config('app.name'),
    //                         'subject' => 'Jtin this enjoy your trip',
    //                         'message' => $body
    //                 ];

    //         $mail = new Mailer();
    //         if($mail->sendMail($array)){
    //             echo "string";
    //         }else{
    //             echo"not";
    //         }
    // }

    public function delete(Request $request, $id)
    {

        Order::where('id', $id)->delete();
        LogsModel::create(['user_id' => Auth::id(), 'remark' => 'OurClient delete', 'status' => 'OurClient', 'working_id' => $id]);
        $array = array('msg', 'OurClient delete successfully');
        echo json_encode($array);
        die();
    }


    protected function sendMailToAdmin($subject, $body, $to, $name)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp-relay.brevo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '75eef6001@smtp-brevo.com';                 // SMTP username
            $mail->Password = 'z56tcn1YxAfGBDpR';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', 'Koxtons Mart');
            $mail->addAddress('admin@koxtonsmart.com', $name);     // Add a recipient


            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    protected function sendMailToUser($subject, $body, $to, $name)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp-relay.brevo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '75eef6001@smtp-brevo.com';                 // SMTP username
            $mail->Password = 'z56tcn1YxAfGBDpR';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', 'Koxtons Mart');
            // $mail->addAddress('amitkumar@1solutions.biz', $name);     // Add a recipient
            $mail->addAddress($to, $name);     // Add a recipient

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // dd($mail);
            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo $mail->ErrorInfo;
            return false;
        }
    }
}
