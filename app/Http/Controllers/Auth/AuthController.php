<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\User;
use Validator;
use Auth;
use Hash;


class AuthController extends Controller
{



	public function login() {

        if( Auth::check() )
            return redirect( url('/') );

        return view('auth.login', ['title' => 'Login']);
    }

    public function register() {

        if( Auth::check() )
            return redirect( url('/') );

        return view('auth.register', ['title' => 'Register']);
    }

    public function check_auth_user_status( Request $request ){
        if( !$request->ajax() ) {
            return response()->json(['status'=>'err','message' => 'Enter valid url!']);
        }
      
        if(User::where('email',$request->email)->first()){
            return response()->json(['status' => 'success', 'message' => 'Login Please!']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Not Registered!']);
        }
            


        //return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
    }

	public function doLogin( Request $request ) {
		$this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ],
        [
        	'username.required' => 'Username is required *',
        	'password.required' => 'Password is required *',
        ]);

        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	    $request->merge([$field => $request->input('username')]);

        $user = User::where($field, $request->username)->first();
        if( !$user )
            return redirect('/login')->with('message', 'Invalid username or password!');

        if( $user->role === 'member' && $user->status !== 'active' )
            return redirect('/login')->withErrors(['message' => 'Your account is not active, please contact to admin!']);

        if( $user->role === 'seller' && $user->status !== 'active' )
            return redirect('/login')->withErrors(['message' => 'Your account is not active, please contact to admin!']);

        if( !in_array($user->role, ['customer', 'member', 'seller'] ) )
            return redirect('/login')->with('message', 'Invalid username or password!');

        if (Auth::attempt($request->only($field, 'password')))
        {
            $back = $request->back ?? '/';
            if( $user->role === 'member' )
                return redirect()->route('user.home');
            if( $user->role === 'seller' )
                return redirect()->route('seller.home');

            if( $user->role == 'customer' ){
                return redirect($back);
                // echo $back;
                // dd($user->role);
            }
            
            return redirect('/');
        }

        return redirect('/login')->withErrors([
                'message' => 'Invalid username or password!',
        ]);

        /*if( User::where([$field => $request->username, 'status' => 'inactive'])->value('email') )
            return redirect('/login')->with('message', 'Your account is not active, please contact to admin');

        

	    if (Auth::attempt($request->only($field, 'password')))
	    {
	        return redirect('/');
	    }

	    return redirect('/login')->withErrors([
		        'message' => 'Invalid username or password!',
		]);*/
	
	}



	public function doRegister( Request $request ) {

		$this->validate($request, [
	            'first_name' => 'required|max:255',
	            'last_name' => 'required|max:255',
	            'email' => 'required|max:255|email|unique:users',
                'mobile' => 'required|digits:10|numeric',
	            'password' => 'required|min:8|max:255|confirmed'
        ],
        [
	        	'first_name.required' => 'First name is required *',
	        	'first_name.max' => 'First name can have upto 255 characters!',
	        	'last_name.required' => 'Last name is required *',
	        	'last_name.max' => 'First name can have upto 255 characters!',
	        	'email.required' => 'Email is required *',
	        	'email.max' => 'Email can have upto 255 characters!',
	        	'email.email' => 'Email must be valid!',
	        	'email.unique' => 'Email already exist!',
                'mobile.required' => 'Mobile no is required!',
                'mobile.min' => 'Enter valid mobile no!',
                'mobile.max' => 'Enter valid mobile no!',
                'mobile.numeric' => 'Enter valid mobile no!',
	        	'password.required' => 'Password is required *',
	        	'password.max' => 'Password can have upto 255 characters!',
	        	'password.min' => 'Password must have atleast 8 characters!',
	        	'password.confirmed' => 'Password & confirmed password does not match!',
        ]);

		$user = new User();
		$user->role = 'customer';
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->uid = uniqueID(8);
        $user->password = Hash::make( $request->password );
        $user->username = generate_username($request);
        $user->save();
        

        Auth::login($user);

        return redirect(url('checkout?s=checkout'));
	}


	public function password_request() {

		if( Auth::check() )
            return redirect( url('/') );


        return view('auth.passwords.email', ['title' => 'Forgot Password']);

	}


	public function request_mail( Request $request ) {

		if( Auth::check() )
            return redirect( url('/') );

        if( $request->ajax() )
        	return redirect( url('/') );

        $validator = Validator::make( $request->all(), [
                            'email' => 'required',
                    ],
                    [
                            'email.required' => 'Email address is required *',
                    ]);

        if( $validator->fails() )
            return redirect()->back()->withErrors($validator)->withInput();

        $user = User::where('email', $request->email)->first();

        if( !$user )
            return redirect()->back()->with('status', 'we have not found any account with this mail id!');

        $token = strtolower(random_str( 64 ));
        User::where('id', $user->id)->update(['token' => $token]);


        $body = view('emails.password-reset', ['user' => $user, 'token' => $token])->render();
        

        $mail = new PHPMailer(true);
        try {
            $mail->setFrom('noreply@techdost.org', config("app.name"));
            $mail->addAddress($request->email);
            $mail->isHTML(true);
            $mail->Subject = 'RESET PASSWORD - '.config("app.name");
            $mail->Body    = $body;

            $mail->send();
            return redirect()->back()->with('status', 'We have sent you a mail to reset your password, please check your email!');
        } catch (Exception $e) {
            return redirect()->back()->with('status', 'We have sent you a mail to reset your password, please check your email!');
        }

    }

    public function reset_password( $token ) {

    	if( Auth::check() )
            return redirect( url('/') );

        return view('auth.passwords.reset', ['title' => 'Reset Password', 'token' => $token]);
    }


    public function update_password( Request $request ) {

    	if( Auth::check() )
            return redirect( url('/') );

        if( $request->ajax() )
        	return response()->json('', 404);

        $validator = Validator::make( $request->all(), [
                                    'token' => 'required',
                                    'email' => 'required|email',
                                    'password' => 'required|min:8|max:255|confirmed',
                                    'password_confirmation' => 'required',
                            ],
                            [
                                    'email.required' => 'Email is required *',
                                    'email.email' => 'Email is required *',
                                    'password.required' => 'Password is required *',
                                    'password.min' => 'Password must have atleast 8 characters!',
                                    'password.max' => 'Password can have upto 255 characters!',
                                    'password.confirmed' => 'Password & confirm password must match!',
                                    'password_confirmation.required' => 'Confirm password is required *'
                            ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where(['email' => $request->email])->first();

        if( !$user ) {
            return redirect()->back()->with('status', 'Password could not reset!')->withInput();
        }
        if( $user->token !== $request->token )
            return redirect()->back()->with('status', 'Password could not reset!')->withInput();

        User::where('id', $user->id)->update(['password' => Hash::make($request->password), 'token' => null]);
        return redirect()->route('password.reset.success')->with('pass_status', 'Password successfully updated!');
    }


    public function password_reset_success() {
        if( !session()->has('pass_status') )
            return redirect()->route('login');

        return view('auth.passwords.success', ['title' => 'Password successfully updated!']);
    }


	public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }

}