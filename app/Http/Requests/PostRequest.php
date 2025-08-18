<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $table = 'posts';

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

                if( $request->type === 'post' ) {
                    return [
                        'title' => 'required|min:1|max:255|unique:'.$this->table,
                        'content' => 'nullable',
                        'feature_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
                        'category' => 'nullable|numeric|min:1|max:100000'
                    ];
                }
                if( $request->type === 'page' ) {
                    return [
                        'title' => 'required|min:1|max:255|unique:'.$this->table,
                        'content' => 'nullable',
                        'feature_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
                        'category' => 'nullable|numeric|min:1|max:100000'
                    ];
                }
            }
            case 'PUT':
            case 'PATCH':
            {

                if( $request->type === 'post' ) {
                    return [
                        'title' => 'required|min:1|max:255|unique:'.$this->table.',id,'.$this->get('id'),
                        'content' => 'nullable',
                        'feature_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
                        'category' => 'nullable|numeric|min:1|max:100000'
                    ];
                }
                if( $request->type === 'page' ) {
                    return [
                        'title' => 'required|min:1|max:255|unique:'.$this->table.',id,'.$this->get('id'),
                        'content' => 'nullable',
                        'feature_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000',
                        'category' => 'nullable|numeric|min:1|max:100000'
                    ];
                }
            }
            default:break;
        }
    }

    public function messages() {

        return [
                    'title.required' => 'Title is required *',
                    'title.min' => 'Title is required *',
                    'title.max' => 'Title can have upto 255 characters!',
                    'title.unique' => 'Title already exist!',

                    'feature_image.image' => 'Feature image must be valid image!',
                    'feature_image.mimes' => 'Feature image can have jpg, jpeg, png, gif only!',
                    'feature_image.max' => 'Feature image size must be less than 5 MB!',

                    'category.required' => 'Category is required *',
                    'category.numeric' => 'Category must be valid!',
                    'category.max' => 'Category must be valid!'

        ];
    }
}
