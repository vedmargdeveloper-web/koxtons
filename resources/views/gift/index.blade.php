@extends( _app() )

@section('content')


   <!-- Page Content Wraper -->
        <div class="page-content-wraper">


            <?php $agent = new Jenssegers\Agent\Agent(); ?>

            @if( !$agent->isMobile() )
            
                <?php $slides = App\model\Slide::where('status', 'active')->orderby('id', 'DESC')->limit(10)->get(); ?>
                @if( $slides )
                <!-- Intro -->
                <section id="intro" class="intro">
                    <div class="owl-carousel main-carousel owl-theme main-slider" data-nav="true" 
                    data-dots="true" 
                    data-margin="0" 
                    data-items='1' 
                    data-autoplayTimeout="700" 
                    data-autoplay="true" 
                    data-loop="true">
                    @foreach( $slides as $row )
                      <div class="item">
                        <img class="lazyload" data-src="{{ asset( 'public/' . public_file( $row->image ) ) }}">
                        <div class="description {{ $row->position }}"> 
                            @if( $row->title )
                                <h3 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOutDown">
                                    {{ $row->title }}
                                </h3>
                            @endif
                            @if( $row->description )
                                <p>{{ $row->description }}</p>
                            @endif
                            @if( $row->see_more_link && $row->see_more )
                                <a href="{{ $row->see_more_link }}" class="btn btn-shop" data-animation-in="fadeInLeft" data-animation-out="animate-out fadeOutRight">{{ $row->see_more }}</a>
                            @endif
                        </div>
                      </div>
                    @endforeach
                  </div>
                </section>
                <!-- End Intro -->
                @endif

            @endif

            
            @if( $agent->isMobile() )

                <section class="section-padding" style="padding: 0">
                    <div class="mobile-category-carousel owl-carousel owl-theme nf-carousel-theme1">
                        <div class="product-item">
                            <a href="{{ route('product.category', 'mens') }}">
                                <img class="lazyload" data-src="{{ asset('public/assets/images/small16.jpg') }}">
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('product.category', 'kitchen-accessories') }}">
                                <img class="lazyload" data-src="{{ asset('public/assets/images/small11.jpg') }}">
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('product.category', 'sports') }}">
                                <img class="lazyload" data-src="{{ asset('public/assets/images/small17.jpg') }}">
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('category.product', ['womens', 'women-kurti']) }}">
                                <img class="lazyload" data-src="{{ asset('public/assets/images/small12.jpg') }}">
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('category.product', ['mobiles', 'mobile-accessories']) }}">
                                <img class="lazyload" data-src="{{ asset('public/assets/images/small14.jpg') }}">
                            </a>
                        </div>
                    </div>
                </section>

            @endif

            

            <?php $wishlist = Cookie::get('wishlistProduct'); ?>
            <?php $wishListProduct = $wishlist ? json_decode( $wishlist ) : array(); ?>


            <!-- Latest (Tab with Slider) -->
            <section class="section-padding">
                
                <div class="container">

                    <div class="row">

                        <?php $latestProduct = App\model\Product::limit(10)->where('discount', '!=', null)->where('available', '>', 0)->where('status', 'active')->orderby('discount', 'DESC')->get(); ?>

                        <div class="col-12">

                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <h1 class="page-title">Best Deals <a href="{{ route('hotdeals') }}" class="btn-more pull-right">More</a></h1>
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                            </div>

                            @if( $latestProduct )
                            
                            <div id="new-product" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">

                                @foreach( $latestProduct as $row )
                                <!-- item.1 -->
                                <div class="product-item">
                                    <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                    <a href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                        <div class="product-item-inner">
                                            <div class="product-img-wrap">
                                                <img class="lazyload" data-src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, config('filesize.medium.0'), config('filesize.medium.1') ) ) ) }}" alt="">
                                                @if( $row->discount )
                                                    <div class="sale-label discount">
                                                        <span>-{{ $row->discount }}%</span>
                                                    </div>
                                                @endif

                                                <div role="button" class="btn-wishlist" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></div>
                                            </div>

                                            
                                            @if( $row->available < 1 )
                                                <div class="out-stock">
                                                    <span>Out of stock</span>
                                                </div>
                                            @endif
                                            
                                        </div>
                                        <div class="product-detail">
                                            <p class="product-title">{{ get_excerpt($row->title, 6) }}</p>
                                            <h5 class="item-price">                                    
                                                <?php $price = $row->price; ?>

                                                @if( $row->discount )
                                                    <del><sub><span class="fa fa-inr"></span> {{ $price }}</sub></del>
                                                    <?php $price = $price - ( $price * $row->discount ) / 100; ?>
                                                @endif
                                                
                                                @if( $row->tax )
                                                    <?php $price = $price + ( $price * $row->tax ) / 100; ?>
                                                @endif

                                                <span class="fa fa-inr"></span> {{ round( $price ) }}
                                            </h5>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @else

                            @endif

                        </div>

                    </div>

                </div>
            </section>


            <section class="section-padding category-banner-section">
                <div class="container banner-container">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 banner-col-3">
                            <a href="{{ route('category.product', ['mens', 'men-jeans']) }}">
                                <div class="product-banner-wrapper">
                                    <div class="product-banner-image">
                                        <img class="lazyload" data-src="{{ asset('public/assets/images/banner-med12.jpg') }}">
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4>Jeans</h4>
                                        </div>
                                        <div class="product-description">
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 banner-col-3">
                            <a href="{{ route('category.product', ['shoes', 'men-shoes']) }}">
                                <div class="product-banner-wrapper">
                                    <div class="product-banner-image">
                                        <img class="lazyload" data-src="{{ asset('public/assets/images/shoes4.jpg') }}">
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4>Shoes</h4>
                                        </div>
                                        <div class="product-description">
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 banner-col-3">
                            <a href="{{ route('category.product', ['womens', 'women-kurti']) }}">
                                <div class="product-banner-wrapper">
                                    <div class="product-banner-image">
                                        <img class="lazyload" data-src="{{ asset('public/assets/images/banner-med13.jpeg') }}">
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4>Womens Kurti</h4>
                                        </div>
                                        <div class="product-description">
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 banner-col-3">
                            <a href="{{ route('category.product', ['womens', 'women-sarees']) }}">
                                <div class="product-banner-wrapper">
                                    <div class="product-banner-image">
                                        <img class="lazyload" data-src="{{ asset('public/assets/images/banner-med14.jpg') }}">
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4>Sarees</h4>
                                        </div>
                                        <div class="product-description">
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                       
                </div>
            </section>


            <section class="section-padding promo-banner1 promo" style="background-image: url({{ asset('public/assets/images/promo-banner1.jpg') }});">
                <div class="col-12">
                    <h3>fashion show collection</h3>
                    <a href="{{ url('mens') }}" class="btn btn-shop">Shop Now</a>
                </div>
            </section>


            <!-- Latest (Tab with Slider) -->
            <section class="section-padding bg-feature-color">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <h1 class="page-title">New Arrivals <a href="{{ route('product.new') }}" class="btn-more pull-right">View More</a></h1>
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>

                    <div class="row">

                        <?php $latestProduct = App\model\Product::limit(10)->where('status', 'active')->where('available', '>', 0)->orderby('created_at', 'DESC')->get(); ?>

                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                                @if( $latestProduct )
                                
                                <div id="new-product" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">

                                    @foreach( $latestProduct as $row )
                                    <div class="product-item">
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <a href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                            <div class="product-item-inner">
                                                <div class="product-img-wrap">
                                                    <img class="lazyload" data-src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, config('filesize.medium.0'), config('filesize.medium.1') ) ) ) }}" alt="">
                                                    @if( $row->discount )
                                                        <div class="sale-label discount">
                                                            <span>-{{ $row->discount }}%</span>
                                                        </div>
                                                    @endif
                                                <div role="button" class="btn-wishlist" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></div>
                                                </div>
                                            </div>
                                            <div class="product-detail">
                                                <p class="product-title">{{ get_excerpt($row->title, 6) }}</p>
                                                <h5 class="item-price">                                    
                                                    <?php $price = $row->price; ?>
                                                    @if( $row->discount )
                                                        <del><sub><span class="fa fa-inr"></span> {{ $price }}</sub></del>
                                                        <?php $price = $price - ( $price * $row->discount ) / 100; ?>
                                                    @endif

                                                    @if( $row->tax )
                                                        <?php $price = $price + ( $price * $row->tax ) / 100; ?>
                                                    @endif
                                                    <span class="fa fa-inr"></span> {{ round( $price ) }}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @else

                                @endif

                        </div>

                    </div>

                </div>
            </section>


            <!-- Promo Banner -->
            <section style="" id="promo-banner" class="section-padding">
                <div class="col-12">
                    <div class="row">
                        <!--Left Side-->
                        <div class="col-6 promo-col-left">
                            <!-- banner No.1 -->
                            <div class="promo-banner-wrap">
                                <a href="{{ route('product.category', ['beauty-products']) }}" class="promo-image-wrap">
                                    <img class="lazyload" data-src="{{ asset('public/assets/images/banner-med21.jpg') }}" alt="Accesories" />
                                </a>
                            </div>
                        </div>

                        <!--Right Side-->
                        <div class="col-6 promo-col-right">
                            <!-- banner No.3 -->
                            <div class="promo-banner-wrap">
                                <a href="{{ route('product.category', ['bags']) }}" class="promo-image-wrap">
                                    <img class="lazyload" data-src="{{ asset('public/assets/images/banner-med19.jpg') }}" alt="Accesories" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Promo Banner -->




            <?php $featured = App\model\Product::where(['type' => 'featured', 'status' => 'active'])->where('available', '>', 0)->limit(8)->orderby('updated_at', 'DESC')->get(); ?>
            @if( $featured && count( $featured ) )
            <section style="" class="section-padding bg-feature-color">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <h1 class="page-title">Featured Collection <a href="{{ route('product.featured') }}" class="btn-more pull-right">View More</a></h1>
                        <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div id="new-tranding" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">
                            <!-- item.1 -->
                           @foreach( $featured as $row )
                            <div class="product-item">
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <a href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                            <div class="product-item-inner">
                                                <div class="product-img-wrap">
                                                    <img class="lazyload" data-src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, config('filesize.medium.0'), config('filesize.medium.1') ) ) ) }}" alt="">
                                                    @if( $row->discount )
                                                        <div class="sale-label discount">
                                                            <span>-{{ $row->discount }}%</span>
                                                        </div>
                                                    @endif
                                                    <div role="button" class="btn-wishlist" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></div>
                                                </div>
                                            </div>
                                            <div class="product-detail">
                                                <p class="product-title">{{ get_excerpt($row->title, 6) }}</p>
                                                <h5 class="item-price">                                    
                                                    <?php $price = $row->price; ?>
                                                    @if( $row->discount )
                                                        <del><sub><span class="fa fa-inr"></span> {{ $price }}</sub></del>
                                                        <?php $price = $price - ( $price * $row->discount ) / 100; ?>
                                                    @endif

                                                    @if( $row->tax )
                                                        <?php $price = $price + ( $price * $row->tax ) / 100; ?>
                                                    @endif
                                                    <span class="fa fa-inr"></span> {{ round( $price ) }}
                                                </h5>
                                            </div>
                                        </a>
                                    </div>
                            @endforeach

                        </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!-- Promo Box -->
            <section id="promo" class="section-padding ">
                <div class="promo-box">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 promo-item">
                                <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                                <div class="info">
                                    <a role="button">
                                        <h6 class="normal">COD available</h6>
                                    </a>
                                    <p>Fast delivery</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 promo-item">
                                <div class="icon"><i class="fa fa-repeat" aria-hidden="true"></i></div>
                                <div class="info">
                                    <a role="button">
                                        <h6 class="normal">Made By</h6>
                                    </a>
                                    <p>Experienced Crafters</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 promo-item">
                                <div class="icon"><i class="fa fa-headphones" aria-hidden="true"></i></div>
                                <div class="info">
                                    <a role="button">
                                        <h6 class="normal">Support</h6>
                                    </a>
                                    <p>10AM - 5PM Support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Promo Box -->

        </div>
        <!-- End Page Content Wraper -->


@endsection