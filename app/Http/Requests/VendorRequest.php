<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules( Request $request )
    {
        switch( $this->method() )
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'firm_name' => 'required|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'phone' => 'required|max:255',
                    'city' => 'required|max:255',
                    'state' => 'required|max:255',
                    'address' => 'required|max:255',
                    'pin' => 'required|numeric|min:111111|max:999999',
                    'password' => 'required|min:8|max:255'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
               /* return [
                    'title' => 'required|min:1|max:255|unique:'.$this->table.',id,'.$this->get('id'),
                    'content' => 'max:100000',
                    'featuredImage' => 'nullable|image|mimes:jpeg,bmp,png,jpg,gif|max:5000',
                    'category' => 'required|numeric|min:1|max:100000',
                    'mid' => 'nullable|numeric|min:1|max:100000'
                ];*/

                return [
                    'firm_name' => 'required|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,'.$this->id,
                    'phone' => 'required|max:255',
                    'city' => 'required|max:255',
                    'state' => 'required|max:255',
                    'address' => 'required|max:255',
                    'pin' => 'required|numeric|min:111111|max:999999',
                    'password' => 'required|min:8|max:255'
                ];
            }
            default:break;
        }
    }


    public function messages( ) {

        return [

                'firm_name.required' => 'Firm name is required *',
                'firm_name.max' => 'Firm name can have upto 255 characters!',

                'first_name.required' => 'First name is required *',
                'first_name.max' => 'First name can have upto 255 characters!',

                'last_name.required' => 'Last name is required *',
                'last_name.max' => 'Last name can have upto 255 characters!',

                'email.required' => 'Email is required *',
                'email.max' => 'Email can have upto 255 characters!',
                'email.email' => 'Email must be valid!',
                'email.unique' => 'Email is already in use!',

                'city.required' => 'City is required *',
                'city.max' => 'City can have upto 255 characters!',

                'state.required' => 'State is required *',
                'state.max' => 'State can have upto 255 characters!',

                'address.required' => 'Address is required *',
                'address.max' => 'Address can have upto 255 characters!',

                'phone.required' => 'Phone no is required *',
                'phone.max' => 'Phone no can have upto 255 characters!',

                'pin.required' => 'Pin code is required *',
                'pin.max' => 'Pin code must be valid!',
                'pin.min' => 'Pin code must be valid!',


                'username.required' => 'Username is required *',
                'username.email' => 'Username must be valid!',
                'password.required' => 'Password is required *',

                'password.min' => 'Password must have atleast 8 characters!',
                'password.max' => 'Password can have upto 255 characters!',
            ];

    }
}
