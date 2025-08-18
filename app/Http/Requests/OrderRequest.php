<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
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
        
        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'first_name' => 'required|string|max:255',
                    // 'last_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'country' => 'required|numeric|min:1',
                    'city' => 'required|string|max:255',
                    'state' => 'nullable|numeric|min:1',
                    'mobile' => 'required|numeric|min:1111111111|max:9999999999',
                    'alternate' => 'nullable|max:20',
                    'address' => 'required|array|min:1|max:2',
                    // 'address.*' => 'required|max:255',
                    'pincode' => 'required|numeric|digits:6',
                    'payment_method' => 'required',
                    'product_id' => 'required|array',
                    'product_id.*' => 'required',
                    'remarks' => 'nullable|max:5000',
                    'file' => 'nullable|mimes:jpg,png,jpeg,gif|max:1024',
                    'gst_no' => 'nullable|string|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                
            }
            default:break;
        }

    }

    public function messages( ) {

        return [
                'first_name.required' => 'First name is required *',
                'first_name.string' => 'First name must be valid!',
                'first_name.max' => 'First name can have upto 255 characters!',
                'last_name.required' => 'Last name is required *',
                'last_name.string' => 'Last name must be valid!',
                'last_name.max' => 'Last name can have upto 255 characters!',

                'email.required' => 'Email is required *',
                'email.email' => 'Email must be valid!',
                'email.max' => 'Email can have upto 255 characters!',

                'country.required' => 'Country is required *',
                'country.numeric' => 'Country must be valid!',
                'country.min' => 'Country must be valid!',
                'state.required' => 'State is required *',
                'state.numeric' => 'State must be valid!',
                'state.min' => 'State must be valid!',

                'city.required' => 'City is required *',
                'city.string' => 'City must be valid!',
                'city.max' => 'City can have upto 255 characters!',
                
                'mobile.required' => 'Mobile is required *',
                'mobile.numeric' => 'Mobile no must be valid 10 digit number*',
                'mobile.min' => 'Mobile no must be valid 10 digit number*',
                'mobile.max' => 'Mobile no must be valid 10 digit number*',

                'pincode.required' => 'Pincode is required *',
                'pincode.numeric' => 'Pincode must be valid 6 digit number*',
                'pincode.min' => 'Pincode must be valid 6 digit number*',
                'pincode.max' => 'Pincode must be valid 6 digit number*',

                'address.required' => 'Address is required *',
                'address.*.required' => 'Address is required *',
                'address.min' => 'Address is required *',
                'address.*.min' => 'Address is required *',
                'address.max' => 'Address is required *',
                'address.*.max' => 'Address is required *',

                'payment_method.required' => 'Select a payment method!',

                'accept.required' => 'Please accept the terms & conditions!',

                'remarks.max' => 'Remark can have upto 5000 characters!',
                'file.mimes' => 'File must be valid jpg, png, jpeg, gif image!',
                'file.max' => 'File size must be less than 1 MB!',

                'gst_no.string' => 'GST No. must be valid!',
                'gst_no.max' => 'GST No. must be valid!',
                
            ];

    }
}
