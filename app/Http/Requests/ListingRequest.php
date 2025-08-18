<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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

                if( $request->step === 'create' ) {
                    return [
                        'title' => 'required|string|max:255',
                        'category' => 'required|numeric|max:100000',
                        'content' => 'required',
                        'tags' => 'required'
                    ];
                }
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|max:255',
                    'parent' => 'nullable|numeric|max:100000',
                    'image' => 'nullable|image|mimes:jpeg,bmp,png,jpg|max:5000'
                ];
            }
            default:break;
        }
    }


    public function messages( ) {

        return [
                'title.required' => 'Title is required *',
                'title.string' => 'Title must be valid!',
                'title.max' => 'Title can have upto 255 characters!',

                'category.max' => 'Category must be valid!',
                'category.numeric' => 'Category must be valid!',
                'category.required' => 'Category is required *',

                'content.required' => 'Content is required *',
                'tags.required' => 'Tag is required *'
            ];

    }
}
