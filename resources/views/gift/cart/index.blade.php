@extends( _app() )

@section('content')

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
                            <span>Cart</span>
                        </nav>
                    </div>
            </div>
        </div>
    </section>
    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section class="content-page">
        <div class="container">
            
                <div class="row desktop-cart-view">

                	<div class="col-sm-12">

                        <article class="post-8">

                        <?php $cartSubTotal = 0; ?>

                        <?php $cookie = Cookie::get('customerCartProductList'); ?>

                        @if( $cookie )

                            <?php $cookieObj = json_decode($cookie); ?>

                        	@if( isset($cookieObj->token) && $cookieObj->token )

                                <?php $cartProduct = App\model\VisiterCart::where('token', $cookieObj->token)->get();?>

                                @if( $cartProduct && count( $cartProduct ) > 0 )                               


                                {!! Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'cartForm', 'class' => 'card-form']) !!}

                                    <div class="cart-product-table-wrap responsive-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product-remove"></th>
                                                    <th class="product-thumbnail"></th>
                                                    <th class="product-name">Product</th>
                                                    {{-- <th class="product-name">Color</th>
                                                    <th class="product-name">Size</th> --}}
                                                    <th class="product-price">Price</th>
                                                    <th class="product-quantity">Quantity</th>
                                                    <th class="product-subtotal">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            	@foreach( $cartProduct as $cart )

                                                <?php $variation = json_decode($cart->variations); ?>

                                                <tr>
                                                    <td class="product-remove">
                                                        <a class="product-remove" data-id="{{ $cart->product_id }}" data-value="{{ $cart->product_no }}" data-key="{{ $cart->id }}" href="javascript:void(0)">
        			                                        {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnDeleteCartItem', 'data-key' => $cart->id, 'data-value' => $cart->product_no, 'data-id' => $cart->product_id ] ) !!}
        			                                    </a>
                                                        <input type="hidden" name="key[]" value="{{ $cart->id }}">
                                                    </td>
                                                    <td class="product-thumbnail">

                                                        <a href="{{ $variation->url }}">
                                                            <img class="lazyload img-thumbnail" data-src="{{ $variation->feature_image }}" alt="{{ $variation->title }}" />
                                                        </a>
                                                    </td>
                                                    <td class="product-name">
                                                        <?php $title = $variation->variation_name ? $variation->title . ' - ' . $variation->variation_name : $variation->title; ?>
                                                        <a href="{{ $variation->url }}">{{ $title }}</a>
                                                    </td>
                                                
                                                    <td class="product-price">
                                                        <?php
                                                            $price = 0;
                                                            if( $variation->price )
                                                                $price = $variation->price;
                                                            else if( !$price )
                                                                $price = $variation->original_price;

                                                            if( $price && $variation->discount )
                                                                $price = $price - ( $price * $variation->discount ) / 100;
                                                            if( $variation->tax )
                                                                $price = $price + ( $price * $variation->tax ) / 100;
                                                        ?>
                                                        <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price = round($price) }}</span>
                                                        <input type="hidden" name="product_id[]" value="{{ $cart->product_no }}">
                                                        <input type="hidden" name="id[]" value="{{ $cart->product_id }}">
                                                    </td>
                                                    <td>
                                                        <div class="product-quantity">
                                                            <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                            <input class="quantity input-lg" step="1" min="1" max="9" name="quantity[]" value="{{ $variation->quantity }}" title="Quantity" type="number" />
                                                            <span data-value="-" class="quantity-btn quantityMinus"></span>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">
                                                        <span id="cartProductAmount-{{ $cart->product_no }}" class="product-price-sub_totle amount" data-id="">
                                                        	<span class="currency-sign"><i class="fa fa-inr"></i> </span>
                                                        	<span id="cartProductTotalAmount">{{ $amount = $variation->quantity * $price }}</span>
                                                        	<?php $cartSubTotal += $amount; ?>
                                                        </span>
                                                    </td>
                                                </tr>

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row cart-actions">
                                        <div class="col-md-6">
                                            
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <input class="btn btn-md btn-gray" id="updateCart" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div>
                                
                                {!! Form::close() !!}

                                <div class="cart-collateral">
                                    <div class="cart_totals">
                                        <h3>Cart totals</h3>
                                        <div class="responsive-table">
                                            <table>
                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Subtotal</th>
                                                        <td><span class="product-price-amount amount">
                                                        	<span class="currency-sign"><i class="fa fa-inr"></i></span>
                                                        	<span id="cartSubTotal">{{ $cartSubTotal }}</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;" class="shipping">
                                                        <th>Shipping</th>
                                                        <td>
                                                            <ul id="shipping_method">
                                                                <li>
                                                                    
                                                                	<label>
                                                                	<span class="product-price-amount amount">
                                                                        <strike>
        			                                                	<span class="currency-sign"><i class="fa fa-inr"></i></span> 
        			                                                	<span>
        			                                                		{{ $shipping_charge = App\model\Meta::Where('meta_name', 'shipping_charge')->value('meta_value') }}
        			                                                		<input type="hidden" name="shipping_charge" value="0" id="shippingCharge">
        			                                                	</span>
                                                                        </strike>
        		                                                	</span>
                                                                    </label>
                                                                    <span>You saved.</span>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr class="order-total">
                                                        <th>Total</th>
                                                        <td><span class="product-price-amount amount">
                                                            	<span class="currency-sign"><i class="fa fa-inr"></i></span>
                                                            	<span id="cartTotalAmount">{{ $cartSubTotal }}</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="product-proceed-to-checkout">
                                            <a class="btn btn-lg btn-color form-full-width" href="{{ url('checkout?s=checkout') }}">Proceed to checkout</a>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <div class="text-center">
                                        <h3>Your cart is empty</h3>
                                        <a href="{{ url('/') }}">Add products to cart</a>
                                    </div>
                                @endif

                            @else


                            <div class="text-center">
                            	<h3>Your cart is empty</h3>
                            	<a href="{{ url('/') }}">Add products to cart</a>
                            </div>
    		

                            @endif

                        @else


                        <div class="text-center">
                            <h3>Your cart is empty</h3>
                            <a href="{{ url('/') }}">Add products to cart</a>
                        </div>
        

                        @endif


                        </article>
                    </div>

                </div>



                <div class="row mobile-cart-view">
                   {{--  <div class="col-sm-12 text-center">
                        <h2>Cart</h2>
                    </div> --}}
                    <div class="col-sm-12">

                        <article class="post-8">

                        <?php $cartSubTotal = 0; ?>

                        <?php $cookie = Cookie::get('customerCartProductList'); ?>

                        @if( $cookie )

                            <?php $cookieObj = json_decode($cookie); ?>

                            @if( isset($cookieObj->token) && $cookieObj->token )

                                <?php $cartProduct = App\model\VisiterCart::where('token', $cookieObj->token)->get();?>

                                @if( $cartProduct && count( $cartProduct ) > 0 )                               


                                {!! Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'cartForm', 'class' => 'card-form']) !!}

                                    <div class="cart-product-table-wrap responsive-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product-remove">#</th>
                                                    <th class="product-thumbnail"></th>
                                                    <th class="product-name">Product</th>
                                                    {{-- <th class="product-name">Color</th>
                                                    <th class="product-name">Size</th> --}}
                                                    {{-- <th class="product-price">Price</th>
                                                    <th class="product-quantity">Quantity</th>
                                                    <th class="product-subtotal">Total</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach( $cartProduct as $cart )

                                                <?php $variation = json_decode($cart->variations); ?>

                                                <tr>
                                                    <td class="product-remove">
                                                        <a class="product-remove" data-id="{{ $cart->product_id }}" data-value="{{ $cart->product_no }}" data-key="{{ $cart->id }}" href="javascript:void(0)">
                                                            {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnDeleteCartItem', 'data-key' => $cart->id, 'data-value' => $cart->product_no, 'data-id' => $cart->product_id ] ) !!}
                                                        </a>
                                                        <input type="hidden" name="key[]" value="{{ $cart->id }}">
                                                    </td>
                                                    <td class="product-thumbnail">
                                                        <a href="{{ $variation->url }}">
                                                            <img class="lazyload img-thumbnail" data-src="{{ $variation->feature_image }}" />
                                                        </a>
                                                    </td>
                                                    <td class="product-name">
                                                        <a href="{{ $variation->url }}">{{ $variation->title }}</a>
                                                        <div class="product-price">
                                                             <?php
                                                                $price = 0;
                                                                if( $variation->price )
                                                                    $price = $variation->price;
                                                                else if( !$price )
                                                                    $price = $variation->original_price;

                                                                if( $price && $variation->discount )
                                                                    $price = $price - ( $price * $variation->discount ) / 100;
                                                                if( $variation->tax )
                                                                    $price = $price + ( $price * $variation->tax ) / 100;
                                                            ?>
                                                            <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price = round($price) }}</span>
                                                            <input type="hidden" name="product_id[]" value="{{ $cart->product_no }}">
                                                            <input type="hidden" name="id[]" value="{{ $cart->product_id }}">
                                                        </div> 
                                                        <div class="product-quanty">
                                                            <div class="product-quantity">
                                                                <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                                <input class="quantity input-lg" step="1" min="1" max="9" name="quantity[]" value="{{ $variation->quantity }}" title="Quantity" type="number" />
                                                                <span data-value="-" class="quantity-btn quantityMinus"></span>
                                                            </div>
                                                        </div>
                                                        <div class="product-subtotal">
                                                            <span id="cartProductAmount-{{ $cart->product_no }}" class="product-price-sub_totle amount" data-id="">
                                                                <span class="currency-sign"><i class="fa fa-inr"></i> </span>
                                                                <span id="cartProductTotalAmount">{{ $amount = $variation->quantity * $price }}</span>
                                                                <?php $cartSubTotal += $amount; ?>
                                                            </span>
                                                        </div>
                                                    </td>
                                                
                                                    {{-- <td class="product-price">
                                                       
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                    <td class="product-subtotal">
                                                        
                                                    </td> --}}
                                                </tr>

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row cart-actions">
                                        <div class="col-md-6">
                                            
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <input class="btn btn-md btn-gray" id="updateCart" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div>
                                
                                {!! Form::close() !!}

                                <div class="cart-collateral">
                                    <div class="cart_totals">
                                        <h3>Cart totals</h3>
                                        <div class="responsive-table">
                                            <table>
                                                <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>Subtotal</th>
                                                        <td><span class="product-price-amount amount">
                                                            <span class="currency-sign"><i class="fa fa-inr"></i></span>
                                                            <span id="cartSubTotal">{{ $cartSubTotal }}</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;" class="shipping">
                                                        <th>Shipping</th>
                                                        <td>
                                                            <ul id="shipping_method">
                                                                <li>
                                                                    
                                                                    <label>
                                                                    <span class="product-price-amount amount">
                                                                        <strike>
                                                                        <span class="currency-sign"><i class="fa fa-inr"></i></span> 
                                                                        <span>
                                                                            {{ $shipping_charge = App\model\Meta::Where('meta_name', 'shipping_charge')->value('meta_value') }}
                                                                            <input type="hidden" name="shipping_charge" value="0" id="shippingCharge">
                                                                        </span>
                                                                        </strike>
                                                                    </span>
                                                                    </label>
                                                                    <span>You saved.</span>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr class="order-total">
                                                        <th>Total</th>
                                                        <td><span class="product-price-amount amount">
                                                                <span class="currency-sign"><i class="fa fa-inr"></i></span>
                                                                <span id="cartTotalAmount">{{ $cartSubTotal }}</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="product-proceed-to-checkout">
                                            <a class="btn btn-lg btn-color form-full-width" href="{{ route('checkout') }}">Proceed to checkout</a>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <div class="text-center">
                                        <h3>Your cart is empty</h3>
                                        <a href="{{ url('/') }}">Add products to cart</a>
                                    </div>
                                @endif

                            @else


                            <div class="text-center">
                                <h3>Your cart is empty</h3>
                                <a href="{{ url('/') }}">Add products to cart</a>
                            </div>
            

                            @endif

                        @else


                        <div class="text-center">
                            <h3>Your cart is empty</h3>
                            <a href="{{ url('/') }}">Add products to cart</a>
                        </div>
        

                        @endif


                        </article>
                    </div>

                </div>
        </div>
    </section>

</div>


@endsection