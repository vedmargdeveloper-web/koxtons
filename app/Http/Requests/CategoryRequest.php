<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $table = 'categories';

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
                    'name' => 'required|string|max:255',
                    'parent' => 'nullable|numeric|max:100000',
                    'image' => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:255',
                    'parent' => 'nullable|numeric|max:100000',
                    'image' => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000'
                ];
            }
            default:break;
        }
    }


    public function messages( ) {

        return [
                'name.required' => 'Name is required *',
                'name.string' => 'Name must be valid!',
                'name.max' => 'Name can have upto 255 characters!',
                'name.unique' => 'Name already been used!',

                'parent.max' => 'Parent category must be valid!',
                'parent.numeric' => 'Parent value must be numeric!',

                'image.image' => 'Image must be valid!',
                'image.mimes' => 'Image must be jpg, jpeg, png, gif only!',
                'image.max' => 'Image size can be upto 5MB!'
            ];

    }
}
