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
            <div class="row">

            	<div class="col-sm-12">
                    <article class="post-8">

                    <?php $cartSubTotal = 0; ?>

                    <?php $cartProduct = Cookie::get('customerCartProductListTest'); ?>

                    @if( $cartProduct )

                        <?php $cartProduct = json_decode($cartProduct); var_dump($cartProduct); ?>

                    	@if( $cartProduct )


                        {!! Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'cartFormTest', 'class' => 'card-form']) !!}

                            <div class="cart-product-table-wrap responsive-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-remove"></th>
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-color">Color</th>
                                            <th class="product-size">Size</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                	@foreach( $cartProduct as $cart )

                                        @if( isset( $cart->variations ) && $cart->variations )
                                        <?php $variations = json_decode($cart->variations); ?>
                                        @if( $variations && count($variations) > 0 )
                                            @foreach( $variations as $key => $var )

                                            <tr>
                                                <td class="product-remove">
                                                    <a class="product-remove" data-id="{{ $cart->id }}" data-value="{{ $cart->product_id }}" href="javascript:void(0)">
        		                                        {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnDeleteCartItemTest', 'data-variation' => $var->id, 'data-value' => $cart->product_id, 'data-id' => $cart->id ] ) !!}
                                                        <input type="hidden" name="varkey" value="{{ $var->id }}">
        		                                    </a>
                                                </td>
                                                <td class="product-thumbnail">
                                                    <a href="{{ $cart->url }}">
                                                        <img class="img-thumbnail" src="{{ $cart->feature_image }}" alt="{{ $cart->title }}" />
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <a href="{{ $cart->url }}">{{ $cart->title }}</a>
                                                </td>
                                                <td class="product-price">
                                                    <?php $price = $cart->price;
                                                        if( $cart->discount )
                                                            $price = $cart->price - ( $cart->price * $cart->discount ) / 100;
                                                    ?>
                                                    <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price = round($price) }}</span>
                                                    <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
                                                    <input type="hidden" name="id[]" value="{{ $cart->id }}">
                                                </td>
                                                <td class="product-name">
                                                    {{ ucfirst($var->color) }}
                                                </td>
                                                <td class="product-name">
                                                    {{ ucwords($var->size) }}
                                                </td>
                                                <td>
                                                
                                                    <div class="product-quantity">
                                                        <input type="hidden" class="itemKey" name="itemKey[]" value="{{ $var->id }}">
                                                        <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                        <input class="quantity input-lg" step="1" min="1" max="9" name="quantity[]" value="{{ $var->quantity }}" title="Quantity" type="number" />
                                                        <span data-value="-" class="quantity-btn quantityMinus"></span>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span id="cartProductAmount-{{ $cart->product_id }}" class="product-price-sub_totle amount" data-id="">
                                                    	<span class="currency-sign"><i class="fa fa-inr"></i> </span>
                                                    	<span id="cartProductTotalAmount">{{ $amount = $var->quantity * $price }}</span>
                                                    	<?php $cartSubTotal += $amount; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach

                                        @else

                                        <tr>
                                            <td class="product-remove">
                                                <a class="product-remove" data-id="{{ $cart->id }}" data-value="{{ $cart->product_id }}" href="javascript:void(0)">
                                                    {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnDeleteCartItemTest', 'data-variation' => '', 'data-value' => $cart->product_id, 'data-id' => $cart->id ] ) !!}
                                                </a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <a href="{{ $cart->url }}">
                                                    <img class="img-thumbnail" src="{{ $cart->feature_image }}" alt="{{ $cart->title }}" />
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{ $cart->url }}">{{ $cart->title }}</a>
                                            </td>
                                            <td class="product-price">
                                                <?php $price = $cart->price;
                                                    if( $cart->discount )
                                                        $price = $cart->price - ( $cart->price * $cart->discount ) / 100;
                                                ?>
                                                <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price = round($price) }}</span>
                                                <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
                                                <input type="hidden" name="id[]" value="{{ $cart->id }}">
                                            </td>
                                            <td class="product-name">
                                                
                                            </td>
                                            <td class="product-name">
                                                
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                    <input class="quantity input-lg" step="1" min="1" max="9" name="quantity[]" value="{{ $cart->quantity }}" title="Quantity" type="number" />
                                                    <span data-value="-" class="quantity-btn quantityMinus"></span>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span id="cartProductAmount-{{ $cart->product_id }}" class="product-price-sub_totle amount" data-id="">
                                                    <span class="currency-sign"><i class="fa fa-inr"></i> </span>
                                                    <span id="cartProductTotalAmount">{{ $amount = $cart->quantity * $price }}</span>
                                                    <?php $cartSubTotal += $amount; ?>
                                                </span>
                                            </td>
                                        </tr>

                                        @endif

                                        @else

                                        <tr>
                                            <td class="product-remove">
                                                <a class="product-remove" data-id="{{ $cart->id }}" data-value="{{ $cart->product_id }}" href="javascript:void(0)">
                                                    {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnDeleteCartItemTest', 'data-variation' => '', 'data-value' => $cart->product_id, 'data-id' => $cart->id ] ) !!}
                                                </a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <a href="{{ $cart->url }}">
                                                    <img class="img-thumbnail" src="{{ $cart->feature_image }}" alt="{{ $cart->title }}" />
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{ $cart->url }}">{{ $cart->title }}</a>
                                            </td>
                                            <td class="product-price">
                                                <?php $price = $cart->price;
                                                    if( $cart->discount )
                                                        $price = $cart->price - ( $cart->price * $cart->discount ) / 100;
                                                ?>
                                                <span class="product-price-amount amount"><span class="currency-sign"><i class="fa fa-inr"></i></span> {{ $price = round($price) }}</span>
                                                <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
                                                <input type="hidden" name="id[]" value="{{ $cart->id }}">
                                            </td>
                                            <td class="product-name">
                                                
                                            </td>
                                            <td class="product-name">
                                                
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                    <input class="quantity input-lg" step="1" min="1" max="9" name="quantity[]" value="{{ $cart->quantity }}" title="Quantity" type="number" />
                                                    <span data-value="-" class="quantity-btn quantityMinus"></span>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span id="cartProductAmount-{{ $cart->product_id }}" class="product-price-sub_totle amount" data-id="">
                                                    <span class="currency-sign"><i class="fa fa-inr"></i> </span>
                                                    <span id="cartProductTotalAmount">{{ $amount = $cart->quantity * $price }}</span>
                                                    <?php $cartSubTotal += $amount; ?>
                                                </span>
                                            </td>
                                        </tr>

                                        @endif

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row cart-actions">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6 text-right">
                                    <input class="btn btn-md btn-gray" id="updateCartTest" name="update_cart" value="Update cart" type="submit">
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
                                                	<span id="cartSubTotal">{{ $cartSubTotal }}</span></td>
                                            </tr>
                                            <tr class="shipping">
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
                                                	<span id="cartTotalAmount">{{ $cartSubTotal }}</span></span>
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


                    </article>
                </div>

            </div>
        </div>
    </section>

</div>


@endsection