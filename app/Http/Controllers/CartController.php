<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\model\Product;
use App\model\Category;
use App\model\ProductAttributeMeta;
use App\model\VisiterCart;
use Cookie;
use Session;
use Validator;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gift/cart/index', ['title' => 'Cart items']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function get( Request $request ) {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode($cookie);
            $data = isset($cookieObj->token) && $cookieObj->token ? VisiterCart::where('token', $cookieObj->token)->get() : false;
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        if( !$request->id || !$request->product_id )
            return response()->json(['response' => false, 'message' => 'Something went wrong!']);

        $product = Product::where(['id' => $request->id, 'product_id' => $request->product_id])->first();

        if( !$product )
            return response()->json(['response' => false, 'message' => 'Something went wrong!']);


        $price = $product->price;
        $attrSize = '';
        $stock = $product->quantity;
        $attrName = '';
        $attrId = 0;
        if( $request->size ) {
            $meta = ProductAttributeMeta::where('id', $request->size)->first();
            if( $meta ) {
                $attrSize = $meta->value;
                $value = json_decode($meta->value);
                $stock = $value->stock;
                $attrName = $value->name;
                if( isset($value->stock) && $value->stock < $request->quantity ) {
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                }

                if( isset($value->price) && $value->price ) {
                    $price = $value->price;
                }
            }
        }

        $attrCSize = '';
        if( $request->c_size ) {
            $meta = ProductAttributeMeta::where('id', $request->c_size)->first();
            if( $meta ) {
                $attrCSize = $meta->value;
                $value = json_decode($meta->value);
                $stock = $value->stock;
                $attrName = $value->name;
                if( isset($value->stock) && $value->stock < $request->quantity ) {
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                }

                if( isset($value->price) && $value->price ) {
                    $price = $value->price;
                }
            }
        }


        $productAttrMeta = ProductAttributeMeta::where('product_id', $request->id)->get();

        $cat_slug = Category::find($product->category_id)->slug;
        $url = url('/' . $cat_slug . '/' . $product->slug . '/' . $request->product_id . '?source=cart');

        $response = new Response('Cart');
        /*$cookie = Cookie::forget('customerCartProductList');
        return $response->withCookie($cookie);*/

        $data = array();

        $original_price = $product->price;
        $price = $price;

        $found = false;
        $color_found = false;

        $cookie1 = Cookie::get('customerCartProductList_buynow');

        // echo json_encode($cookie1); die();

        if( $cookie1 ):

            $cookieObj = json_decode($cookie1);
            if( $cookieObj && isset( $cookieObj->token ) ):

                $cartProduct = VisiterCart::where('token', $cookieObj->token)->delete();
                
                \Cookie::queue(Cookie::forget('customerCartProductList_buynow'));  
            endif;

        endif;

        $token = strtolower( randomString(32) );
        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode( $cookie );
            $token = isset( $cookieObj->token ) && $cookieObj->token ? $cookieObj->token : false;
        }
        $found = false;
        $userCart = $token ? VisiterCart::where('token', $token)->get() : false;
        if( $userCart && count( $userCart ) ) {
            foreach ($userCart as $row) {

                $var = json_decode($row->variations);
                if( $row->product_no == $request->product_id ) {

                    $found = true;
                    $quantity = $request->quantity ? $request->quantity : 1;
                    if( isset($var->quantity) && $var->quantity ) {
                        $quantity += $var->quantity;
                    }

                    if( $quantity > $stock ) {
                        if( $attrName )
                            return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$attrName.'" has only '.$stock.' in stock!']);
                        else
                            return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
                    }


                    $variation = [
                            'title' => $var->title,
                            'variation_name' => $var->variation_name ?? '',
                            'url' => $var->url,
                            'feature_image' => $var->feature_image,
                            'original_price' => $var->original_price,
                            'price' => $var->price,
                            'tax' => $var->tax,
                            'discount' => $var->discount,
                            'quantity' => $quantity,
                            'color' => $request->color,
                            'size' => $request->size,
                            'c_size' => $request->c_size,
                            'shipping_charge' => $var->shipping_charge,
                        ];
                        
                    $data = [
                            'token' => $row->token,
                            'user_id' => Auth::check() ? Auth::id() : null,
                            'product_id' => $row->product_id,
                            'product_no' => $row->product_no,
                            'variations' => json_encode($variation)
                        ];
                    
                    if( $request->c_size ) {
                        if($request->c_size == $var->c_size ){
                            VisiterCart::where('id', $row->id)->update( $data );
                        }                        
                        else {
                            $found = false;
                        }
                    }
                    else {
                        VisiterCart::where('id', $row->id)->update( $data );
                    }
                    // else{

                    //     if( !$stock || $request->quantity > $stock ) {
                    //         if( $attrName )
                    //             return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$attrName.'" has only '.$stock.' in stock!']);
                    //         else
                    //             return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
                    //     }

                    //     $variation = [
                    //             'title' => $product->title,
                    //             'url' => $url,
                    //             'feature_image' => asset('public/'.product_file(thumb($product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))),
                    //             'original_price' => $original_price,
                    //             'price' => $price,
                    //             'discount' => $product->discount,
                    //             'tax' => $product->tax,
                    //             'quantity' => $request->quantity ? $request->quantity : 1,
                    //             'color' => $request->color,
                    //             'size' => $request->size,
                    //             'c_size' => $request->c_size,
                    //             'shipping_charge' => $product->shipping_charge,
                    //         ];

                    //     $data = [
                    //             'token' => $token,
                    //             'user_id' => Auth::check() ? Auth::id() : null,
                    //             'product_id' => $product->id,
                    //             'product_no' => $product->product_id,
                    //             'variations' => json_encode($variation)
                    //         ];

                    //     VisiterCart::create( $data );
                    // }
                    
                }
            }
        }

        if( !$found ) {

            if( !$stock || $request->quantity > $stock ) {
                if( $attrName )
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$attrName.'" has only '.$stock.' in stock!']);
                else
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
            }

            $attr = false;
            if( $request->c_size )
                $attr = $productAttrMeta->where('id', $request->c_size)->first();
            else if( $request->color )
                $attr = $productAttrMeta->where('id', $request->color)->first();
            else if( $request->size )
                $attr = $productAttrMeta->where('id', $request->size)->first();

            $variation = [
                    'title' => $product->title,
                    'url' => $url,
                    'variation_name' => $attr ? $attr->name : '',
                    'feature_image' => asset('public/'.product_file(thumb($product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))),
                    'original_price' => $original_price,
                    'price' => $price,
                    'discount' => $product->discount,
                    'tax' => $product->tax,
                    'quantity' => $request->quantity ? $request->quantity : 1,
                    'color' => $request->color,
                    'size' => $request->size,
                    'c_size' => $request->c_size,
                    'shipping_charge' => $product->shipping_charge,
                ];

            $data = [
                    'token' => $token,
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'product_id' => $product->id,
                    'product_no' => $product->product_id,
                    'variations' => json_encode($variation)
                ];

            VisiterCart::create( $data );
        }    

        $json = json_encode(['token' => $token]);
        $response->withCookie( cookie()->forever('customerCartProductList', $json) );
        return $response;
        /*if( $cookie = $request->cookie('customerCartProductList') ) {

            $cookieObj = json_decode( $cookie );

            foreach( $cookieObj as $coo ) {

                $data[] = array(
                                    'key' => random_int(1111, 999999),
                                    'id' => isset($coo->id) ? $coo->id : '',
                                    'product_id' => isset($coo->product_id) ? $coo->product_id : '',
                                    'title' => isset($coo->title) ? $coo->title : '',
                                    'url' => isset($coo->url) ? $coo->url : '',
                                    'feature_image' => isset($coo->feature_image) ? $coo->feature_image : '',
                                    'original_price' => isset($coo->original_price) ? $coo->original_price : '',
                                    'price' => isset($coo->price) ? $coo->price : '',
                                    'discount' => isset($coo->discount) ? $coo->discount : '',
                                    'quantity' => isset($coo->quantity) ? $coo->quantity : '',
                                    'color' => isset($coo->color) ? $coo->color : '',
                                    'size' => isset($coo->size) ? $coo->size : '',
                                    'c_size' => isset($coo->c_size) ? $coo->c_size : '',
                            );

            }
        }*/
        //else {
            /*$data[] = array(
                        'key' => random_int(1111, 999999),
                        'id' => $request->id,
                        'product_id' => $request->product_id,
                        'title' => $product->title,
                        'url' => $url,
                        'feature_image' => asset('public/'.product_file(thumb($product->feature_image, 130, 140))),
                        'original_price' => $original_price,
                        'price' => $price,
                        'discount' => $product->discount,
                        'quantity' => $request->quantity ? $request->quantity : 1,
                        'color' => $request->color,
                        'size' => $request->size,
                        'c_size' => $request->c_size,
                    );*/
        //}

            //var_dump($data);
        
        /*$json = json_encode( $data );
        $response->withCookie( cookie()->forever('customerCartProductList', $json) );
        return $response;*/
    }



    public function store_buynow(Request $request)
    {
        

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }
        
        if( !$request->id || !$request->product_id )
            return response()->json(['response' => false, 'message' => 'Something went wrong!']);

        $product = Product::where(['id' => $request->id, 'product_id' => $request->product_id])->first();

        if( !$product )
            return response()->json(['response' => false, 'message' => 'Something went wrong!']);


        $price = $product->price;
        $attrSize = '';
        $stock = $product->quantity;
        $attrName = '';
        $attrId = 0;
        if( $request->size ) {
            $meta = ProductAttributeMeta::where('id', $request->size)->first();
            if( $meta ) {
                $attrSize = $meta->value;
                $value = json_decode($meta->value);
                $stock = $value->stock;
                $attrName = $value->name;
                if( isset($value->stock) && $value->stock < $request->quantity ) {
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                }

                if( isset($value->price) && $value->price ) {
                    $price = $value->price;
                }
            }
        }

        $attrCSize = '';
        if( $request->c_size ) {
            $meta = ProductAttributeMeta::where('id', $request->c_size)->first();
            if( $meta ) {
                $attrCSize = $meta->value;
                $value = json_decode($meta->value);
                $stock = $value->stock;
                $attrName = $value->name;
                if( isset($value->stock) && $value->stock < $request->quantity ) {
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                }

                if( isset($value->price) && $value->price ) {
                    $price = $value->price;
                }
            }
        }

        $cat_slug = Category::find($product->category_id)->slug;
        $url = url('/' . $cat_slug . '/' . $product->slug . '/' . $request->product_id . '?source=cart');

        $response = new Response('Cart');

        $data = array();

        $original_price = $product->price;
        $price = $price;

        $found = false;
        $color_found = false;


        $cookie1 = Cookie::get('customerCartProductList_buynow');

        if( $cookie1 ):

            $cookieObj = json_decode($cookie1);
            if( $cookieObj && isset( $cookieObj->token ) ):

                $cartProduct = VisiterCart::where('token', $cookieObj->token)->delete();
                // \Cookie::queue(Cookie::forget('customerCartProductList_buynow'));  

            endif;

        endif;



        $token = strtolower( randomString(32) );
        if( $cookie = $request->cookie('customerCartProductList_buynow') ) {
            $cookieObj = json_decode( $cookie );
            $token = isset( $cookieObj->token ) && $cookieObj->token ? $cookieObj->token : false;
        }
        $found = false;
        $userCart = $token ? VisiterCart::where('token', $token)->get() : false;
        if( $userCart && count( $userCart ) ) {
            foreach ($userCart as $row) {

                $var = json_decode($row->variations);
                if( $row->product_no == $request->product_id ) {

                    $found = true;
                    $quantity = $request->quantity ? $request->quantity : 1;
                    if( isset($var->quantity) && $var->quantity ) {
                        $quantity += $var->quantity;
                    }

                    if( $quantity > $stock ) {
                        if( $attrName )
                            return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$attrName.'" has only '.$stock.' in stock!']);
                        else
                            return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
                    }

                    $variation = [
                            'title' => $var->title,
                            'variation_name' => $var->variation_name ?? '',
                            'url' => $var->url,
                            'feature_image' => $var->feature_image,
                            'original_price' => $var->original_price,
                            'price' => $var->price,
                            'tax' => $var->tax,
                            'discount' => $var->discount,
                            'quantity' => $quantity,
                            'color' => $request->color,
                            'size' => $request->size,
                            'c_size' => $request->c_size,
                            'color_variation' => $request->color_varient,
                            'color_su_code' => $request->color_su_code,
                            'shipping_charge' => $var->shipping_charge,
                        ];
                        
                    $data = [
                            'token' => $row->token,
                            'user_id' => Auth::check() ? Auth::id() : null,
                            'product_id' => $row->product_id,
                            'product_no' => $row->product_no,
                            'variations' => json_encode($variation)
                        ];

                    VisiterCart::where('id', $row->id)->update( $data );
                }
            }
        }

        if( !$found ) {

            if( !$stock || $request->quantity > $stock ) {
                if( $attrName )
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Size "'.$attrName.'" has only '.$stock.' in stock!']);
                else
                    return response()->json(['response' => false, 'quantity' => false, 'message' => 'Only '.$stock.' available!']);
            }

            $attr = false;
            if( $request->c_size )
                $attr = $productAttrMeta->where('id', $request->c_size)->first();
            else if( $request->color )
                $attr = $productAttrMeta->where('id', $request->color)->first();
            else if( $request->size )
                $attr = $productAttrMeta->where('id', $request->size)->first();

            $variation = [
                    'title' => $product->title,
                    'url' => $url,
                    'variation_name' => $attr ? $attr->name : null,
                    'feature_image' => asset('public/'.product_file(thumb($product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))),
                    'original_price' => $original_price,
                    'price' => $price,
                    'discount' => $product->discount,
                    'tax' => $product->tax,
                    'quantity' => $request->quantity ? $request->quantity : 1,
                    'color' => $request->color,
                    'size' => $request->size,
                    'c_size' => $request->c_size,
                    'color_variation' => $request->color_varient,
                    'color_su_code' => $request->color_su_code,
                    'shipping_charge' => $product->shipping_charge,
                ];

            $data = [
                    'token' => $token,
                    'user_id' => Auth::check() ? Auth::id() : null,
                    'product_id' => $product->id,
                    'product_no' => $product->product_id,
                    'variations' => json_encode($variation)
                ];

            VisiterCart::create( $data );
        }    

        $json = json_encode(['token' => $token]);
        $response->withCookie( cookie()->forever('customerCartProductList_buynow', $json) );
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }

        $validator = Validator::make( $request->all(),[
                                'id' => 'required|array',
                                'id.*' => 'required|numeric|min:1',
                                'product_id' => 'required|array',
                                'product_id.*' => 'required|numeric|min:1',
                                'quantity' => 'required|array|min:1',
                                'quantity.*' => 'required|numeric|min:1',
                        ]);
        if( $validator->fails() ) {
            return json_encode(['response' => false, 'response_msg' => 'Something went wrong, cart could not update!']);
        }

        $response = new Response('Cart Updated');

        $token = false;
        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode( $cookie );
            $token = isset( $cookieObj->token ) ? $cookieObj->token : false;
        }

        if( !$token ) {
            return json_encode(['response' => false, 'response_msg' => 'Something went wrong, cart could not update!']);
        }

        $userCart = $token ? VisiterCart::where('token', $token)->get() : false;
        if( $userCart && count( $userCart ) ) {
            foreach ($userCart as $row) {

                $var = json_decode($row->variations);

                if( is_array($request->product_id) && in_array($row->product_no, $request->product_id) ) {
                    $keyID = array_search( $row->product_no, $request->product_id );
                    $quantity = isset($request->quantity[$keyID]) ? $request->quantity[$keyID] : 1;

                    $price = $var->price;
                    if( $var->size ) {
                        $meta = ProductAttributeMeta::where('id', $var->size)->first();
                        if( $meta ) {
                            $attrSize = $meta->value;
                            $value = json_decode($meta->value);
                            if( $quantity > $value->stock ) {
                                return response()->json(['response' => false, 'quantity' => false, 'message' => $var->title.', Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                            }
                            if( isset($value->price) && $value->price ) {
                                $price = $value->price;
                            }
                        }
                    }
                    if( $var->c_size ) {
                        $meta = ProductAttributeMeta::where('id', $var->c_size)->first();
                        if( $meta ) {
                            $value = json_decode($meta->value);
                            if( $quantity > $value->stock ) {
                                return response()->json(['response' => false, 'quantity' => false, 'message' => $var->title.', Size "'.$value->name.'" has only '.$value->stock.' in stock!']);
                            }
                            if( isset($value->price) && $value->price ) {
                                $price = $value->price;
                            }
                        }
                    }

                    $variation = [
                                    'title' => $var->title,
                                    'url' => $var->url,
                                    'variation_name' => $var->variation_name ?? '',
                                    'feature_image' => $var->feature_image,
                                    'original_price' => $var->original_price,
                                    'price' => $price,
                                    'discount' => $var->discount,
                                    'tax' => $var->tax,
                                    'quantity' => $quantity,
                                    'color' => $var->color,
                                    'size' => $var->size,
                                    'c_size' => $var->c_size,
                                    'shipping_charge' => $var->shipping_charge,

                            ];
                    $data = [
                                'token' => $token,
                                'user_id' => Auth::check() ? Auth::id() : null,
                                'product_id' => $row->product_id,
                                'product_no' => $row->product_no,
                                'variations' => json_encode($variation)
                            ];

                    VisiterCart::where('id', $row->id)->update( $data );
                }
            }
        }
   
        $json = json_encode(['token' => $token]);
        $response->withCookie( cookie()->forever('customerCartProductList', $json) );
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }
        
        if( !$request->id || !$request->product_id )
            return json_encode(['response' => false]);

        $product = Product::where(['id' => $request->id, 'product_id' => $request->product_id])->first();

        var_dump($_POST);

        if( !$product )
            return response()->json(['response' => false, 'response_msg' => 'Product not found!']);

        $data = array();

        $token = false;
        if( $cookie = $request->cookie('customerCartProductList') ) {
            $cookieObj = json_decode( $cookie );
            $token = isset( $cookieObj->token ) ? $cookieObj->token : false;
        }

        if( !$token )
            return json_encode(['response' => false]);

        $userCart = $token ? VisiterCart::where('token', $token)->get() : false;
        if( $userCart && count( $userCart ) ) {
            VisiterCart::where(['token' => $token, 'id' => $request->key])->delete();
            // foreach ($userCart as $row) {
            //     if( $row->product_no == $request->product_id ) {
            //         VisiterCart::where(['token' => $token, 'product_no' => $row->id])->delete();
            //     }
            // }
        }

        $response = new Response('Cart item deleted!');

        $json = json_encode(['token' => $token]);
        $response->withCookie( cookie()->forever('customerCartProductList', $json) );
        return $response;
    }
}
