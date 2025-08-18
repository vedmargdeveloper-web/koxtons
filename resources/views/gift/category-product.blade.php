@extends( _app() )

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">

    @if( !empty( $category ) )

    <section class="banner-header" style="background: url({{ asset('public/'.public_file( $category->feature_image )) }});background-position: top center;background-size: cover;height: 50vh;background-repeat: no-repeat;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                    <div class="banner-description">
                        <?php echo $category->description; ?>
                    </div>
                </div>
            </div>
        </div>
        
    </section>


    @endif

    <?php $wishlist = Cookie::get('wishlistProduct'); ?>
    <?php $wishListProduct = $wishlist ? json_decode( $wishlist ) : array(); ?>

    


    <?php $category = App\model\Category::find(12); ?>

    <?php $latestProduct = App\model\Product::where('category_id', 12)->orderby('id', 'DESC')->get(); ?>

    @if( $category && $latestProduct && count( $latestProduct ) > 0 )


        <section class="section-padding promo-banner" style="padding-top: 60px;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-10.jpeg') }} "  alt="Promo Banner 10">
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-8.jpeg') }}"  alt="Promo Banner 8">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1 class="page-title">{{ ucwords($category->name) }} 
                            <a href="" class="btn-more pull-right">View More</a></h1>
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="new-product" class="product-item-6 owl-carousel owl-theme nf-carousel-theme1">

                            @foreach( $latestProduct as $row )
                            <!-- item.1 -->
                            <div class="product-item">
                                <div class="product-item-inner">
                                    <div class="product-img-wrap">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                            <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 250, 300 ) ) ) }}"  alt="{{ $row->title }}">
                                            @if( $row->discount )
                                                <div class="sale-label discount">
                                                    <span>-{{ $row->discount }}%</span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <div class="product-over">
                                        @if( $row->available > 0 )
                                            <div class="product-button">
                                                <a role="button" class="js_tooltip" id="addToCartProduct" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></a>
                                                <a role="button" class="js_tooltip" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></a>
                                            </div>
                                        @else
                                            <div class="out-stock">
                                                <span>Out of stock</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="product-detail">
                                    <a class="tag" href="#"></a>
                                    <p class="product-title">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ get_excerpt($row->title, 6) }}</a>
                                    </p>
                                    <h5 class="item-price">                                    
                                        <?php $price = $row->price; ?>
                                        @if( $row->discount )
                                            <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                            <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                        @endif
                                        <span class="fa fa-inr"></span> {{ round( $price ) }}
                                    </h5>
                                </div>

                                
                            </div>
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>
        </section>

        

    @endif



    <?php $category = App\model\Category::find(13); ?>

    <?php $latestProduct = App\model\Product::where('category_id', 13)->orderby('id', 'DESC')->get(); ?>

    @if( $category && $latestProduct && count( $latestProduct ) > 0 )

        <section class="section-padding promo-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-13.jpg') }}" alt="Promo Banner 13">
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-16.jpg') }}" alt="Promo Banner 16">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1 class="page-title">{{ ucwords($category->name) }} 
                            <a href="" class="btn-more pull-right">View More</a></h1>
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="new-product" class="product-item-6 owl-carousel owl-theme nf-carousel-theme1">

                            @foreach( $latestProduct as $row )
                            <!-- item.1 -->
                            <div class="product-item">
                                <div class="product-item-inner">
                                    <div class="product-img-wrap">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                            <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 250, 300 ) ) ) }}" alt="{{ $row->title }}">
                                            @if( $row->discount )
                                                <div class="sale-label discount">
                                                    <span>-{{ $row->discount }}%</span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <div class="product-over">
                                        @if( $row->available > 0 )
                                            <div class="product-button">
                                                <a role="button" class="js_tooltip" id="addToCartProduct" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></a>
                                                <a role="button" class="js_tooltip" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></a>
                                            </div>
                                        @else
                                            <div class="out-stock">
                                                <span>Out of stock</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="product-detail">
                                    <a class="tag" href="#"></a>
                                    <p class="product-title">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ get_excerpt($row->title, 6) }}</a>
                                    </p>
                                    <h5 class="item-price">                                    
                                        <?php $price = $row->price; ?>
                                        @if( $row->discount )
                                            <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                            <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                        @endif
                                        <span class="fa fa-inr"></span> {{ round( $price ) }}
                                    </h5>
                                </div>

                            </div>
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>
        </section>


        

    @endif



    <?php $category = App\model\Category::find(11); ?>

    <?php $latestProduct = App\model\Product::where('category_id', 11)->orderby('id', 'DESC')->get(); ?>

    @if( $category && $latestProduct && count( $latestProduct ) > 0 )

        <section class="section-padding promo-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-17.jpg') }}" alt="Promo Banner 17">
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <a href="">
                            <img src="{{ asset('public/assets/images/banner-sm-18.jpg') }}" alt="Promo Banner 18">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h1 class="page-title">{{ ucwords($category->name) }} 
                            <a href="" class="btn-more pull-right">View More</a></h1>
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="new-product" class="product-item-6 owl-carousel owl-theme nf-carousel-theme1">

                            @foreach( $latestProduct as $row )
                            <!-- item.1 -->
                            <div class="product-item">
                                <div class="product-item-inner">
                                    <div class="product-img-wrap">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                            <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 250, 300 ) ) ) }}" alt="{{ $row->title }}">
                                            @if( $row->discount )
                                                <div class="sale-label discount">
                                                    <span>-{{ $row->discount }}%</span>
                                                </div>
                                            @endif
                                        </a>
                                    </div>
                                    
                                    <div class="product-over">
                                        @if( $row->available > 0 )
                                            <div class="product-button">
                                                <a role="button" class="js_tooltip" id="addToCartProduct" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></a>
                                                <a role="button" class="js_tooltip" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></a>
                                            </div>
                                        @else
                                            <div class="out-stock">
                                                <span>Out of stock</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <a class="tag" href="#"></a>
                                    <p class="product-title">
                                        <a href="{{ url('/' .$category->slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ get_excerpt($row->title, 6) }}</a>
                                    </p>
                                    <h5 class="item-price">                                    
                                        <?php $price = $row->price; ?>
                                        @if( $row->discount )
                                            <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                            <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                        @endif
                                        <span class="fa fa-inr"></span> {{ round( $price ) }}
                                    </h5>
                                </div>

                            </div>
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>
        </section>


        

    @endif


    

</div>
<!-- End Page Content Wraper -->


@endsection