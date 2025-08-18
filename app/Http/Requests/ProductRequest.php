<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Auth;
use App\User;

class ProductRequest extends FormRequest
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

                // if( User::isSeller() ) {
                //         return [
                //             'title' => 'required|string|max:255',
                //             'content' => 'nullable',
                //             'category' => 'required|array|min:1|max:10000',
                //             'tags' => 'nullable|string',
                //             'price' => 'required|numeric|min:0|max:1000000',
                //             'price_range' => 'nullable|max:255',
                //             'shipping_charge' => 'nullable|numeric|min:0|max:1000000',
                //             'discount' => 'nullable|numeric|min:0|max:100',
                //             'mrp' => 'nullable|numeric|min:0|max:1000000',
                //             'quantity' => 'required|numeric|min:0|max:10000',
                //             'color' => 'nullable|array|min:1|max:20',
                //             'color.*' => 'max:50',
                //             'gst' => 'nullable|numeric|max:100',
                            
                //             'file' => 'required|mimes:jpeg,bmp,png,gif,jpg|max:1024',
                //             'files' => 'nullable|max:6',
                //             'files.*' => 'nullable|mimes:jpeg,bmp,png,gif,jpg|max:1024',

                //             'payment_option' => 'required|array',
                //             'payment_option.*' => 'required',

                //             'video' => 'nullable|max:255',
                            
                //             'sizes' => 'nullable|array|min:1|max:20',
                //             'sizes.*' => 'max:50',
                //             'rate' => 'nullable|array',
                //             'rate.*' => 'nullable',
                //             'stock' => 'nullable|array',
                //             'stock.*' => 'nullable|numeric',

                //             'waist_size' => 'nullable|array|min:1|max:20',
                //             'waist_size.*' => 'max:50',
                //             'waist_rate' => 'nullable|array',
                //             'waist_rate.*' => 'nullable',
                //             'waist_stock' => 'nullable|array',
                //             'waist_stock.*' => 'nullable|numeric',

                //             'shoe_size' => 'nullable|array|min:1|max:20',
                //             'shoe_size.*' => 'max:50',
                //             'shoe_rate' => 'nullable|array',
                //             'shoe_rate.*' => 'nullable',
                //             'shoe_stock' => 'nullable|array',
                //             'shoe_stock.*' => 'nullable|numeric',

                //             'child_size' => 'nullable|array|min:1|max:20',
                //             'child_size.*' => 'max:50',
                //             'child_rate' => 'nullable|array',
                //             'child_rate.*' => 'nullable',
                //             'child_stock' => 'nullable|array',
                //             'child_stock.*' => 'nullable|numeric',

                //             'weight' => 'nullable|array',
                //             'weight.*' => 'nullable|numeric',

                //             'width' => 'nullable|array',
                //             'width.*' => 'nullable|numeric',

                //             'height' => 'nullable|array',
                //             'height.*' => 'nullable|numeric',

                //             'length' => 'nullable|array',
                //             'length.*' => 'nullable|numeric',

                //             'dimension_price' => 'nullable|array',
                //             'dimension_price.*' => 'nullable|numeric|min:0|max:1000000',

                //             'custom_size' => 'nullable|array',
                //             'custom_size.*' => 'nullable|max:255',

                //             'custom_size_price' => 'nullable|array',
                //             'custom_size_price.*' => 'nullable|numeric|min:0|max:1000000',
                //         ];
                // }
                // else {
                        return [
                            'title' => 'required|string|max:255',
                            'content' => 'nullable',
                            'category' => 'required|array|min:1|max:10000',
                            'tags' => 'nullable|string',
                            'price' => 'required|numeric|min:0|max:1000000',
                            'price_range' => 'nullable|max:255',
                            'shipping_charge' => 'nullable|numeric|min:0|max:1000000',
                            'discount' => 'nullable|numeric|min:0|max:100',
                            'mrp' => 'nullable|numeric|min:0|max:1000000',
                            'quantity' => 'required|numeric|min:0|max:10000',
                            'color' => 'nullable|array|min:1|max:20',
                            'color.*' => 'max:50',
                            'sizes' => 'nullable|array|min:1|max:20',
                            'sizes.*' => 'max:50',
                            'file' => 'required|mimes:jpeg,bmp,png,gif,jpg|max:5000',
                            'files' => 'nullable|max:10',
                            'files.*' => 'nullable|mimes:jpeg,bmp,png,gif,jpg|max:5000',

                            'video' => 'nullable|max:255',

                            'payment_option' => 'required|array',
                            'payment_option.*' => 'required',

                            'gst' => 'nullable|numeric|max:100',
                            
                            'rate' => 'nullable|array',
                            'rate.*' => 'nullable',
                            'stock' => 'nullable|array',
                            'stock.*' => 'nullable|numeric',

                            'weight' => 'nullable|array',
                            'weight.*' => 'nullable|numeric',

                            'width' => 'nullable|array',
                            'width.*' => 'nullable|numeric',

                            'height' => 'nullable|array',
                            'height.*' => 'nullable|numeric',

                            'length' => 'nullable|array',
                            'length.*' => 'nullable|numeric',

                            'dimension_price' => 'nullable|array',
                            'dimension_price.*' => 'nullable|numeric|min:0|max:1000000',

                            'custom_size' => 'nullable|array',
                            'custom_size.*' => 'nullable|max:255',

                            'custom_size_price' => 'nullable|array',
                            'custom_size_price.*' => 'nullable|numeric|min:0|max:1000000',
                        ];
                // }
            }
            case 'PUT':
            case 'PATCH':
            {

                if( User::isSeller() ) {
                        return [
                            'title' => 'required|string|max:255',
                            'content' => 'nullable',
                            'category' => 'required|array|min:1|max:10000',
                            'tags' => 'nullable|string',
                            'price' => 'required|numeric|min:0|max:1000000',
                            'price_range' => 'nullable|max:255',
                            'shipping_charge' => 'nullable|numeric|min:0|max:1000000',
                            'discount' => 'nullable|numeric|min:0|max:100',
                            'mrp' => 'nullable|numeric|min:0|max:1000000',
                            'quantity' => 'required|numeric|min:0|max:10000',
                            'color' => 'nullable|array|min:1|max:20',
                            'color.*' => 'max:50',
                            'sizes' => 'nullable|array|min:1|max:20',
                            'sizes.*' => 'max:50',
                            'file' => 'nullable|mimes:jpeg,bmp,png,gif,jpg|max:1024',
                            'files' => 'nullable|max:6',
                            'files.*' => 'nullable|mimes:jpg,jpeg,bmp,png,gif|max:1024',

                            'video' => 'nullable|max:255',

                            'gst' => 'nullable|numeric|max:100',

                            'rate' => 'nullable|array',
                            'rate.*' => 'nullable',
                            'stock' => 'nullable|array',
                            'stock.*' => 'nullable|numeric',

                            'weight' => 'nullable|array',
                            'weight.*' => 'nullable|numeric',

                            'payment_option' => 'required|array',
                            'payment_option.*' => 'required',

                            'width' => 'nullable|array',
                            'width.*' => 'nullable|numeric',

                            'height' => 'nullable|array',
                            'height.*' => 'nullable|numeric',
                            
                            'length' => 'nullable|array',
                            'length.*' => 'nullable|numeric',

                            'dimension_price' => 'nullable|array',
                            'dimension_price.*' => 'nullable|numeric|min:0|max:1000000',

                            'custom_size' => 'nullable|array',
                            'custom_size.*' => 'nullable|max:255',

                            'custom_size_price' => 'nullable|array',
                            'custom_size_price.*' => 'nullable|numeric|min:0|max:1000000',
                        ];
                }
                else {
                        return [
                            'title' => 'required|string|max:255',
                            'content' => 'nullable',
                            'category' => 'required|array|min:1|max:10000',
                            'tags' => 'nullable|string',
                            'price' => 'required|numeric|min:0|max:1000000',
                            'price_range' => 'nullable|max:255',
                            'shipping_charge' => 'nullable|numeric|min:0|max:1000000',
                            'discount' => 'nullable|numeric|min:0|max:100',
                            'mrp' => 'nullable|numeric|min:0|max:1000000',
                            'quantity' => 'required|numeric|min:0|max:10000',
                            'color' => 'nullable|array|min:1|max:20',
                            'color.*' => 'max:50',
                            'sizes' => 'nullable|array|min:1|max:20',
                            'sizes.*' => 'max:50',
                            'file' => 'nullable|mimes:jpeg,bmp,png,gif,jpg|max:1024',
                            'files' => 'nullable|max:10',
                            'files.*' => 'nullable|mimes:jpg,jpeg,bmp,png,gif|max:1024',

                            'video' => 'nullable|max:255',

                            'gst' => 'nullable|numeric|max:100',

                            'payment_option' => 'required|array',
                            'payment_option.*' => 'required',

                            'rate' => 'nullable|array',
                            'rate.*' => 'nullable',
                            'stock' => 'nullable|array',
                            'stock.*' => 'nullable|numeric',

                            'weight' => 'nullable|array',
                            'weight.*' => 'nullable|numeric',

                            'width' => 'nullable|array',
                            'width.*' => 'nullable|numeric',

                            'height' => 'nullable|array',
                            'height.*' => 'nullable|numeric',
                            
                            'length' => 'nullable|array',
                            'length.*' => 'nullable|numeric',

                            'dimension_price' => 'nullable|array',
                            'dimension_price.*' => 'nullable|numeric|min:0|max:1000000',

                            'custom_size' => 'nullable|array',
                            'custom_size.*' => 'nullable|max:255',

                            'custom_size_price' => 'nullable|array',
                            'custom_size_price.*' => 'nullable|numeric|min:0|max:1000000',
                        ];
                }
            }
            default:break;
        }

    }

    public function messages( ) {

        return [
                'title.required' => 'Title is required *',
                'title.string' => 'Title must be valid!',
                'title.max' => 'Title can have upto 255 characters!',

                'content.max' => 'Content is required *',

                'category.required' => 'Category is required *',
                'category.numeric' => 'Category must be valid!',
                'category.min' => 'Category must be valid!',
                'category.max' => 'Category must be valid!',

                'tags.string' => 'Tags must be valid!',
                'price.required' => 'Price is required *',
                'price.numeric' => 'Price must be valid numeric value!',
                'price.min' => 'Price must be valid numeric value!',
                'price.max' => 'Price can not be greater than 1000000!',

                'mrp.numeric' => 'MRP must be numeric value!',
                'mrp.min' => 'MRP must be valid numeric value!',
                'mrp.max' => 'MRP can not be greater than 1000000!',

                'shipping_charge.required' => 'Shipping charge is required *',
                'shipping_charge.numeric' => 'Shipping charge must be valid numeric value!',
                'shipping_charge.min' => 'Shipping charge must be valid numeric value!',
                'shipping_charge.max' => 'Shipping charge can not be greater than 1000000!',

                'quantity.required' => 'Quantity is required *',
                'quantity.numeric' => 'Quantity must be valid numeric value!',
                'quantity.min' => 'Quantity must be valid numeric value!',
                'quantity.max' => 'Quantity can not be greater than 10000!',

                'discount.numeric' => 'Discount must be valid numeric value!',
                'discount.min' => 'Discount must be valid numeric value!',
                'discount.max' => 'Discount can not be greater than 100%!',

                'color.required' => 'Color is required *',
                'color.min' => 'Color is required *',
                'color.*.required' => 'Color is required *',
                'color.*.max' => 'Color can have upto 50 characters!',

                'price_range.max' => 'Price range can have upto 255 characters!',

                'sizes.required' => 'Size is required *',
                'sizes.min' => 'Size is required *',
                'sizes.*.required' => 'Size is required *',
                'sizes.*.max' => 'Size can have upto 8 characters!',

                'file.required' => 'Feature image is required *',
                'file.image' => 'Feature image must be an image!',
                'file.mimes' => 'Feature image must be jpg, jpeg, png, gif only!',
                'file.max' => 'Feature image size can have upto 1MB',

                'files.image' => 'Images must be valid!',
                'files.array' => '',
                'files.mimes' => 'Images must be jpg, jpeg, png, gif only!',
                'files.max' => 'You can upload upto 6 image only!',

                'files.*.image' => 'Image must be valid!',
                'files.*.mimes' => 'Image must be jpg, jpeg, png, gif only!',
                'files.*.max' => 'Image size can be upto 1MB!',

                'dimension_price.array' => 'Price must be valid!',
                'dimension_price.*.max' => 'Price must be valid *',
                'dimension_price.*.min' => 'Price must be valid *',
                'dimension_price.*.numeric' => 'Price must be valid *',

                'custom_size.array' => 'Size must be valid *',
                'custom_size.*.max' => 'Size must be valid *',

                'custom_size_price.array' => 'Price must be valid *',
                'custom_size_price.*.max' => 'Price must be valid *',

                'custom_size_price.*.min' => 'Price must be valid *',
                'custom_size_price.*.numeric' => 'Price must be valid *',

                'video.max' => 'Video can have upto 255 characters!',

                'payment_option.required' => 'Payment option is required *',

                'gst.numeric' => 'GST must be numeric value!',
                'gst.max' => 'GST must be between 1 - 100%',

            ];

    }
}
