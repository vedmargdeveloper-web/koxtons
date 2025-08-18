<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EpinRequest extends FormRequest
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
                    return [
                                'reference' => 'required',
                                'package' => 'required',
                                'epins' => 'nullable|numeric',
                                'amount' => 'required|numeric|max:10000000',
                                'payment_mode' => 'required',
                                'payment_date' => 'required',
                                'image' => 'nullable|mimes:jpeg,jpg,png|max:2048'
                        ];

                break;
            }
            case 'PUT':
            case 'PATCH':
            {
                

                break;
            }
            default: break;
        }
    }


    public function messages() {

        return [
                    'reference.required' => 'Reference is required *',
                    'package.required' => 'Package is required *',
                    'epins.required' => 'Epin is required!',
                    'epins.numeric' => 'Epin must be numeric value!',

                    'amount.required' => 'Amount is required!',
                    'amount.numeric' => 'Amount must be numeric value!',

                    'payment_mode.required' => 'Payment mode is required *',
                    'payment_date.required' => 'Payment date is required *',
                    'payment_date.date' => 'Payment date must be valid date!',
                    'payment_date.date_format' => 'Payment date must be valid date!',
                    'cheque_no.max' => 'Cheque no must be valid!',
            ];
    }
}
