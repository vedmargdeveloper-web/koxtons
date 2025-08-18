<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ReviewRequest extends FormRequest
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
            case 'PUT':
                return [];
                break;

            case 'POST':

                return [
                        'product_id' => 'required',
                        'review' => 'max:5000',
                        'star' => 'required|numeric|max:5|min:1',
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                ];
                break;
            
            default:
                # code...
                break;
        }

    }

    public function messages() {
        return [
                    'review.max' => 'Review can have upto 255 characters *',

                    'star.required' => 'Give a rating *',
                    'star.numeric' => 'Give a rating *',
                    'star.min' => 'Give a rating *',
                    'star.max' => 'Give a rating *',

                    'name.required' => 'Name is required *',
                    'name.string' => 'Name must be valid!',
                    'name.max' => 'Name can have upto 255 characters!',

                    'email.required' => 'Email is required *',
                    'email.email' => 'Email must be valid!',
                    'email.max' => 'Email can have upto 255 characters!',
            ];
    }
}
