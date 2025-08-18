<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        /*if( Auth::guard('web')->check() ) {
            return redirect( url('/') );
        }*/

        if( Auth::guard('admin')->check() ) {
            return redirect()->route('admin.home');
        }

        return view('gift.admin.index');
    }

    public function login(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if( Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->remember) ) {
            return redirect()->intended(route('admin.home'));
        }

        $request->session()->flash('admin_log_err', 'Invalid username or password');
        return redirect()->route('admin')->withInput($request->only('email', 'remember'));

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('admin');
    }
}
