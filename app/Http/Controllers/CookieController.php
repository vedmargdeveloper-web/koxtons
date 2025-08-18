<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\model\Product;
use Cookie;

class CookieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( _template('wishlist/index'), ['title' => 'Wishlist']);
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
    public function store(Request $request)
    {

        if( !$request->ajax() ) {
            return redirect( url('/') );
        }
        
        if( !$request->id || !$request->product_id )
            return json_encode(['response' => false]);

        if( !Product::where(['id' => $request->id, 'product_id' => $request->product_id])->first() )
            return json_encode(['response' => false]);

        $response = new Response('wishlist');

        $data = array();

        /*$cookie = Cookie::forget('wishlistProduct');
        
        $response->withCookie($cookie);
        return $response;*/



        if( $cookie = $request->cookie('wishlistProduct') ) {
            $cookieObj = json_decode( $cookie );
            foreach( $cookieObj as $coo ) {
                $data[] = $coo;
            }
        }

        if( ($key = array_search($request->product_id, $data)) !== false ) {
            unset($data[$key]);
            $data = array_values($data);
        }
        else
            array_push($data, $request->product_id);    

        $json = json_encode( $data );
        $response->withCookie( cookie()->forever('wishlistProduct', $json) );
        return $response;

        /*
        array_push($data, ['id' => $request->id, 'product_id' => $request->product_id]);

        var_dump($data);

        */
        /*if( $response )
            return json_encode(['response' => true, 'res' => $response]);
        else
            return json_encode(['response' => false, 'res' => $response]);*/

        /*$data = array();
        if( $cookie = $request->cookie('wishlistProduct') ) {
            
            
            
        }
        else {
            
        }
        $new = ['id' => $request->id, 'product_id' => $request->product_id];
        array_push($data, $new);
        var_dump( $data );*/

        //$data = ;
        //var_dump($data);

        /**/
        
        /**/

        /*$json = json_encode(  );
        
        */



        /*$response = new Response();
        $response->withCookie(cookie('wishlistProduct', $json, 45000));
        return $response;*/

        /*if( Cookie::forever('wishlistProduct', $json) )
            var_dump(withCookie(Cookie::get('wishlistProduct')));
        else
            return 'not found';*/
        //Create a response instance
        //

        //Call the withCookie() method with the response method
        //

        //return the response
        //var_dump();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
