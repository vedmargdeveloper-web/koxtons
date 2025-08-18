@extends( _app() )

@section('content')


<?php $oldOrder = false; ?>

@if( Auth::check() )
    <?php $oldOrder = App\model\OrderCustomer::where('user_id', Auth::id())->orderby('id', 'DESC')->first(); ?>
@else
    <script type="text/javascript">
        $(document).ready(function(e){
            window.location.href= $('.back-url-span').attr('title');
        });
    </script>
@endif


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="">
        <div class="container">
                <div class="row">
                    <div class="col-12 mt-10">
                         <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                              <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                             <span style="margin: 0 5px;">&raquo;</span>
                            <span>Checkout</span>
                        </nav>
                    </div>
                </div>
        </div>
    </section>
    <!-- Bread Crumb -->
<span style="display:none" title="{{url('/login?back='.current_url()) }}" class="back-url-span"></span>
    <!-- Page Content -->
    <section class="content-page">
        <div class="container mb-80">
                <div class="row checkout">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3 class="title">Checkout</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <article class="post-8">
                        @if( Session::has('order_err') )
                            <span class="text-danger">{{ Session::get('order_err') }}</span>
                        @endif

                        @auth
                        @else
                            <p class="checkout-info">
                                Already customer? <strong><a href="{{ url('/login?back='.urlencode(current_url())) }}">Click here to Login</a></strong>
                            </p>
                            <p class="checkout-info">
                                Not a customer  yet? <strong><a href="{{ url('/register') }}">Click here to Sign Up</a></strong>
                            </p>
                        @endauth

                        <?php  

                        if(isset($_GET['s'])){
                            \Cookie::queue(Cookie::forget('customerCartProductList_buynow'));  
                        }

                        
                        $cookie  = Cookie::get('customerCartProductList_buynow') ? Cookie::get('customerCartProductList_buynow') : Cookie::get('customerCartProductList');
                            
                        ?>

                        <?php //$cookie = Cookie::get('customerCartProductList'); ?>

                        @if( $cookie )
                            <?php $cookieObj = json_decode($cookie); ?>

                            @if( $cookieObj && isset( $cookieObj->token ) )

                            <?php $cartProduct = App\model\VisiterCart::where('token', $cookieObj->token)->get();?>

                                @if( $cartProduct && count( $cartProduct ) > 0 )

                                <form class="product-checkout" enctype="Multipart/form-data" action="{{ route('order.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    @if( $errors && count( $errors ) || Session::has('pincode') )
                                        <div class="alert alert-warning error">
                                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            <strong class="fa fa-warning"></strong> Fix all the errors.
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Billing details</h5>
                                            <div class="row">
                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <label for="first_name" class="left">
                                                        Name
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    <?php $first_name = '';
                                                        if( old('first_name') )
                                                            $first_name = old('first_name');
                                                        elseif( isset( $oldOrder->first_name ) )
                                                            $first_name = $oldOrder->first_name;
                                                        elseif( Auth::check() )
                                                            $first_name = Auth::user()->first_name;
                                                    ?>
                                                    <input class="input-md form-full-width" name="first_name" value="{{ $first_name }}" placeholder="Name" type="text" required="" aria-required="true">
                                                    @if( $errors->has('first_name') )
                                                        <span class="text-danger pull-left">{{ $errors->first('first_name') }}</span>
                                                    @endif                                                    
                                                </div>

                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $email = '';
                                                        if( old('email') )
                                                            $email = old('email');
                                                        elseif( isset( $oldOrder->email ) )
                                                            $email = $oldOrder->email;
                                                        elseif( Auth::check() )
                                                            $email = Auth::user()->email;
                                                    ?>
                                                    <label for="email" class="left">
                                                        Email
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('email') )
                                                        <span class="text-danger pull-left">{{ $errors->first('email') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width input-email-check" name="email" value="{{ $email }}" placeholder="Enter Email" type="email" required="" aria-required="true">
                                                </div>

                                                <div class="form-field-wrapper form-center col-sm-6" style="display: none;">
                                                    <label for="last_name" class="left">
                                                        Last Name
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    <?php $last_name = '';
                                                        if( old('last_name') )
                                                            $last_name = old('last_name');
                                                        elseif( isset( $oldOrder->last_name ) )
                                                            $last_name = $oldOrder->last_name;
                                                        elseif( Auth::check() )
                                                            $last_name = Auth::user()->last_name;
                                                    ?>
                                                    <input class="input-md form-full-width" name="last_name" value="{{ $last_name }}" placeholder="Last Name" type="text" aria-required="true">
                                                    @if( $errors->has('last_name') )
                                                        <span class="text-danger pull-left">{{ $errors->first('last_name') }}</span>
                                                    @endif
                                                    
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $mobile = '';
                                                        if( old('mobile') )
                                                            $mobile = old('mobile');
                                                        elseif( isset( $oldOrder->mobile ) )
                                                            $mobile = $oldOrder->mobile;
                                                    ?>
                                                    <label for="mobile" class="left">
                                                        Mobile no.
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('mobile') )
                                                        <span class="text-danger pull-left">{{ $errors->first('mobile') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width" name="mobile" value="{{ $mobile }}" placeholder="Ex: 9876543210" type="tel" required="" aria-required="true">
                                                </div>

                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $alternate = '';
                                                        if( old('alternate') )
                                                            $alternate = old('alternate');
                                                        elseif( isset( $oldOrder->alternate ) )
                                                            $alternate = $oldOrder->alternate;
                                                    ?>
                                                    <label for="alternate" class="left">Alternate no.</label>
                                                    @if( $errors->has('alternate') )
                                                        <span class="text-danger pull-left">{{ $errors->first('alternate') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width" name="alternate" value="{{ $alternate }}" placeholder="Ex: 9876543210" type="tel">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-field-wrapper form-center col-sm-12" style="display: none;">
                                                    <?php
                                                        $country = 101;
                                                        if( old('country') )
                                                            $country = old('country');
                                                        elseif( isset( $oldOrder->country ) )
                                                            $country = App\model\Country::where('name', $oldOrder->country)->value('id');
                                                    ?>
                                                    <label for="tdcountry" class="left">
                                                        County
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('country') )
                                                        <span class="text-danger pull-left">{{ $errors->first('country') }}</span>
                                                    @endif
                                                    <select name="country" id="tdcountry" class="input-md form-full-width" autocomplete="country" tabindex="-1" aria-hidden="true" aria-required="true">
                                                        <option value="">Select</option>
                                                        <?php $countries = App\model\Country::all(); ?>
                                                        @if( $countries && count( $countries ) )
                                                            @foreach( $countries as $row )
                                                                <option {{ $row->id == $country ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-field-wrapper form-center col-sm-12">
                                                    <?php
                                                        $address = '';
                                                        if( old('address') )
                                                            $address = old('address');
                                                        elseif( isset( $oldOrder->address ) )
                                                            $address = json_decode($oldOrder->address);
                                                    ?>
                                                    <label for="address" class="left">
                                                        Address
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('address.0') )
                                                        <span class="text-danger pull-left">{{ $errors->first('address.0') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width mb-20" name="address[]" value="{{ isset($address[0]) ? $address[0] : '' }}" placeholder="Street Address" type="text" aria-required="true">
                                                    
                                                    @if( $errors->has('address.1') )
                                                        <span class="text-danger pull-left">{{ $errors->first('address.1') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width" name="address[]" value="{{ isset($address[1]) ? $address[1] : '' }}" placeholder="Apartment, suite, unit etc. (optional)" type="text" aria-required="true">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $city = '';
                                                        if( old('city') )
                                                            $city = old('city');
                                                        elseif( isset( $oldOrder->city ) )
                                                            $city = $oldOrder->city;
                                                    ?>
                                                    <label for="billing_town_city" class="left">
                                                        Town / City
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('city') )
                                                        <span class="text-danger pull-left">{{ $errors->first('city') }}</span>
                                                    @endif
                                                    <input type="text" name="city" class="input-md form-full-width" autocomplete="city" tabindex="-1" value="{{ $city }}" aria-hidden="true" required="" aria-required="true">
                                                </div>

                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $state = '';
                                                        if( old('state') )
                                                            $state = old('state');
                                                        elseif( isset( $oldOrder->state ) )
                                                            $state = App\model\State::where('name', $oldOrder->state)->value('id');
                                                    ?>
                                                    <label for="tdstate" class="left">
                                                        State
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('state') )
                                                        <span class="text-danger pull-left">{{ $errors->first('state') }}</span>
                                                    @endif
                                                    <select name="state" id="tdstate" class="input-md form-full-width" aut
                                                    ocomplete="state" tabindex="-1" aria-hidden="true" required="" aria-required="true">
                                                        <option value="{{ $state }}">Select</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $pincode = '';
                                                        if( old('pincode') )
                                                            $pincode = old('pincode');
                                                        elseif( isset( $oldOrder->pincode ) )
                                                            $pincode = $oldOrder->pincode;
                                                    ?>
                                                    <label for="pincode" class="left">
                                                        Postcode / ZIP
                                                        <abbr class="form-required" title="required">*</abbr></label>
                                                    @if( $errors->has('pincode') )
                                                        <span class="text-danger pull-left">{{ $errors->first('pincode') }}</span>
                                                    @endif
                                                    @if( Session::has('pincode') )
                                                        <span class="text-danger pull-left">{{ Session::get('pincode') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width" id="tdpincode" name="pincode" value="{{ $pincode }}" placeholder="" type="text" required="" aria-required="true">
                                                </div>


                                                <div class="form-field-wrapper form-center col-sm-6">
                                                    <?php
                                                        $gst_no = '';
                                                        if( old('gst_no') )
                                                            $gst_no = old('gst_no');
                                                        elseif( isset( $oldOrder->gst_no ) )
                                                            $gst_no = $oldOrder->gst_no;
                                                    ?>
                                                    <label for="gst_no" class="left">
                                                        GST Claim</label>
                                                    @if( $errors->has('gst_no') )
                                                        <span class="text-danger pull-left">{{ $errors->first('gst_no') }}</span>
                                                    @endif
                                                    <input class="input-md form-full-width" name="gst_no" value="{{ $gst_no }}" placeholder="GST No." type="text" aria-required="true">
                                                </div>
                                            </div>

                                            <div class="row">
                                                @auth
                                                @else                                        
                                                <div class="form-field-wrapper form-center col-sm-12">
                                                    <label for="create_account" class="left">
                                                        <input id="create_account" {{ old('createaccount') ? 'checked' : '' }} class="" name="createaccount" value="1" type="checkbox" />
                                                        <span>Create an account?</span></label>
                                                </div>
                                                @endauth
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Remark</label>
                                                <textarea class="form-control" name="remarks" style="height:44px;">{{ old('remarks') }}</textarea>
                                                @if( $errors->has('remarks') )
                                                    <span class="text-warning">{{ old('remarks') }}</span>
                                                @endif
                                            </div>
                                            <div style="display: none;" class="form-group">
                                                <label>File (You can attach an image (size upto 1MB) for any customization)</label>
                                                <input type="file" name="file">
                                                @if( $errors->has('file') )
                                                    <span class="text-warning">{{ old('file') }}</span>
                                                @endif
                                            </div>
                                            <div class="checkout-order-review">
                                                <h3>Your order</h3>
                                                <div class="product-checkout-review-order">
                                                    <div class="responsive-table">
                                                        <table class="">
                                                            <thead>
                                                                <tr>
                                                                    <th class="product-name">Product</th>
                                                                    <th class="product-total">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $total = 0; $shipping_charge = 0;  ?>
                                                            

                                                            @foreach( $cartProduct as $cart )
                                                            <?php $variation = json_decode($cart->variations); ?>
                                                                <tr class="cart_item">
                                                                    <?php $title = $variation->variation_name ? $variation->title . ' - ' . $variation->variation_name : $variation->title; ?>

                                                                    <td class="product-name">{{ $title }}<strong> x {{ $variation->quantity }}</strong></td>
                                                                    <td class="product-total">
                                                                    <?php $price = $variation->price;
                                                                    if( $variation->shipping_charge )
                                                                        $shipping_charge += $variation->shipping_charge;
                                                                    if( !$price )
                                                                        $variation->original_price;
                                                                    if( $variation->discount )
                                                                        $price = $price - ( $price * $variation->discount ) / 100;
                                                                    if( $variation->tax )
                                                                        $price = $price + ( $price * $variation->tax ) / 100;

                                                                    $price = round($price);
                                                                    ?>
                                                                        <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price * $variation->quantity }}</span>
                                                                        <?php $total += $price * $variation->quantity; ?>
                                                                    </td>
                                                                    <input type="hidden" name="product_id[]" value="{{ $cart->product_no }}">
                                                                </tr>
                                                            @endforeach

                                                                <tr class="cart-subtotal">
                                                                    <th>Subtotal</th>
                                                                    <td>
                                                                        <strong><span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $total }}</span></strong>
                                                                    </td>
                                                                </tr>
                                                            
                                                            </tbody>
                                                            <tfoot>
                                                                
                                                                <?php //$shipping_charge = App\model\Meta::where('meta_name', 'shipping_charge')->value('meta_value'); ?>
                                                                @if( $shipping_charge )
                                                                    <tr class="shipping">
                                                                        <th>Shipping</th>
                                                                        <td>
                                                                            <ul id="shipping_method">
                                                                                <li>
                                                                                    <label for="shipping_method_0_legacy_flat_rate">Flat Rate: 
                                                                                        <span class="woocommerce-Price-amount amount">
                                                                                        
                                                                                        <span class="shipping-charge woocommerce-Price" data-shipping="{{ $shipping_charge }}">
                                                                                            <i class="fa fa-inr"></i> 
                                                                                            {{ $shipping_charge }}
                                                                                        </span>

                                                                                        </span>
                                                                                        
                                                                                    </label>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <?php $total = $total + $shipping_charge; ?>

                                                                <?php $membershipAmount = 3000; ?>

                                                                @if( !App\User::isMember() )
                                                                <tr style="display: none;">
                                                                    <td style="padding:0;text-align:right;font-weight:600;">+</td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <th class="text-left"> 
                                                                        <input {{ $total < 7000 ? 'disabled' : '' }} {{ old('membership') ? 'checked' : '' }} id="{{ $total < 7000 ? '' : 'membership' }}" type="checkbox" name="membership" value="1" data-value="{{ $membershipAmount }}">
                                                                         <label style="display:inline-block;margin:0;" for="membership"><storng><a href="{{ url('membership') }}">Membership Kit</a></storng></label>
                                                                         @if( $total < 7000 )
                                                                         <p>You can join our membership if you shopping with <i class="fa fa-inr"></i> 7000 or more</p>
                                                                         @endif
                                                                     </th>
                                                                    <td class="text-right"><i class="fa fa-inr"></i> {{ $membershipAmount }}</td>
                                                                </tr>
                                                                @endif

                                                                <tr id="orderTotal" class="order-total">
                                                                    <th>Total<span class="font-12">(Inc gst)</span></th>
                                                                    <td>
                                                                        <span id="checkoutTotalAmount" class="product-price-amount amount">
                                                                        <i class="fa fa-inr"></i> {{ $total }}</span>
                                                                        <input type="hidden" id="totalCartAmount0" name="totalAmount" value="{{ $total }}">
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <div class="form-group">
                                                            <label>Have a coupon?</label>
                                                            <div class="input-group coupon-input-group">
                                                                <input name="c_coupon" id="inputCoupon" class="form-control" placeholder="" type="text">
                                                                {{-- <div class="input-group-append">
                                                                    <button type="button" id="applyCoupon" class="btn btn-primary btn-dark" name="Check">Apply</button>
                                                                </div> --}}
                                                            </div>
                                                            @if( Session::has('coupon') )
                                                                <span class="text-danger pull-left">{{ Session::get('coupon') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if( $errors->has('payment_method') )
                                                        <span class="text-danger">{{ $errors->first('payment_method') }}</span>
                                                    @endif
                                                    <div class="product-checkout-payment">
                                                        @if( $errors->has('wallet') )
                                                            <p class="text-danger pull-left">{{ $errors->first('wallet') }}</p>
                                                        @endif
                                                        <ul>
                                                             <li>
                                                                <input class="payment_method_cod" data-title="pay-with-upi" checked="" id="payment_method_cc3"  name="payment_method" value="razorpay" type="radio" />
                                                                <label for="payment_method_cc3" class="display-content netbanking-pic">Pay with 
                                                                    <img src="{{asset('assets/img/upi.png')}}" alt="UPI" class="width-75"> <img src="{{asset('assets/img/paytm-online.png')}}" alt="Paytm" class="width-75"><img src="{{asset('assets/img/amazonpe.png')}}" alt="Amazon Pay" class="width-75"><img src="{{asset('assets/img/phonepe.png')}}" alt="PhonePe" class="width-75">
                                                                    
                                                                </label>
                                                            </li>

                                                            <li class="display--block payment-text-li type-upi">
                                                                <div class="content-payment">
                                                                    <p>Pay with any (UPI, PayTm, Amazon, PhonePe etc)</p>
                                                                </div>
                                                            </li>
                                                            {{-- <li>
                                                                <input class="payment_method_cod" id="payment_method_cc"  name="payment_method" data-title="online-payment" value="razorpay" type="radio" />
                                                                <label for="payment_method_cc" class="display-content netbanking-pic"> Pay with Paytm <img src="{{asset('assets/img/paytm-online.png')}}" alt="" class="width-75"></label>
                                                            </li>
                                                            <li class="display--none payment-text-li type-onlinepayment">
                                                                <div class="content-payment">
                                                                    <p>Pay online through net banking, cards, UPI or wallets.</p>
                                                                </div>
                                                            </li> --}}
                                                            <li>
                                                                <input class="payment_method_cod" data-title="net-banking" id="payment_method_cc1"  name="payment_method" value="razorpay" type="radio" />
                                                                <label for="payment_method_cc1">Net Banking</label>
                                                            </li>

                                                            <li class="display--none payment-text-li type-netbanking">
                                                                <div class="content-payment">
                                                                    <p>Pay via various net banking, all major banks available </p>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <input class="payment_method_cod" data-title="credit-card" id="payment_method_cc2"  name="payment_method" value="razorpay" type="radio" />
                                                                <label for="payment_method_cc2" class="display-content netbanking-pic"  >Credit & Debit Card <img src="{{asset('assets/img/netbanking-picture.png')}}" alt="Net Banking"> </label>
                                                            </li>
                                                            <li class="display--none payment-text-li type-card">
                                                                <div class="content-payment">
                                                                    <p>Pay with credit or debit cards</p>
                                                                </div>
                                                            </li>

                                                           
                                                             

                                                            {{-- @if( Request::get('dev') )
                                                                <li>
                                                                    <input  data-title="pay-with-upi"   name="payment_method" value="razorpay" type="radio" />
                                                                    Razorpay
                                                                </li>
                                                            @endif --}}


                                                            <?php  $td_product = array(); ?>
                                                            <?php  $td_product_payment = array(); ?>
                                                            @foreach( $cartProduct as $cart )
                                                                <?php $td_product[] = $cart->product_no; ?>
                                                            @endforeach
                                                            <?php $check_payment = App\model\Product::select('payment_option')->whereIn('product_id',$td_product)->get(); ?>


                                                            @foreach( $check_payment as $key )
                                                                <?php $td_product_payment[] = $key->payment_option; ?>
                                                            @endforeach

                                                            @if (in_array("cod", $td_product_payment))
                                                                <li>
                                                                    <input class="payment_method_cod" id="payment_method_cod" name="payment_method" value="cod" type="radio" />
                                                                    <label for="payment_method_cod">
                                                                        Cash On Delivery
                                                                    </label>
                                                                </li>
                                                            @endif

                                                            

                                                        </ul>
                                                        <?php $coupon = App\model\MemberCoupon::where(['user_id' => Auth::id(), 'status' => 'active'])->first(); ?>
                                                        @if( $coupon && $total > 500 )
                                                            @if( $coupon->left_amount > 0 )
                                                                <p>You have Rs. {{ $coupon->left_amount }} coupon, if you use it 10% will be less from your amount.
                                                                </p>
                                                                <div class="simple-checkbox">
                                                                    <p>
                                                                        <input type="checkbox"  id="use_coupon" name="use_coupon" value="1"> 
                                                                        <label for="use_coupon" class="checkbox bmcoupon-apply">Use this coupon.</label>
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if( $errors->has('accept') )
                                                            <span class="text-danger pull-left">{{ $errors->first('accept') }}</span>
                                                        @endif
                                                        <div class="place-order">
                                                            <button class="btn btn-lg btn-color form-full-width">Place Order</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @else

                                    <div class="text-center">
                                        <h4>Your cart is empty</h4>
                                    </div>

                                @endif
                            @else
                                <div class="text-center">
                                    <h4>Your cart is empty</h4>
                                </div>
                            @endif
                        @else
                            <div class="text-center">
                                <h4>Your cart is empty</h4>
                            </div>
                        @endif
                        </article>
                    </div>
                </div>
        </div>

    </section>
    <!-- End Page Content -->

</div>

@endsection