<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\User;
use Cookie;
use Hash;
use View;
use Mail;
use Auth;
use Validator;
use Session;

class UserController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check())
            return redirect()->route('login');

        return view('auth.passwords.change');
    }


    public function update(Request $request)
    {

        if (!Auth::check())
            return redirect()->route('login');

        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:8|max:255|confirmed:password_confirmation',
                'password_confirmation' => 'required',
            ],
            [
                'old_password.required' => 'Old password is required *',
                'password.required' => 'Password is required *',
                'password.min' => 'Password must have atleast 8 characters!',
                'password.max' => 'Password can have upto 255 characters!',
                'password.confirmed' => 'Password & confirm password must match!',
                'password_confirmation.required' => 'Confirm password is required *'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $array = ['password' => Hash::make($request->password), 'updated_at' => date('Y-m-d H:i:s')];

        if (User::where('id', Auth::id())->update($array))
            return redirect()->back()->with('pass_msg', 'Password updated successfully!');

        return redirect()->back()->with('pass_err', 'Password could not update!');
    }
}
