<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Review;
use App\model\Product;
use App\User;
use Auth;
use App\model\LogsModel;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {

        // $this->middleware('admin');
    }
    
    public function index() {
        // if( !User::isAdmin() )
        //     return redirect( url('login') );

        $reviews = Review::with(['product.product_category'])->orderby('id', 'DESC')->get();

        return view( _admin('reviews.index'), ['reviews' => $reviews, 'title' => 'Reviews'] );
    }

    public function delete( $id ) {
        // if( !User::isAdmin() )
        //     return redirect( url('login') );

        Review::where('id', $id)->delete();
    LogsModel::create(['user_id' => Auth::id(),'remark'=>'Review Delete','status'=>'review', 'working_id' => $id]);

        return redirect()->back()->with('review_success', 'Review successfully deleted!');
    }

    public function product_review( $product_id ) {

        // if( !User::isAdmin() )
        //     return redirect( url('login') );

        $product = Product::find( $product_id );
        if( !$product )
            return redirect()->back()->with('review_success', 'Review not found!');


        //Product::with('review')->where('id', $product_id)->first();

        $reviews = Review::where('product_id', $product->product_id)->orderby('id', 'DESC')->get();


        return view( _admin('reviews.index'), ['product' => $product, 'reviews' => $reviews, 'title' => 'Product Reviews'] );
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
