<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Product;
use App\model\ProductAttribute;
use App\model\ProductAttributeMeta;


class VariationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function attribute_price( Request $request ) {

    	if( !$request->ajax() )
    		return;

    	$product = Product::where('product_id', $request->pid)->first(['id', 'price', 'shipping_charge', 'tax', 'discount', 'price_range']);
    	if( !$product )
    		return;

    	$result = ProductAttributeMeta::where(['id' => $request->id, 'product_id' => $product->id])->first();
    	if( $result ) {
    		$json = json_decode($result->value);
    		return response()->json(['price' => $json ? $json->price :  false, 'tax' => $product->tax, 'shipping_charge' => $product->shipping_charge, 'discount' => $product->discount,'size_image' => $json->size_image ? $json->size_image : false ]);
    	}
    	else {
    		return response()->json(['product' => $product ? $product :  false]);
    	}
    }



}