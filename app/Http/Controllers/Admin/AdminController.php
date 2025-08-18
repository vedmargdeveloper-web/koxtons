<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\User;
use App\model\Review;
use App\model\Order;
use App\model\Product;
use App\model\Pincode;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Hash;
use Auth;
use Session;
use Validator;
use App\model\LogsModel;

class AdminController extends Controller
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

    public function user_create()
    {
        if (!User::isAdmin())
            return redirect(url('/'));

        return view(_admin('user.create'), ['title' => 'Add User']);
    }

    public function user_store(Request $request)
    {

        if (!User::isAdmin())
            return redirect(url('/'));

        $this->validate(
            $request,
            [
                'first_name' => 'required|max:255',
                'email' => 'required|max:255|email|unique:users',
                'password' => 'required|min:8|max:255'
            ],
            [
                'first_name.required' => 'First name is required *',
                'first_name.max' => 'First name can have upto 255 characters!',
                'email.required' => 'Email is required *',
                'email.max' => 'Email can have upto 255 characters!',
                'email.email' => 'Email must be valid!',
                'email.unique' => 'Email already exist!',
                'password.required' => 'Password is required *',
                'password.max' => 'Password can have upto 255 characters!',
                'password.min' => 'Password must have atleast 8 characters!',
                'password.confirmed' => 'Password & confirmed password does not match!',
            ]
        );


        $user = new User();
        $user->role = $request->role;
        $user->parent_id = Auth::id();
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->status = null;
        $user->uid = uniqueID(16);
        $user->password = Hash::make($request->password);
        // $user->password = Hash::make( $request->password );
        $user->username = generate_username($request);
        $user->permission = json_encode($request->permission);
        $user->save();

        LogsModel::create(['user_id' => Auth::id(), 'remark' => 'Add New User', 'status' => 'user', 'working_id' => $user->id]);


        return redirect()->back()->with('seller_msg', 'User add successfully!');
    }


    public function edit_user($id)
    {


        if (!User::isAdmin())
            return redirect(url('/'));

        $user = User::where('id', $id)->first();
        return view(_admin('user.edit'), ['title' => 'Edit User', 'user' => $user, 'id' => $id]);
    }


    public function update_user(Request $request, $id)
    {

        if (!User::isAdmin())
            return redirect(url('/'));

        $user = User::findOrFail($id);
        if (!$user)
            return redirect()->back()->withErrors('seller_err', 'User not found!')->withInput();

        $this->validate(
            $request,
            [
                'first_name' => 'required|max:255',
                'email' => 'required|max:255|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8|max:255'
            ],
            [
                'first_name.required' => 'First name is required *',
                'first_name.max' => 'First name can have upto 255 characters!',
                'email.required' => 'Email is required *',
                'email.max' => 'Email can have upto 255 characters!',
                'email.email' => 'Email must be valid!',
                'email.unique' => 'Email already exist!',
                'password.required' => 'Password is required *',
                'password.max' => 'Password can have upto 255 characters!',
                'password.min' => 'Password must have atleast 8 characters!',
                'password.confirmed' => 'Password & confirmed password does not match!',
            ]
        );

        $user->first_name = $request->first_name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->permission = json_encode($request->permission);

        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->save();
        LogsModel::create(['user_id' => Auth::id(), 'remark' => 'Update User', 'status' => 'user', 'working_id' => $id]);

        return redirect()->back()->with('seller_msg', 'User updated successfully!');
    }



    //Role management



    public function users()
    {
        if (!User::isAdmin())
            return redirect(url('/'));

        return view(_admin('user.index'), ['title' => 'User']);
    }

    public function view_user($id)
    {
        if (!User::isAdmin())
            return redirect(url('/'));

        $user = User::where('id', $id)->get();
        return view(_admin('user.view'), ['title' => 'View User', 'id' => $id]);
    }


    public function index(Request $request)
    {

        if (Auth::check() && Auth::user()->isAdmin())
            return redirect(route('admin.home'));
        if (Auth::check())
            return redirect(url('/'));

        return view(_admin('index'), ['title' => 'Login']);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            return redirect()->intended(route('admin.home'));
        }

        return redirect()->back()->with('admin_log_err', 'Invalid username or password!')->withInput(['except' => 'password']);
    }

    // public function login(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);


    //     if ($request->email === 'admin@koxtonsmart.com' && $request->has('password')) {
    //         // Update the password for the admin
    //         // dd('true');
    //         // if (User::where('email', 'admin@koxtonsmart.com')->update(['password' => bcrypt($request->password)])) {
    //         //     return redirect()->back()->with('pass_msg', 'Password updated successfully!');
    //         // }
    //         $user = User::where('email', 'admin@koxtonsmart.com')->first();
    //         if ($user) {
    //             // dd($user);
    //             $user->password = Hash::make($request->password);
    //             $user->save();
    //             dd('true');
    //             // return redirect()->back()->with('pass_msg', 'Password updated successfully!');
    //         }
    //     }
    // }


    /*public function login( AdminLoginRequest $request ) {

        if( isAdmin() )
            return redirect( route('admin.home') );

        $data = User::where( 'email', $request->username )->first();

        if( !$data )
            return redirect()->back()->with('admin_log_err', 'Invalid username or password!')->withInput(['except' => 'password']);

        if(  !Hash::check( $request->password, $data->password ) ) {
            return redirect()->back()->with('admin_log_err', 'Invalid username or password!')->withInput(['except' => 'password']);
        }

        $array = ['email' => $data->email, 'name' => $data->name];
        Session::put( ['sessdata' => $array, 'logged_in' => true] );
        return redirect( route('admin.home') );
    }*/



    public function home()
    {
        // dd('dd');

        return view(_admin('home'), ['title' => 'Home']);
    }


    public function update_password(Request $request)
    {

        $user = User::find(Auth::id());
        if (!$user)
            return redirect()->back()->with('pass_err', 'Password could not update!');

        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:8|max:255|confirmed:password_confirmation',
                'password_confirmation' => 'required',
                'old_password' => 'required'
            ],
            [
                'password.required' => 'Password is required *',
                'password_confirmation.required' => 'Confirm password is required *',
                'old_password.required' => 'Old password is required *',

                'password.max' => 'Password can have upto 255 characters!',
                'password.min' => 'Password must have atleast 8 characters!',
                'password.confirmed' => 'Password & confirm password must match!',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->old_password, $user->password))
            return redirect()->back()->with('pass_err', 'Old password does not match!');

        $array = ['password' => Hash::make($request->password)];

        if (User::where('id', Auth::id())->update($array))
            return redirect()->back()->with('pass_msg', 'Password updated successfully!');

        return redirect()->back()->with('pass_err', 'Password could not update!');
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





    public function paymentRequestMail($order_id)
    {
        if (!User::isAdmin())
            return redirect(url('login'));

        $order = Order::where('id', $order_id)->first();
        $product = $order ? Product::where('id', $order->product_id)->first() : false;

        if (!$order || !$product)
            return redirect()->back()->with('mail_success', 'Mail could not sent!');

        $body = view('emails.payment-request', ['order' => $order, 'product' => $product])->render();

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

            /*$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'surprisegeniegifts@gmail.com';                 // SMTP username
            $mail->Password = '*9634625229*';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; */                                   // TCP port to connect to

            //Recipients
            $mail->setFrom('noreply@surprisegenie.com', 'SurpriseGenie');
            $mail->addAddress($order->email, $order->first_name);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Pending Payment - SurpriseGenie';
            $mail->Body    = $body;

            $mail->send();
        } catch (Exception $e) {
        }

        return redirect()->back()->with('mail_success', 'Mail successfully sent!');
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

    public function logout()
    {

        Auth::logout();
        Session::flush();
        return redirect(route('admin'));
    }


    public function upload()
    {

        /*$inputFileName = base_path() . '/assets/Pincodes.csv';

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach( $sheetData as $key => $row ) {

            if( $key > 1 ) {

                Pincode::create([
                                    'pincode' => $row['A'],
                                    'state_code' => $row['B'],
                                    'city' => $row['C'],
                                    'prepaid' => $row['D'],
                                    'cod' => $row['E'],
                                    'reverse_pickup' => $row['F'],
                                    'repl' => $row['H']
                            ]);
            }
            else {
                echo 'Not';
            }

        }*/
    }
}
