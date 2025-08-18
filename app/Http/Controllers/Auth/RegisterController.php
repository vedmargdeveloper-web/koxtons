<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'email' => 'required|string|email|max:255|unique:users',
                            
                            'password' => 'required|string|min:8|max:255|confirmed',
                            'password_confirmation' => 'required',
                        ],
                        [
                            'first_name.required' => 'First name is required *',
                            'first_name.string' => 'First name must be valid!',
                            'first_name.max' => 'First name can have upto 255 characters!',

                            'last_name.required' => 'Last name is required *',
                            'last_name.string' => 'Last name must be valid!',
                            'last_name.max' => 'Last name can have upto 255 characters!',

                            'email.required' => 'Email address is required *',
                            'email.string' => 'Email address must be valid!',
                            'email.email' => 'Email address must be valid!',
                            'email.unique' => 'Email address already exist!',
                            'email.max' => 'Email address can have upto 255 characters!',

                           

                            'password.required' => 'Password is required *',
                            'password.string' => 'Password must be valid!',
                            'password.max' => 'Password can have upto 255 characters!',
                            'password.min' => 'Password must have atleast 8 characters!',
                            'password.confirmed' => 'Password & confirm password must match!',

                            'password_confirmation.required' => 'Confirm password is required *',

                        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $uid = uniqueID(8);
        return User::create([
                    'role' => 'customer',
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                  
                    'uid' => $uid,
                    'password' => bcrypt($data['password']),
                    'username' => generate_username(),
                ]);
    }

}
