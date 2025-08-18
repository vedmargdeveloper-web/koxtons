<!DOCTYPE html>
<html>
<head>
    <?php 
        $app_name = config('app.name'); // App\model\Meta::where('meta_name', 'app_name')->value('meta_value');
     ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{ isset( $title ) ? $title : $app_name }}</title>
    <meta content="" property="og:image"/>
    <meta name="description" content="@yield('og-content')" />
    <meta name="keywords" content="@yield('og-keywords')">
    <meta name="author" content="{{ $app_name }}" />
    <base href="{{ url('/') }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/assets/images/lgoo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/assets/images/lgoo.png') }}">

    <meta property="og:url" content="{{ asset('public/assets/images/lgoo.png') }}" />
    <meta property="og:type" content="@yield('og-type')" />
    <meta property="og:title" content="@yield('og-title')" />
    <meta property="og:description" content="@yield('og-content')" />
    <meta property="og:image" content="{{ asset('public/assets/images/lgoo.png') }}" />
    
    {{-- AM code --}}

    <!-- CSS -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
    <!-- bootstrap css -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> --}}
    <!-- fontawesome css -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.0/animate.min.css" rel="stylesheet" type="text/css" /> --}}
    <!-- animate css -->
    <link href="{{ asset('assets/css/design.min.css?v='.time()) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.min.css?v='.time()) }}" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="{{ asset('public/styles/vendor/perfect-scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/chosen/chosen.min.css') }}"> -->
    
    {{-- <link href="{{ asset('assets/plugins/rev_slider/css/settings-ver.5.3.1.css') }}" rel="stylesheet" type="text/css" /> --}}
    <!-- template css -->
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}



    {{-- AM code --}}



    {{-- MR code --}}

    <script src="{{ asset('assets/catalog/view/javascript/jquery/jquery-2.1.1.min.js')}}"></script>
        <link href="{{ asset('assets/catalog/view/javascript/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="screen" />
        <script src="{{ asset('assets/catalog/view/javascript/bootstrap/js/bootstrap.min.js')}}"></script>
        <link href="{{ asset('assets/catalog/view/javascript/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
        <script src="{{ asset('assets/catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/jquery.elevateZoom.min.js')}}"></script>

     
        <link href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/mahardhi-font.css')}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/animate.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.carousel.min.css')}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.theme.default.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/catalog/view/javascript/jquery/magnific/magnific-popup.css')}}" />

        
        <style>
            :root {
                --primary-color: #222222;
                --primary-hover-color: #df2121;
                --secondary-color: #ffffff;
                --secondary-light-color: #777777;
                --background-color: #f5f5f5;
                --border-color: #ebebeb;
            }
           
        </style>
        <link href="{{ asset('assets/catalog/my.css?v='.time())}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/koxton.css?v='.time())}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/stylesheet.css?v='.time())}}" rel="stylesheet" />
        <link href="{{ asset('assets/catalog/view/javascript/jquery/swiper/css/swiper.min.css')}}" type="text/css" rel="stylesheet" media="screen" />
        <link href="{{ asset('assets/catalog/view/javascript/jquery/swiper/css/opencart.css')}}" type="text/css" rel="stylesheet" media="screen" />
        <script src="{{ asset('assets/catalog/view/javascript/jquery/swiper/js/swiper.jquery.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/tabs.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/countdown.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/jquery.cookie.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/common.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('assets/catalog/view/javascript/mahardhi/custom.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/jquery-ui.min.css')}}" />
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <link href="{{ asset('assets/image/catalog/cart.png')}}" rel="icon" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lg-fb-comment-box.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lg-transitions.min.css" />

        



<style type="text/css">
     .loader-- {
                background: url("{{asset('assets/catalog/view/theme/mahardhi/image/mahardhi/ajax_loader.gif')}}") 50% 50% no-repeat rgb(255,255,255);
                opacity: 1;
            }
</style>


    


    {{-- MR code --}}







    
    <!-- Slider Revolution Css Setting -->

    <?php echo App\model\Meta::where('meta_name', 'analytics')->value('meta_value'); ?>

</head>
<body>
<div class="loader--"></div>


    <?php $agent = new Jenssegers\Agent\Agent(); ?>
    <?php
        $site_logo = App\model\Meta::where('meta_name', 'app_logo')->value('meta_value');
        $footer_logo = App\model\Meta::where('meta_name', 'footer_logo')->value('meta_value');
        $site_name = $app_name; //App\model\Meta::where('meta_name', 'app_name')->value('meta_value');
    ?>

    <!-- Sidebar Menu (Cart Menu) -->
    <section id="sidebar-right" class="sidebar-menu sidebar-right">
        <div class="cart-sidebar-wrap">

            <!-- Cart Headiing -->
            <div class="cart-widget-heading">
                <h4>Shopping Cart</h4>
                <!-- Close Icon -->
                <a href="javascript:void(0)" id="sidebar_close_icon" class="close-icon-white"></a>
                <!-- End Close Icon -->
            </div>
            <!-- End Cart Headiing -->

            <!-- Cart Product Content -->
            <div class="cart-widget-content">
                <div class="cart-widget-product ">

                    <!-- Empty Cart -->
                    <div class="cart-empty">
                        <p>You have no items in your shopping cart.</p>
                    </div>
                    <!-- EndEmpty Cart -->

                    <!-- Cart Products -->
                    <?php $cookie = Cookie::get('customerCartProductList'); $cart_count = 0; $totalAmount = 0;?>

                    <ul class="cart-product-item" id="cartProductItemList">
                    
                    
                    @if( $cookie )
                        <?php $cookieObj = json_decode($cookie); ?>
                        @if( isset( $cookieObj->token ) && $cookieObj->token )

                            <?php $cartProduct = App\model\VisiterCart::where('token', $cookieObj->token)->get();
                            $cart_count = count( $cartProduct ); ?>

                            @foreach( $cartProduct as $cart )
                                <?php $variation = json_decode($cart->variations); ?>
                                <?php $price = isset($variation->price) ? $variation->price : '';
                                    if( isset($variation->discount) && $variation->discount )
                                        $price = $price - ( $price * $variation->discount ) / 100;

                                    if( $variation->tax ) {
                                        $price = $price + ( $price * $variation->tax / 100 );
                                    }

                                    $price = round( $price );
                                ?>

                            <?php $totalAmount += isset($variation->quantity) ? $variation->quantity * $price : $price; ?>

                            <li>
                                <a href="{{ isset($variation->url) ? $variation->url : '#' }}" class="product-image">
                                    <img src="{{ isset($variation->feature_image) ? $variation->feature_image: '' }}" alt="{{ isset($variation->title) ? $variation->title : '' }}" />
                                </a>
                                <div class="product-content">
                                    <a class="product-link" href="{{ isset($variation->url) ? $variation->url : '#' }}">{{ isset($variation->title) ? $variation->title : '' }}</a>
                                    <div class="cart-collateral">
                                        <span class="qty-cart">{{ isset($variation->quantity) ? $variation->quantity : '' }}</span>&nbsp;<span>&#215;</span>&nbsp;<span class="product-price-amount">
                                            <span class="currency-sign"><i class="fa fa-inr"></i> 
                                            </span> {{ $price }} 
                                        </span>
                                    </div>
                                    <a class="product-remove" data-id="{{ isset($cart->product_id) ? $cart->product_id : '' }}" data-value="{{ isset($cart->product_no) ? $cart->product_no : '' }}" href="javascript:void(0)">
                                        {!! Form::open(['method' => 'DELETE', 'id' => 'removeItemFromCart', 'action' => ['CartController@destroy', isset($cart->product_no) ? $cart->product_no : '' ]]) !!}
                                        {!! Form::button( '<i class="fa fa-trash fa-lg"></i>', ['type' => 'submit', 'class' => 'delete text-danger deleteProduct','id' => 'btnRemoveCartItem', 'data-key' => isset($cart->id)?$cart->id:'', 'data-value' => isset($cart->product_no) ? $cart->product_no : '', 'data-id' => isset($cart->product_id) ? $cart->product_id : '' ] ) !!}
                                        {!! Form::close() !!}
                                    </a>
                                </div>
                            </li>

                            @endforeach

                        @endif

                    @endif

                    </ul>
                    <!-- End Cart Products -->

                </div>
            </div>
            <!-- End Cart Product Content -->

            <!-- Cart Footer -->
            <div class="cart-widget-footer">
                <div class="cart-footer-inner">

                    <!-- Cart Total -->
                    <h4 class="cart-total-hedding normal"><span>Total :</span>
                        <span class="cart-total-price">
                            <span class="fa fa-inr"></span> <span id="cartTotalPrice">{{ $totalAmount }}</span>
                        </span>
                    </h4>
                    <!-- Cart Total -->

                    <!-- Cart Buttons -->
                    <div class="cart-action-buttons">
                       
                        <a target="_blank" href="{{ url('checkout?s=checkout') }}" style="    background: #e31f23 !important;color: #fff !important;" class="checkout btn btn-md btn-color">Checkout</a>
                         <a href="{{ route('cart') }}" style="background: #fff !important;color: #000 !important; border: 1px solid #000000;" class="view-cart btn btn-md btn-color">View Cart</a>
                    </div>
                    <!-- End Cart Buttons -->

                </div>
            </div>
            <!-- Cart Footer -->
        </div>
    </section>
    <!--Overlay-->
    <div class="sidebar_overlay" style="display: none;"></div>
    <!-- End Sidebar Menu (Cart Menu) -->


    <?php
        $facebook = App\model\Meta::where('meta_name', 'facebook')->value('meta_value');
        $twitter = App\model\Meta::where('meta_name', 'twitter')->value('meta_value');
        $google_plus = App\model\Meta::where('meta_name', 'google_plus')->value('meta_value');
        $instagram = App\model\Meta::where('meta_name', 'instagram')->value('meta_value');
    ?>

    <!--==========================================-->
    <!-- wrapper -->
    <!--==========================================-->
    <div class="wraper" id="main--">


           <!-- Header -->
        <header class="header" style="display: none;">

            <?php $categories = App\model\Category::all(); ?>

            <!-- Header Container -->
            <div id="header-sticky" class="header-main">
                <div class="container header-main-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 logo-nav">
                            <div style="" class="logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('public/'. public_file( $site_logo ) ) }}" alt="{{ $site_name }}" />
                                </a>
                            </div>
                        </div>

                        <?php $category = Input::has('cat') ? Input::get('cat') : ''; ?>
                        <?php $string = Input::has('s') ? Input::get('s') : ''; ?>
                        <?php $cat = false; ?>

                        @if( $categories && count( $categories ) > 0 )
                            <?php $cat = $categories->where('slug', $category)->first(); ?>
                        @endif

                        <div class="col-lg-7 col-md-11 col-sm-11 col-xs-12 search-form-nav">
                            <form class="search-menu" action="{{ url('/') }}">
                                <div class="input-group">
                                    <div class="input-group-append category">
                                        @if( $cat )
                                            <a role="button" class="btn btn-category">{{ $cat->name }} <span class="fa fa-angle-down"></span></a>
                                        @else
                                            <a role="button" class="btn btn-category">Category <span class="fa fa-angle-down"></span></a>
                                        @endif
                                        <input type="hidden" name="cat" value="">
                                        <ul class="dropdown-menu dropdown-category">
                                            @if( $categories && count( $categories ) > 0 )
                                                @foreach( $categories as $row )
                                                    @if( !$row->parent )
                                                        <li class="{{ $categories->where('parent', $row->id)->first() ? 'has-children' : '' }} {{ $agent->isMobile() ? ' mobile' : '' }}">
                                                            <a role="button" class=" {{ $categories->where('parent', $row->id)->first() ? 'item-parent' : '' }}" data-label="{{ $row->name }}" data-value="{{ $row->slug }}">{{ ucwords($row->name) }} 
                                                            </a>
                                                            
                                                            @if( $agent->isMobile() )
                                                                <span class="mobile plus-sign"></span>
                                                            @endif

                                                            @if( $categories->where('parent', $row->id)->first() )
                                                                <ul class="dropdown-menu">
                                                                    @foreach( $categories as $cat )
                                                                        @if( $cat->parent == $row->id )
                                                                            <li>
                                                                                <a data-label="{{ $cat->name }}" data-value="{{ $cat->slug }}" role="button">{{ ucwords($cat->name) }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <input type="text" name="s" value="{{ $string }}" placeholder="Search! what are you looking..." class="form-control">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 right-nav">
                            <ul class="list-top-right">
                                @auth
                                    <li>

                                        <a href="#" class="user-menu">
                                            <span class="fa fa-user"></span> <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a>{{ ucwords(Auth::user()->first_name.' '.Auth::user()->last_name) }} {{ Auth::user()->username ? '('.strtoupper(Auth::user()->username).')' : '' }}</a>
                                            </li>
                                            @if( App\User::isSeller() )

                                                <li>
                                                    <a href="{{ route('seller.home') }}">Dashboard</a>
                                                </li>
                                            @endif
                                            @if( App\User::isMember() )
                                                <li>
                                                    <a href="{{ route('user.home') }}">Dashboard</a>
                                                </li>
                                            @endif

                                            @if( !App\User::isSeller() && !App\User::isMember() )
                                                <li>
                                                    <a href="{{ route('order') }}">My Orders</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('change.password') }}">Change password</a>
                                                </li>
                                            @endif
                                            
                                            <li>

                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-lock left"></i> <span class="">Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a title="Login" href="{{ url('login?back='.current_url()) }}"><i class="fa fa-unlock-alt left" aria-hidden="true"></i></a>
                                    </li>
                                @endauth

                                <?php $wishlist = Cookie::get('wishlistProduct'); $count = 0;  ?>
                                @if( $wishlist )
                                    <?php $wishlist = json_decode($wishlist); $count = $wishlist ? count($wishlist) : 0; ?>
                                @endif

                                <!-- Whishlist-->
                                <li>
                                    <a href="{{ url('/wishlist') }}" class="js_whishlist-btn"><i aria-hidden="true" class="fa fa-heart"></i><span id="countTip" class="countTip">{{ $count }}</span></a>
                                </li>

                                <!-- Cart-->
                                <li>
                                    <a id="sidebar_toggle_btn">
                                    <div class="cart-icon">
                                        <i aria-hidden="true" class="fa fa-shopping-bag"></i> <span id="cartCounter" class="countTip">{{ $cart_count }}</span>
                                    </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="hotline" style="display: none;">
                                <span class="fa-solid fa-phone"></span>: 
                                <a href=""> +0123456789</a>
                            </div>
                        </div>
                           
                    </div>
                </div>
                <div class="header-main-inner" style="display: none;">
                    <!-- Logo -->
                    <div style="" class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('public/'. public_file( $site_logo ) ) }}" alt="{{ $site_name }}" />
                        </a>
                    </div>
                    <!-- End Logo -->


                    <!-- Right Sidebar Nav -->
                    <div class="header-rightside-nav">
                        <!-- Sidebar Icon -->
                        <div class="sidebar-icon-nav">
                            <ul class="list-none-ib">
                                <!-- Search-->
                                <li>
                                    <form class="search-menu" action="{{ url('/') }}">
                                        <div class="input-group">
                                            <input type="text" name="s" placeholder="Search here..." class="form-control">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </li>

                                @auth
                                    <li>
                                        <a href="#" class="user-menu">
                                            <span class="fa fa-user"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('order') }}">My Orders</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('change.password') }}">Change password</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-lock left"></i> <span class="">Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a title="Login" href="{{ url('login?back='.current_url()) }}"><i class="fa fa-unlock-alt left" aria-hidden="true"></i></a>
                                    </li>
                                @endauth

                                <?php $wishlist = Cookie::get('wishlistProduct'); $count = 0;  ?>
                                @if( $wishlist )
                                    <?php $wishlist = json_decode($wishlist); $count = count($wishlist); ?>
                                @endif


                                <!-- Whishlist-->
                                <li>
                                    <a href="{{ url('/wishlist') }}" class="js_whishlist-btn"><i aria-hidden="true" class="fa fa-heart"></i><span id="countTip" class="countTip">{{ $count }}</span></a>
                                </li>

                                <!-- Cart-->
                                <li>
                                    <a id="sidebar_toggle_btn">
                                    <div class="cart-icon">
                                        <i aria-hidden="true" class="fa fa-shopping-bag"></i> <span id="countTip" class="countTip">{{ $cart_count }}</span>
                                    </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Sidebar Icon -->
                    </div>
                    <!-- End Right Sidebar Nav -->
                </div>

                <a class="mobile-menu-bar"><span class="fa fa-bars"></span></a>

                <!-- Navigation Menu -->
                <nav class="navigation-menu" style="">

                    <div class="container">
                    
                    <?php $menu = App\model\Post::where(['title' => 'primary', 'type' => 'menu'])->first(); ?>
                    
                        <ul>
                            <li>
                                <a class="active" href="">Home</a>
                            </li>
                            <li class="has-children">
                                <a href="#">Mobiles <i class="fa fa-angle-down"></i></a>
                                @if( $categories && count( $categories ) > 0 )
                                <ul class="dropdown-menu minmenu">
                                    @foreach( $categories as $cat )
                                        @if( $cat->parent == 26 )
                                            <li>
                                                <a href="{{ route('category.product', ['mobiles', $cat->slug]) }}">
                                                    {{ ucwords($cat->name) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            <li class="has-children">
                                <a href="#">Clothes <i class="fa fa-angle-down"></i></a>
                                <div class="megamenu dropdown-menu">
                                    <div class="menu-col">
                                        <h4><a href="#">Mens</a></h4>
                                        @if( $categories && count( $categories ) > 0 )
                                        <ul class="dropdown-menu">
                                            @foreach( $categories as $cat )
                                                @if( $cat->parent == 10 )
                                                    <li>
                                                        <a href="{{ route('category.product', ['mens', $cat->slug]) }}">
                                                            {{ ucwords($cat->name) }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="menu-col">
                                        <h4><a href="#">Womens</a></h4>
                                        @if( $categories && count( $categories ) > 0 )
                                        <ul class="dropdown-menu">
                                            @foreach( $categories as $cat )
                                                @if( $cat->parent == 16 )
                                                    <li>
                                                        <a href="{{ route('category.product', ['womens', $cat->slug]) }}">
                                                            {{ ucwords($cat->name) }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="menu-col">
                                        <h4><a href="#">Childrens</a></h4>
                                        @if( $categories && count( $categories ) > 0 )
                                        <ul class="dropdown-menu">
                                            @foreach( $categories as $cat )
                                                @if( $cat->parent == 40 )
                                                    <li>
                                                        <a href="{{ route('category.product', ['childrens', $cat->slug]) }}">
                                                            {{ ucwords($cat->name) }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    
                                </div>
                            </li>
                            <li class="has-children">
                                <a href="#">Shoes <i class="fa fa-angle-down"></i></a>
                                @if( $categories && count( $categories ) > 0 )
                                <ul class="dropdown-menu minmenu">
                                    @foreach( $categories as $cat )
                                        @if( $cat->parent == 33 )
                                            <li>
                                                <a href="{{ route('category.product', ['shoes', $cat->slug]) }}">
                                                    {{ ucwords($cat->name) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['sports']) }}">Sports</a>
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['home-interior']) }}">Home Interior</a>
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['kitchen-accessories']) }}">Kitchen Accessories</a>
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['bags']) }}">Bags</a>
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['refurbished']) }}">Refurbished</a>
                            </li>
                            <li>
                                <a href="{{ route('product.category', ['other-products']) }}">Others</a>
                            </li>
                        </ul>

                    </div>
                    
                </nav>
                <!-- End Navigation Menu -->


                <!-- Navigation Menu -->
                <div class="sidebar-menu-overlay"></div>
                <div class="side-menu-mobile">
                    <div class="menu-header">
                        <span>Menu</span>
                        <a class="close-mobile-menu close-icon-white"></a>
                    </div>
                    <?php //$menu = App\model\Post::where(['title' => 'primary', 'type' => 'menu'])->first(); ?>
                        <ul class="mobile-menu-nav">
                            @if( $categories && count( $categories ) > 0 )
                                @foreach( $categories as $row )
                                    @if( !$row->parent )
                                        <?php $hasChild = $categories->where('parent', $row->id)->first(); ?>
                                        <li class="{{ $hasChild ? 'has-children' : '' }} {{ $agent->isMobile() ? ' mobile' : '' }}">
                                            <a role="button" class=" {{ $hasChild ? 'has-item' : '' }}">{{ ucwords($row->name) }}  <?php echo $hasChild ? '<i class="fa fa-plus"></i>' : ''; ?> </a>
                                            @if( $categories->where('parent', $row->id)->first() )
                                                <ul class="minmenu">
                                                    @foreach( $categories as $cat )
                                                        @if( $cat->parent == $row->id )
                                                            <li>
                                                                <a href="{{ route('category.product', [$row->slug, $cat->slug]) }}">{{ ucwords($cat->name) }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                </div>

            </div>
            <!-- End Header Container -->
        </header>
        <!-- End Header -->
          <!-- Start header -->
 <header>
            <div class="container">
                <div class="header-top">
                    <!-- start logo -->
                    <div id="logo">
                        <a href="#"> <img src="{{ asset('public/'. public_file( $site_logo ) ) }}" alt="{{ $site_name }}" class="img-responsive logo-header" /></a>
                    </div>

                    <!-- start search -->
                    <div class="btn_search">
                         {{ Form::open(['url' => url('/'), 'method' => 'GET']) }}
                            <div id="mahardhiSearch" class="input-group mahardhi-search">
                                <input type="text" name="s" id="s" value="" placeholder="Search..." class="form-control input-lg ui-autocomplete-input" />
                                <span class="btn-search input-group-btn">
                                    <button type="submit" class="btn btn-default btn-lg"><i class="search-icon icon-search"></i></button>
                                </span>
                            </div>
                        {{ Form::close() }}

                        
                    </div>

                    <!-- start cart -->
                    <div class="header-right header-links">
                        <div class="header_cart">
                            <div id="cart" class="btn-group btn-block">
                                 <div class="useful_links d-flex justify-content-between text-center ">

                                    @auth
                                        <span href="" class="mr-5 signin show-myaccount">
                                        <img class="d-none d-lg-block d-md-none" src="{{asset('assets/catalog/svg/usericon.svg')}}" alt="My Account"/>
                                        <p class="m-0">My Account</p>
                                        <div class="myaccount_dropdown">
                                            <div class="arrow_drop"></div>
                                            <ul>
                                                <li>
                                                    <a class="nav-link-header" href="{{route('customer.profile')}}">
                                                        <span>
                                                            <img
                                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNC43ODgiIGhlaWdodD0iMTguNDk2IiB2aWV3Qm94PSIwIDAgMTQuNzg4IDE4LjQ5NiI+PGRlZnM+PHN0eWxlPi5hLC5ie2ZpbGw6IzQyNDQ1MztzdHJva2U6IzQyNDQ1MztzdHJva2Utd2lkdGg6MC41cHg7fS5he29wYWNpdHk6MC41O308L3N0eWxlPjwvZGVmcz48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjI1MiAwLjI1KSI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCkiPjxwYXRoIGNsYXNzPSJhIiBkPSJNMTQuNSw4LjMzM0EzLjk4OSwzLjk4OSwwLDAsMSwxMC41Myw0LjE2OGEzLjk3NCwzLjk3NCwwLDEsMSw3LjkzOCwwQTMuOTgsMy45OCwwLDAsMSwxNC41LDguMzMzWm0wLTcuMTM0YTIuNzgxLDIuNzgxLDAsMCwwLTIuNzc0LDIuOTY5LDIuNzc2LDIuNzc2LDAsMSwwLDUuNTM5LDBBMi43NzgsMi43NzgsMCwwLDAsMTQuNSwxLjJaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNy4zNjMpIi8+PHBhdGggY2xhc3M9ImIiIGQ9Ik0uNTc5LDM5LjQwOWEuNi42LDAsMCwxLS40MjMtLjE3NEEuNi42LDAsMCwxLS4wMjEsMzguN2wxLjQ2LTcuNjJhLjYuNiwwLDAsMSwuNi0uNDg5SDEyLjU1M2EuNi42LDAsMCwxLC42LjQ3NGwxLjA4OSw1LjA4YS42LjYsMCwwLDEtLjQ3MS43MTRMLjY5MywzOS40MDlhLjQ3NC40NzQsMCwwLDEtLjExNCwwWm0xLjk0Ni03LjYyLTEuMiw2LjI2MSwxMS42LTIuMjQtLjg1OC00LjAyMVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDMgLTIxLjQxNykiLz48L2c+PC9nPjwvc3ZnPg=="
                                                                alt="Profile"
                                                            />
                                                        </span>
                                                        My profile
                                                    </a>
                                                </li>
                                            
                                                <li>
                                                    <a class="nav-link-header" href="{{ route('order') }}">
                                                        <span>
                                                            <img
                                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNy41NDMiIGhlaWdodD0iMTUuNjcxIiB2aWV3Qm94PSIwIDAgMTcuNTQzIDE1LjY3MSI+PGRlZnM+PHN0eWxlPi5hLC5ie2ZpbGw6IzQyNDQ1MztzdHJva2U6IzQyNDQ1MztzdHJva2Utd2lkdGg6MC41cHg7fS5ie29wYWNpdHk6MC41O308L3N0eWxlPjwvZGVmcz48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjI1MiAwLjI1NCkiPjxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgMCkiPjxwYXRoIGNsYXNzPSJhIiBkPSJNMTIuMTcxLDE0LjY3YS41NzIuNTcyLDAsMCwxLS41NDctLjQwNkw5LjE3OCw2LjIzMWEuNTc1LjU3NSwwLDAsMSwuNTQ5LS43NDFIMjNhLjU3Mi41NzIsMCwwLDEsLjU3Mi41NzJ2Ni4zYS41NzIuNTcyLDAsMCwxLS40ODQuNTcyTDEyLjI1NywxNC42NjVaTTEwLjUsNi42MzVsMi4wNzUsNi44MTksOS44NTYtMS41OTFWNi42MzVaTTIzLDEyLjM1OFoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC02LjUzNCAtMy45MTkpIi8+PHBhdGggY2xhc3M9ImIiIGQ9Ik0yMi44ODksNDIuMjkzYTIuMTQ2LDIuMTQ2LDAsMSwxLDIuMTQzLTIuMTQzQTIuMTQ2LDIuMTQ2LDAsMCwxLDIyLjg4OSw0Mi4yOTNabTAtMy4xNDhhMSwxLDAsMSwwLDEsMSwxLDEsMCwwLDAtMS0xWiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTE0LjgwNiAtMjcuMTI2KSIvPjxwYXRoIGNsYXNzPSJiIiBkPSJNNDQuODU5LDQyLjI5M0EyLjE0NiwyLjE0NiwwLDEsMSw0Nyw0MC4xNDksMi4xNDYsMi4xNDYsMCwwLDEsNDQuODU5LDQyLjI5M1ptMC0zLjE0OGExLDEsMCwxLDAsMSwxLDEsMSwwLDAsMC0xLTFaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAuNDg4IC0yNy4xMjYpIi8+PHBhdGggY2xhc3M9ImEiIGQ9Ik0zLjI1OSwyLjkyOGEuNTcyLjU3MiwwLDAsMS0uNTQ0LS4zOTJMMi4zMzUsMS4zOTFsLTEuNS43NDFBLjU3My41NzMsMCwxLDEsLjMyLDEuMTA4TDIuNDE1LjA2YS41NzIuNTcyLDAsMCwxLC44LjMzMkwzLjgsMi4xNzhhLjU3Mi41NzIsMCwwLDEtLjU0NC43NVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0wLjAwMyAwKSIvPjwvZz48L2c+PC9zdmc+"
                                                                alt="Cart"
                                                            />
                                                        </span>
                                                        Orders
                                                    </a>
                                                </li>
                                               {{--  <li>
                                                    <a class="nav-link-header" href="/#">
                                                        <span>
                                                            <img
                                                                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNC42MTQiIGhlaWdodD0iMTIuMDI4IiB2aWV3Qm94PSIwIDAgMTQuNjE0IDEyLjAyOCI+PGRlZnM+PHN0eWxlPi5hLC5ie2ZpbGw6IzQyNDQ1MztzdHJva2U6IzQyNDQ1MztzdHJva2Utd2lkdGg6MC41cHg7fS5ie29wYWNpdHk6MC41O308L3N0eWxlPjwvZGVmcz48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjI1IDAuMjUpIj48cGF0aCBjbGFzcz0iYSIgZD0iTTE1MC40Ny02ODguNDc0YS40Ny40NywwLDAsMS0uMy0uMTExLjQ3LjQ3LDAsMCwxLS4xNjktLjM2Vi02OTkuNTNhLjQ3LjQ3LDAsMCwxLC40Ny0uNDdoMTMuMTczYS40Ny40NywwLDAsMSwuNDcuNDd2OC4yMzNhLjQ3MS40NzEsMCwwLDEtLjM4OC40NzFsLTEzLjE3MywyLjM1MkEuNDc2LjQ3NiwwLDAsMSwxNTAuNDctNjg4LjQ3NFptLjQ3LTEwLjU4NXY5LjU1M2wxMi4yMzItMi4xODN2LTcuMzdabTEyLjcsNy43NjNaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTUwIDcwMCkiLz48cGF0aCBjbGFzcz0iYiIgZD0iTTE1Ny40MjctNjk0LjkxYS40NzEuNDcxLDAsMCwxLS4yMzUtLjA2MWwtNi40NjktMy42NDZhLjQ3MS40NzEsMCwwLDEtLjE3OS0uNjQuNDcxLjQ3MSwwLDAsMSwuNjQtLjE3OWw2LjI0MywzLjUxNCw2LjIzOC0zLjUxNGEuNDcuNDcsMCwwLDEsLjY0LjE3OS40Ny40NywwLDAsMS0uMTc5LjY0bC02LjQ2NCwzLjY0NkEuNDcxLjQ3MSwwLDAsMSwxNTcuNDI3LTY5NC45MVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xNTAuMzcgNjk5LjYxNSkiLz48L2c+PC9zdmc+"
                                                                alt="Address"
                                                            />
                                                        </span>
                                                        My addresses
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a href="{{route('customer.profile.change.password')}}"><i class="fa fa-lock fa-2x"></i> Change Password</a>
                                                </li>
                                                <li>
                                                     <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="">Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                                </li>
                                            </ul>
                                        </div>
                                        </span>
                                    @else
                                        <a href="{{ url('login?back='.current_url()) }}" class="mr-5 signin show-myaccount">
                                            <img class="d-none d-lg-block d-md-none" src="{{asset('assets/catalog/svg/usericon.svg')}}" alt="My Account"/>
                                            <p class="m-0">Sign in</p>
                                        </a>
                                    @endauth
                                    
                                 {{--    <a href="#" class="mr-5 d-none d-lg-block d-md-none store-icon">
                                        <img src="{{asset('assets/catalog/svg/mystore.svg')}}" alt="Stores">
                                        <p class="m-0">My Store</p>
                                    </a> --}}
                                    {{-- tel:{{ App\model\Meta::where('meta_name', 'phone')->value('meta_Value') }} --}}
                                    <a href="{{url('contact-us')}}" class="mr-5 d-none d-lg-block d-md-none support-icon" rel="noopener noreferrer">
                                        <img src="{{asset('assets/catalog/svg/support.svg')}}" alt="Help">
                                        <p class="m-0">Support</p>
                                    </a>
                                    <a class="cart show-cart-popup" href="#">
                                        <img src="{{asset('assets/catalog/svg/cart.svg')}}" alt="Cart">
                                        <p class="m-0">Cart</p>
                                    </a>

                                    <a  href="{{url('wishlist')}}">
                                        <img src="{{asset('assets/catalog/svg/heart.png')}}" alt="Wishlist">
                                        <p class="m-0">Wishlist</p>
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 <?php $categories = App\model\Category::where('id','!=',41)->get(); ?>
            <!-- start menu -->
            <div class="header-bottom">
                <div class="container">
                    <div class="header-inner">
                        <!-- start menu -->
                        <nav id="menu" class="navbar navbar_menu">
                            <div class="navbar-header">
                                <button type="button" class="btn btn-navbar navbar-toggle" id="btnMenuBar"><span class="addcart-icon"></span></button>
                            </div>
                            <div id="topCategoryList" class="main-menu menu-navbar clearfix" data-more="">
                                <div class="menu-close hidden-lg hidden-md"><span id="category" class="">Menu</span><i class="icon-close"></i></div>
                                <ul class="nav navbar-nav">
                                    <li> <a href="#" class="open-mega-menu" aria-expanded="false"><i class="fa fa-bars"></i> All</a></li>
                                    <li class="dropdown menulist" style="display: none;">
                                        <a href="#" class="dropdown-toggle" aria-expanded="false"><i class="fa fa-bars"></i></a>
                                        <div class="dropdown-menu navcol-menu column-1">
                                            <div class="dropdown-inner">
                                                <ul class="list-unstyled childs_1">
                                                    @if( $categories && count( $categories ) > 0 )
                                                        @foreach( $categories as $row )
                                                            @if( !$row->parent )
                                                                <li class="{{ $categories->where('parent', $row->id)->first() ? 'dropdown-submenu sub-menu-item' : '' }} {{ $agent->isMobile() ? ' mobile' : '' }}">
                                                                    <a href="{{ route('product.category', $row->slug) }}" class=" {{ $categories->where('parent', $row->id)->first() ? 'item-parent dropdown-toggle' : '' }}" data-label="{{ $row->name }}" data-value="{{ $row->slug }}">{{ ucwords($row->name) }} 
                                                                     @if($categories->where('parent', $row->id)->first())
                                                                        <span class="float-right more-menu-have"><i class="fa fa-angle-right"></i></span>
                                                                     @endif
                                                                    </a>
                                                                    @if( $categories->where('parent', $row->id)->first() )
                                                                         <ul class="list-unstyled sub-menu">
                                                                            @foreach( $categories as $cat )
                                                                                @if( $cat->parent == $row->id )
                                                                                    <li>
                                                                                <a data-label="{{ $cat->name }}" data-value="{{ $cat->slug }}" href="{{route('category.product',[$row->slug,$cat->slug])}}">{{ ucwords($cat->name) }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                <li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="menulist home">
                                        <a id="home" href="{{url('/')}}">Home</a>
                                    </li>

                                    <li class="">
                                        <a href="{{route('product.category','table-tennis-table')}}">Table Tennis Table</a>
                                    </li>

                                    <li>
                                        <a href="{{route('product.category','cricket-equipment')}}">Cricket Equipment</a>
                                    </li>
                                   
                                    <li>
                                        <a href="{{route('product.category','fitness-equipment')}}"> Fitness Equipment</a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{route('product.category','gymnastic-equipment')}}">Gymnastic Equipment</a>
                                    </li>

                                    <li>
                                        <a href="{{route('product.category','hot-deal')}}">Hot Deal</a>
                                    </li>

                                    <li class="show-scroll none-dd">
                                        @auth
                                            <a href="{{route('customer.profile')}}">
                                                <i class="fa fa-user"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('login?back='.current_url()) }}">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                        @endauth
                                    </li>
                                    <li class="show-scroll none-dd">
                                        <a href="javascript:void(0)" class="show-cart-popup">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                    </li>



                                   
                                </ul>
                            </div>
                        </nav>

                        <!-- start account -->
                       <!--  <div id="header_ac" class="dropdown">
                            <a href="indexe223.html?route=account/account" title="Account" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><span>Account</span> </a>
                            <ul class="dropdown-menu dropdown-menu-right account-link-toggle">
                                <li><a href="index5502.html?route=account/register">Register</a></li>
                                <li><a href="indexe223.html?route=account/login">Login</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </header>



        @yield('content')


        <!-- Footer Section -------------->
        <footer class="footer pt-5 pb-5" style="display: none;">
            <!-- Footer Info -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="footer-header">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 footer-col">
                                    <h3>SUBSCRIBE NEWSLETTER</h3>
                                    <p>Get all the latest information on Events,Sales and Offers. Sign up for newsletter today</p>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 footer-block footer-col">
                                    <form id="subscribeForm" action="{{ route('subscribe') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="input-group">
                                            <input type="email" placeholder="Email address" name="email" class="form-control">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">SUBSCRIBE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 footer-block">
                                    <ul class="footer-social-icon">
                                            <li><a href="https://facebook.com/{{ $facebook }}" target="_blank"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li>
                                            <li><a href="https://twitter.com/{{ $twitter }}" target="_blank"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="https://plus.google.com/{{ $google_plus }}" target="_blank"><i class="fa-brands fa-google" aria-hidden="true"></i></a></li>
                                            <li><a href="https://www.instagram.com/{{ $instagram }}" target="_blank"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-sm-45">
                            <div class="footer-block about-us-block">
                                <img src="{{ asset('public/'. public_file( $footer_logo ) ) }}" alt="{{ $site_name }}" />
                                <p>{{ App\model\Post::where('id', 20)->value('excerpt') }}</p>
                                
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 mb-sm-45">
                            <div class="footer-block information-block">
                                <h6>Information</h6>
                                <?php $menu = App\model\Post::where(['title' => 'footer', 'type' => 'menu'])->first(); ?>
                                <ul>
                                @if( $menu )
                                    <?php $menu = json_decode( $menu->content ); ?>
                                    @foreach( $menu as $m )
                                        @if( $m->type === 'link' )
                                        <li>
                                            <a {{ isset( $m->target ) && $m->target === 1 ? 'target=_blank' : '' }} href="{{ $m->url }}">{{ ucfirst( str_replace('-', ' ', $m->slug) ) }}</a>
                                        </li>
                                        @endif

                                        @if( $m->type === 'category' )
                                        <?php $cat = App\model\Category::where('slug', $m->slug)->value('name'); ?>
                                        <li>
                                            <a href="{{ url('/'.$m->slug) }}">{{ ucfirst( $cat ) }}</a>
                                        </li>
                                        @endif

                                        @if( $m->type === 'page' )
                                        <?php $page = App\model\Post::where(['slug' => $m->slug, 'type' => 'page'])->value('title'); ?>
                                        <li>
                                            <a href="{{ url('/'.$m->slug) }}">{{ ucfirst( $page ) }}</a>
                                        </li>
                                        @endif

                                    @endforeach
                                   
                                @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 mb-sm-45">
                            <div class="footer-block links-block">
                                <h6>Categories</h6>
                                <?php $menu = App\model\Post::where(['title' => 'footer-category', 'type' => 'menu'])->first(); ?>
                                <ul>
                                @if( $menu )
                                    <?php $menu = json_decode( $menu->content ); ?>
                                    @foreach( $menu as $m )
                                        @if( $m->type === 'link' )
                                        <li>
                                            <a href="{{ $m->url }}">{{ ucfirst( str_replace('-', ' ', $m->slug) ) }}</a>
                                        </li>
                                        @endif

                                        @if( $m->type === 'category' )
                                        <?php $cat = App\model\Category::where('slug', $m->slug)->value('name'); ?>
                                        <li>
                                            <a href="{{ url('/'.$m->slug) }}">{{ ucfirst( $cat ) }}</a>
                                        </li>
                                        @endif

                                        @if( $m->type === 'page' )
                                        <?php $page = App\model\Post::where(['slug' => $m->slug, 'type' => 'page'])->value('title'); ?>
                                        <li>
                                            <a href="{{ url('/'.$m->slug) }}">{{ ucfirst( $page ) }}</a>
                                        </li>
                                        @endif

                                    @endforeach
                                   
                                @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-sm-45">
                            <div class="footer-block contact-block">
                                <h6>Contact</h6>
                                <ul>
                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> 
                                    <?php echo App\model\Meta::where('meta_name', 'address')->value('meta_Value'); ?>
                                    </li>
                                    <?php $mail = App\model\Meta::where('meta_name', 'contact_email')->value('meta_Value'); ?>
                                    <li><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:{{ $mail }}">{{ $mail }}</a></li>
                                    <li><i class="fa-solid fa-phone" aria-hidden="true"></i> 
                                        {{ App\model\Meta::where('meta_name', 'phone')->value('meta_Value') }}
                                    </li>
                                </ul>
                            </div> 
                        </div>
                    </div>
            </div>
            <!-- End Footer Info -->

            <!-- Footer Copyright -->
            <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="copyrights footer-bottom">
                                <p class="copyright"><span class="pull-left">{{ App\model\Meta::where('meta_name', 'copyright')->value('meta_value') }}  </span><span class="pull-right">Developed by 
                                <a href="https://www.techdost.com/" target="_blank">Techdost Services Pvt. Ltd.</a></span></p>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- End Footer Copyright -->
        </footer>
        <!-- End Footer Section -->

<?php $whatsapp = App\model\Meta::where('meta_name', 'whatsapp')->value('meta_value'); ?>
<?php $phone =  App\model\Meta::where('meta_name', 'phone')->value('meta_value');?>
<?php $mobile =  App\model\Meta::where('meta_name', 'mobile')->value('meta_value');?>


<?php $facebook = App\model\Meta::where('meta_name', 'facebook')->value('meta_value'); ?>
<?php $twitter =  App\model\Meta::where('meta_name', 'twitter')->value('meta_value');?>
<?php $linkedin =  App\model\Meta::where('meta_name', 'linkedin')->value('meta_value');?>
<?php $instagram =  App\model\Meta::where('meta_name', 'instagram')->value('meta_value');?>
<?php $copyright =  App\model\Meta::where('meta_name', 'copyright')->value('meta_value');?>

<div id="mySidenav" class="sidenav">
    <span class="title">All </span>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="product-filter-row">
        <div class="filter-title">
            {{-- <span>Categories</span> --}}
            {{-- <span class="plus-sign open"></span> --}}
        </div>
        <div class="filter-content-categories filter-content">
            <?php $notids = array(41,44,45,46,47); ?>
            <?php $categories = App\model\Category::whereNotIn('id',$notids)->get(); $c = 0; ?>
            @if( $categories && count($categories) >0 )
                <ul class="filter-list simple-radio perfect-scrollbar">
                @foreach( $categories as $key => $cat )
                    @if( !$cat->parent )
                        <li class="filter-item">
                            <p class="filter expand-list">
                                @if($categories->where('parent', $cat->id)->first())
                                    <span class="plus-sign"></span>
                                @endif
                                <input class="{{ $category && $category->slug === $cat->slug ? 'checked' : '' }}" data-parent="" type="radio" name="category" id="{{ $cat->slug.++$c }}" value="{{ $cat->slug }}">
                                <label class="radio" for="{{ $cat->slug.$c }}">
                                    {{ ucwords($cat->name) }}
                                </label>
                            </p>
                            @if($categories->where('parent', $cat->id)->first())
                            <ul class="filter-list child-category">
                                @foreach( $categories as $child )
                                    @if( $cat->id == $child->parent )
                                    <li class="filter-item" >
                                        <p class="filter">
                                            <input data-parent="{{ $cat->slug }}" class="{{ $category && $category->slug === $child->slug ? 'checked' : '' }}" type="radio" name="category" id="{{ $child->slug.++$c }}" value="{{ $child->slug }}">
                                            <label class="radio inner-label" for="{{ $child->slug.$c }}">
                                                {{ ucwords($child->name) }}
                                            </label>
                                        </p>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<footer class="parallax-footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row footer-middle">
                        <div class="col-md-7 col-sm-4">
                            <div class="position-footer-left">
                                <h5 class="toggled title">Follow us</h5>
                                <div class="social-media-footer">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="{{$facebook ? $facebook : '#'}}"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{$twitter ? $twitter : '#'}}"><i class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{$linkedin ? $linkedin : '#'}}"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{$instagram ? $instagram : '#'}}"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                                        </li>
                                        <li>
                                            
                                            <a href="https://wa.me/<?=$whatsapp ? $whatsapp :'#'; ?>?text=Hi%20Koxton%0A%0AI%20am%20interested%20in%20your%20product%0A%0AMy%20name%20is%20"><i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="site">
                                            <div class="contact_title">address:</div>
                                            <div class="contact_site"><?php echo  App\model\Meta::where('meta_name', 'address')->value('meta_value'); ?></div>
                                        </div>
                                    </li>

                                    
                                    <li>
                                        <div class="phone">
                                            <div class="contact_title">phone:</div>
                                            <div class="contact_site">{{$phone}}, {{$mobile}}</div>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <div class="fax">
                                            <div class="contact_title">fax:</div>
                                            <div class="contact_site">0123-456-789</div>
                                        </div>
                                    </li> -->
                                    <li>
                                        <div class="email">
                                            <div class="contact_title">email:</div>
                                            <div class="contact_site"><a href="mailto:info@koxton.com">info@koxton.com, sales@koxton.com</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <style type="text/css">
                            .logo-footer{
                                width: 250px;
                            }
                            .parallax-footer {
                              /* The image used */
                              background-image: url("{{asset('assets/catalog/img/footer-banner.jpg')}}");

                              /* Set a specific height */
                              /*min-height: 500px; */

                              /* Create the parallax scrolling effect */
                              background-attachment: fixed;
                              background-position: center;
                              background-repeat: no-repeat;
                              background-size: cover;
                            }
                            .site{
                                margin-top: 25px!important;
                            }
                            .social-media-footer ul li{
                                display: inline-block;
                            }
                            .social-media-footer ul{
                                display: inline-block;
                                }
                                .social-media-footer li + li{
                                margin-left: 5px;
                            }
                            .social-media-footer li a i {
                                height: 40px;
                                width: 40px;
                                display: inline-block;
                                line-height: 40px;
                                color: var(--primary-color);
                                font-size: 16px;
                                background: var(--secondary-color);
                                border-radius: 5px;
                                text-align: center;
                            }
                            .social-media-footer li:hover .fa-facebook {
                                background: #3b5998;
                            }
                            .social-media-footer li:hover .fa-twitter {
                                background: #00acee;
                            }
                            .social-media-footer li:hover .fa-linkedin {
                                background: #4682b4;
                            }
                            .social-media-footer li:hover .fa-instagram {
                                    background: linear-gradient(
                            176deg
                            , rgb(115 117 128) 0%, rgb(225 52 124) 30%, rgb(225 74 49) 64%, rgba(231,195,86,1) 94%);
                            }
                            .social-media-footer li:hover .fa-whatsapp {
                                background: #075E54;
                            }
                            .social-media-footer li:hover a i{
                                color: var(--secondary-color);
                            }
                            .mtb-20{
                                    margin-top: 20px;
    /*margin-bottom: 20px;*/
                            }
                        </style>
                       <?php $about_us = App\model\Post::where(['id' => 6, 'type' => 'page'])->value('excerpt'); ?>
                        <div class="col-md-5 col-sm-4">
                            <div class="position-footer-right">
                                <div class="news">
                                    <div class="newsletterblock">
                                        <div class="newsletter-form block-content">
                                            <div class="news-info">
                                                <div class="news-desc">
                                                    <!-- <h4 class="title-text page-title">Newsletter SignUp</h4> -->
                                                    <img src="{{ asset('public/'. public_file( $footer_logo ) ) }}" alt="{{ $site_name }}"  class="footer-logo" />
                                                    <div class="news-description">{{$about_us ? $about_us : ''}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom clearfix">

                <div class="container">
                    <div class="row mtb-20 pages-row">
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('/')}}">Home</a></p></div> </div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('about-us')}}">About Us</a></p></div> </div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('contact-us')}}">Contact Us</a></p></div></div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('blogs')}}">Career</a></p></div></div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('our-vision-mission')}}">Vision & Mission</a></p></div></div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('privacy-policy')}}">Privacy Policy</a></p></div></div>
                        <div class="col-md-2 col-sm-12"><div> <p><a href="{{url('koxton-sports-terms-and-conditions')}}">Term & Condition</a></p></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <p class="powered"><?= $copyright ? $copyright : 'Copyright © 2021 Koxtons Sports Equipments Pvt. Ltd. All rights are reserved.'; ?></p>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <p class="designed--by"><a href="https://www.techdost.com">Designed by TechDost</a></p>
                        </div>
                    </div>
                    
                    <div class="position-footer-bottom">
                        <!-- <div class="social-media">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#"> <i class="fa fa-pinterest-p"></i></a>
                                </li>
                            </ul>
                        </div> -->
                        <!-- <div class="footer_link"><img src="image/catalog/payment.png" alt="" /></div> -->
                    </div>
                </div>
            </div>
        </footer>
        <!-- top scroll -->
        <a href="#" class="scrollToTop back-to-top" data-toggle="tooltip"><i class="fa fa-angle-up"></i></a>
      

    </div>
    
    <div class="spinner-loader" style="display: none;">
      <span class="loader-sm">
        <img src="{{ asset('public/images/loader-spinner.gif') }}">
        <span id="progress-bar"></span>
      </span>
    </div>

    

    @if( !$agent->isDesktop() )
        <?php $whatsapp_number = App\model\Meta::where('meta_name', 'whatsapp')->value('meta_value'); ?>
        <div class="whatsapp" style="display: none;">
            <a href="https://api.whatsapp.com/send?phone={{ $whatsapp_number }}"><img src="{{ asset('assets/img/icons/whatsapp-icon.png') }}"></a>
        </div>
    @else
        <?php echo App\model\Meta::where('meta_name', 'messenger')->value('meta_value'); ?>
    @endif


    
    <!-- End wrapper =============================-->
    {{ csrf_field() }}


    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/owl.carousel.min.js') }}"></script>
  


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function($) {
         $(".chosen").chosen({no_results_text: "No result!", width: "100%"});

      });
      $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    
    
    
    <!-- Slick Slider js -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/plugins-all.js') }}"></script>
    <!-- Plugins All js -->
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.min.js"></script>
    <script type="text/javascript">
        lazyload();
    </script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ asset('assets/js/main.min.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/template.js?v='.time()) }}"></script>

    {{-- AM Code --}}


    {{-- MR Code --}}

     {{-- <script src="{{ asset('assets/clothingmantra/assets/js/jquery.min.js')}}"></script> --}}

     
    <script src="{{ asset('assets/clothingmantra/assets/js/bootstrap.min.js')}}"></script>

    <script src="{{ asset('assets/clothingmantra/assets/js/jquery-plugin-collection.js')}}"></script>

    <script src="{{ asset('assets/clothingmantra/assets/js/script.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery.min.js"></script>

    {{-- MR Code --}}
<script type="text/javascript">

    $("#lightgallery").lightGallery({
        pager: true,
        thumbnail:true

    });
    $('.cart-toggle-btn').click(function(){
        $("#sidebar_toggle_btn").click();
    });
</script>

<script type="text/javascript">
(function () {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

  let birthday = "Sep 30, 2021 00:00:00",
      countDown = new Date(birthday).getTime(),
      x = setInterval(function() {    

        let now = new Date().getTime(),
            distance = countDown - now;

        // document.getElementById("days").innerText = Math.floor(distance / (day)),
          // document.getElementById("hours").innerText = Math.floor( (distance % (day) ) / (hour) ),
          // document.getElementById("minutes").innerText = Math.floor( (distance % (hour) ) / (minute) ),
          // document.getElementById("seconds").innerText = Math.floor( (distance % (minute) ) / second );


          $('.seconds').text(Math.floor( (distance % (minute) ) / second ));
          $('.minutes').text(Math.floor( (distance % (hour) ) / (minute) ));
          $('.hours').text(Math.floor( (distance % (day) ) / (hour) ));
        
        //seconds
      }, 1000)
  }());

$('body').on('click','.open-mega-menu',function(event){
    event.preventDefault();
    document.getElementById("mySidenav").style.width = "300px";
    // document.getElementById("main--").style.marginLeft = "300px";
    document.body.style.backgroundColor = "rgb(3 2 2 / 40%)";
});

$(document).mouseup(function(e) {
    var container = $("#mySidenav");
    var menu = $(".open-mega-menu");
    if (!container.is(e.target) && container.has(e.target).length === 0 && !menu.is(e.target) && menu.has(e.target).length === 0 ) {
        document.getElementById("mySidenav").style.width = "0";
        document.body.style.backgroundColor = "white";
    }

    var container1 = $("#sidebar-right");
    var menu1 = $(".show-cart-popup");
    if (!container1.is(e.target) && container1.has(e.target).length === 0 && !menu1.is(e.target) && menu1.has(e.target).length === 0 ) {
        $('#sidebar-right').removeClass('sidebar-open');
    }


});


// function outer_click(){
// $(document).on('click', function (e) {
//     if ($(e.target).closest("#mySidenav").length === 0) {
//         console.log('outer');
//          document.getElementById("mySidenav").style.width = "0px";
//     }else{
//         console.log('inner');
//          document.getElementById("mySidenav").style.width = "300px";
//     }
// });
// }


// function openNav(e) {
//     document.getElementById("mySidenav").style.width = "250px";
// }
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  // document.getElementById("main--").style.marginLeft = "0";
  document.body.style.backgroundColor = "white";
}


// function createItem() {
//     localStorage.setItem("mytime", Date.now());
// }
// var x = localStorage.getItem("mytime");
// console.log(x);
// if(x==null){
//     $('#newsletter-popup').modal('show');     
// }else{
//     $('#newsletter-popup').modal('hide');
// }

</script>

</body>
</html>