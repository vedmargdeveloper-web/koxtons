<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use App\User;

class MemberRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {

                if( User::isAdmin() ) {
                    if( $request->step === 'create' ) {
                        return [
                                        'reference' => 'nullable',
                                        'epin_id' => 'required',
                                        'first_name' => 'required|max:255',
                                        'last_name' => 'required|max:255',
                                        'email' => 'required|max:255|email',
                                        'password' => 'required|min:8|max:255',
                                        'tnc' => 'required',
                            ];
                    }
                    elseif( $request->step === 'contact' ) {
                        return [
                                        'gender' => 'required|max:255',
                                        'code' => 'nullable',
                                        'mobile' => 'required|max:20',
                                        'country' => 'required',
                                        'state' => 'required',
                                        'city' => 'required',
                                        'address' => 'nullable|max:255',
                                        'landmark' => 'nullable|max:255',
                                        'pincode' => 'nullable|numeric',
                                        'account_holder_name' => 'nullable|max:255',
                                        'bank_name' => 'nullable|max:255',
                                        'account_no' => 'nullable|max:255',
                                        'bank_ifsc' => 'nullable|max:255',
                                        'bank_address' => 'nullable|max:255',
                                        'uid' => 'required'
                            ];
                    }
                }
                else if( $request->step === 'create' ) {
                    return [
                                    'reference' => 'required',
                                    'epin_id' => 'required',
                                    'first_name' => 'required|max:255',
                                    'last_name' => 'required|max:255',
                                    'email' => 'required|max:255|email',
                                    'password' => 'required|min:8|max:255',
                                    'tnc' => 'required',
                        ];
                }
                elseif( $request->step === 'contact' ) {
                    return [
                                    'gender' => 'required|max:255',
                                    'code' => 'nullable',
                                    'mobile' => 'required|max:20',
                                    'country' => 'required',
                                    'state' => 'required',
                                    'city' => 'required',
                                    'address' => 'nullable|max:255',
                                    'landmark' => 'nullable|max:255',
                                    'pincode' => 'nullable|numeric',
                                    'account_holder_name' => 'nullable|max:255',
                                    'bank_name' => 'nullable|max:255',
                                    'account_no' => 'nullable|max:255',
                                    'bank_ifsc' => 'nullable|max:255',
                                    'bank_address' => 'nullable|max:255',
                                    'uid' => 'required'
                        ];
                }
                elseif( $request->step === 'document' ) {
                    return [ 'uid' => 'required' ];
                }
                else {
                    return [
                                    'reference' => 'required',
                                    'first_name' => 'required|max:255',
                                    'last_name' => 'required|max:255',
                                    'email' => 'required|max:255|email',
                                    'password' => 'required|min:8|max:255',
                                    'gender' => 'required|max:255',
                                    'code' => 'nullable',
                                    'mobile' => 'required|max:20',
                                    'country' => 'required',
                                    'state' => 'required',
                                    'city' => 'required',
                                    'address' => 'nullable|max:255',
                                    'landmark' => 'nullable|max:255',
                                    'pincode' => 'nullable|numeric',
                                    'account_holder_name' => 'nullable|max:255',
                                    'bank_name' => 'nullable|max:255',
                                    'account_no' => 'nullable|max:255',
                                    'bank_ifsc' => 'nullable|max:255',
                                    'bank_address' => 'nullable|max:255'
                        ];
                }

                break;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                            'reference' => 'required',
                            'epin_id' => 'required',
                            'email' => 'required|email|max:255',
                            'first_name' => 'required|max:255',
                            'last_name' => 'required|max:255',
                            'gender' => 'required|max:255',
                            'code' => 'nullable',
                            'mobile' => 'required|max:20',
                            'country' => 'required',
                            'state' => 'required',
                            'city' => 'required',
                            'address' => 'nullable|max:255',
                            'landmark' => 'nullable|max:255',
                            'pincode' => 'nullable|numeric',
                            'account_holder_name' => 'nullable|max:255',
                            'bank_name' => 'nullable|max:255',
                            'account_no' => 'nullable|max:255',
                            'bank_ifsc' => 'nullable|max:255',
                            'bank_address' => 'nullable|max:255',
                            'uid' => 'required',
                            'password' => 'nullable|min:8|max:255',
                ];

                break;
            }
            default: break;
        }
    }


    public function messages() {

        return [
                    'reference.required' => 'Reference is required *',
                    'side.required' => 'Side is required!',

                    'first_name.required' => 'First name is required!',
                    'first_name.max' => 'First name can have upto 255 characters!',

                    'last_name.required' => 'Last name is required!',
                    'last_name.max' => 'Last name can have upto 255 characters!',

                    'email.required' => 'Email address is required *',
                    'email.email' => 'Email address must be valid!',
                    'email.unique' => 'Email address already exist!',
                    'email.max' => 'Email address can have upto 255 characters!',

                    'password.max' => 'Password can have upto 255 characters!',
                    'password.required' => 'Password is required!',
                    'password.min' => 'Password must have atleast 8 characters!',

                    'gender.required' => 'Gender is required *',
                    'gender.max' => 'Gender must be valid!',
                    'code.required' => 'Phonecode is required *',
                    'mobile.required' => 'Mobile no. is required *',
                    'mobile.max' => 'Mobile no. must be valid!',
                    'country.required' => 'Country is required *',
                    'state.required' => 'State is required *',
                    'city.required' => 'City is required *',
                    'address.max' => 'Address can have upto 255 characters!',
                    'landmark.max' => 'Landmark can have upto 255 characters!',
                    'pincode.numeric' => 'Pincode must be valid!',
                    'account_holder_name.max' => 'Account holder name can have upto 255 characters!',
                    'bank_name.max' => 'Bank name can have upto 255 characters!',
                    'account_no.max' => 'Account no. can have upto 255 characters!',
                    'bank_ifsc.max' => 'Bank IFSC code must be valid!',
                    'bank_address.max' => 'Bank address can have upto 255 characters!',

                    'uid.required' => 'Oops! Something went wrong.',
                    'tnc.required' => 'Accept the terms & conditions!'

            ];
    }

}
