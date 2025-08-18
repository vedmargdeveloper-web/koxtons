<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\OrderProduct;
use App\User;
use Auth;

class OrderController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');    
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if( !User::isSeller() )
            return redirect( url('/') );

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        return view('seller.order.index')->with('title', 'Orders');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if( !User::isSeller() )
            return redirect( url('/') );

        if( Auth::user()->profile !== 'completed' )
                return redirect()->route('seller.setup', Auth::user()->uid);

        $order_product = OrderProduct::find( $id );
        return view('seller.order.show')->with(['title' => 'View Order', 'order_product' => $order_product]);
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
