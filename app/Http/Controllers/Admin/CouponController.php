<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Coupon;
use Validator;
use Auth;
use Session;
use App\User;

class CouponController extends Controller
{

    public function __construct() {

        $this->middleware('admin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('coupon.index'), ['title' => 'Coupons'] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('coupon.create'), ['title' => 'Create coupon'] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        $validator = Validator::make($request->all(), [
                                'code' => 'required|max:255',
                                'discount' => 'required|numeric|max:10000',
                                'discount_type' => 'required',
                                'text' => 'max:255',
                                'start' => 'required|max:255',
                                'end' => 'required|max:255',
                                'usage_amount' => 'nullable|numeric|min:1|max:100000',
                                'usage_number' => 'nullable|numeric|min:0|max:1000',
                        ],
                        [
                                'code.required' => 'Coupon is required *',
                                'code.max' => 'Coupon can have upto 255 characters!',
                                'discount.required' => 'Discount is required *',
                                'discount.max' => 'Discount must be valid!',
                                'discount_type.required' => 'Discount type is required *',
                                'text.max' => 'Heading can have upto 255 characters!',
                                'start.required' => 'Start time is required *',
                                'start.max' => 'Start date can have upto 255 characters!',
                                'end.required' => 'End time is required *',
                                'end.max' => 'End date can have upto 255 characters!',

                                'usage_number.numeric' => 'Usage number must be numeric value!',
                                'usage_amount.numeric' => 'Usage amount must be numeric value!',

                                'usage_number.min' => 'Usage number must be minimum 1!',
                                'usage_amount.min' => 'Usage number must be minimum 1!',
                                'usage_number.max' => 'Usage number must be maximum 1000!',
                                'usage_amount.max' => 'Usage number must be maximum 100000!',
                        ]);
        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $coupon = new Coupon();
        $coupon->user_id = Auth::id();
        $coupon->code = $request->code;
        $coupon->discount = $request->discount;
        $coupon->discount_type = $request->discount_type;
        $coupon->text = $request->text;
        $coupon->content = $request->content;
        $coupon->start = $request->start;
        $coupon->end = $request->end;
        $coupon->status = $request->submit;
        $coupon->usage_amount = $request->usage_amount;
        $coupon->usage_number = $request->usage_number;
        $coupon->save();

        if( $coupon->id )
            return redirect()->route( 'coupon.edit', $coupon->id )->with('coupon_msg', 'Coupon created successfully!');

        return redirect()->back()->with('coupon_err', 'Coupon could not create!')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('coupon.show'), ['title' => 'View coupon', 'id' => $id] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        return view( _admin('coupon.edit'), ['title' => 'Edit coupon', 'id' => $id] );
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

        if( !User::isAdmin() )
            return redirect( url('/') );

        if( !Coupon::find( $id ) )
            return redirect()->back()->with('coupon_err', 'Something went wrong, coupon could not update!')->withInput();

        $validator = Validator::make($request->all(), [
                                'code' => 'required|max:255',
                                'discount' => 'required|numeric|max:10000',
                                'discount_type' => 'required',
                                'text' => 'max:255',
                                'start' => 'required|max:255',
                                'end' => 'required|max:255',
                                'usage_amount' => 'nullable|numeric|min:1|max:100000',
                                'usage_number' => 'nullable|numeric|min:0|max:1000',
                        ],
                        [
                                'code.required' => 'Coupon is required *',
                                'code.max' => 'Coupon can have upto 255 characters!',
                                'discount.required' => 'Discount is required *',
                                'discount.max' => 'Discount must be valid!',
                                'discount_type.required' => 'Discount type is required *',
                                'text.max' => 'Heading can have upto 255 characters!',
                                'start.required' => 'Start time is required *',
                                'start.max' => 'Start date can have upto 255 characters!',
                                'end.required' => 'End time is required *',
                                'end.max' => 'End date can have upto 255 characters!',

                                'usage_number.numeric' => 'Usage number must be numeric value!',
                                'usage_amount.numeric' => 'Usage amount must be numeric value!',

                                'usage_number.min' => 'Usage number must be minimum 1!',
                                'usage_amount.min' => 'Usage number must be minimum 1!',
                                'usage_number.max' => 'Usage number must be maximum 1000!',
                                'usage_amount.max' => 'Usage number must be maximum 100000!',
                        ]);

        if( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $array = array(
                        'user_id' => Auth::id(),
                        'code' => $request->code,
                        'discount' => $request->discount,
                        'discount_type' => $request->discount_type,
                        'text' => $request->text,
                        'content' => $request->content,
                        'start' => $request->start,
                        'end' => $request->end,
                        'status' => $request->submit,
                        'usage_amount' => $request->usage_amount,
                        'usage_number' => $request->usage_number
                    );

        if( Coupon::where('id', $id)->update($array) )
            return redirect()->back()->with('coupon_msg', 'Coupon updated successfully!');

        return redirect()->back()->with('coupon_err', 'Coupon could not update!')->withInput();
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( !User::isAdmin() )
            return redirect( url('/') );

        if( !Coupon::where( 'id', $id )->delete() )
            return redirect()->back()->with('coupon_err', 'Something went wrong, coupon could not delete!');

        return redirect()->back()->with('coupon_msg', 'Coupon deleted!');
    }


    public function status( Request $request )
    {
        if( !User::isAdmin() )
            return redirect( url('/') );
        
        if( !Coupon::where( 'id', $request->id )->update(['status' => $request->status]) )
            return redirect()->back()->with('coupon_err', 'Something went wrong, status could not update!');

        return redirect()->back()->with('coupon_msg', 'Status updated!');
    }
}
