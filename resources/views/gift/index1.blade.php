@extends( _app() )

@section('content')


   <!-- Page Content Wraper -->
        <div class="page-content-wraper">
            
            <?php $slides = App\model\Slide::orderby('id', 'DESC')->paginate(3); ?>
            @if( $slides )
            <!-- Intro -->
            <section id="intro" class="intro">
                <div class="owl-carousel main-carousel owl-theme">
                @foreach( $slides as $row )
                  <div class="item">
                    <img src="{{ asset( 'public/' . public_file( $row->image ) ) }}" alt="{{ $row->title }}">
                    <h3 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOutDown">
                        {{ $row->title }}
                    </h3>
                    <a href="{{ $row->see_more_link }}" class="btn btn-more" data-animation-in="fadeInLeft" data-animation-out="animate-out fadeOutRight">{{ $row->see_more }}</a>
                  </div>
                @endforeach
              </div>
            </section>
            <!-- End Intro -->
            @endif

            <!-- Promo Box -->
            <section style="" id="promo" class="section-padding-sm promo ">
                <div class="container">
                    <div class="promo-box row">
                        <div class="col-md-4 mtb-sm-30 promo-item">
                            <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                            <div class="info">
                                <a role="button">
                                    <h6 class="normal">Free Shipping</h6>
                                </a>
                                <p>On All Orders</p>
                            </div>
                        </div>
                        <div class="col-md-4 mtb-sm-30 promo-item">
                            <div class="icon"><i class="fa fa-repeat" aria-hidden="true"></i></div>
                            <div class="info">
                                <a role="button">
                                    <h6 class="normal">Made By</h6>
                                </a>
                                <p>Experienced Crafters</p>
                            </div>
                        </div>
                        <div class="col-md-4 mtb-sm-30 promo-item">
                            <div class="icon"><i class="fa fa-headphones" aria-hidden="true"></i></div>
                            <div class="info">
                                <a role="button">
                                    <h6 class="normal">Support</h6>
                                </a>
                                <p>24/7 Online Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Promo Box -->

            <?php $wishlist = Cookie::get('wishlistProduct'); ?>
            <?php $wishListProduct = $wishlist ? json_decode( $wishlist ) : array(); ?>


            <?php $featured = App\model\Product::where('type', 'featured')->limit(8)->orderby('updated_at', 'DESC')->get(); ?>
            @if( $featured && count( $featured ) )
            <section class="section-padding">
                <div class="container">
                    <h1 class="page-title">Featured Products</h1>
                </div>
                <div class="container">
                    <div id="new-tranding" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">
                        <!-- item.1 -->
                       @foreach( $featured as $row )
                        <!-- item.1 -->
                        <div class="product-item">
                            <div class="product-item-inner">
                                <div class="product-img-wrap">
                                    <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                        <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 260, 350 ) ) ) }}" alt="{{ $row->title }}">
                                        @if( $row->discount )
                                            <div class="sale-label discount">
                                                <span>{{ $row->discount }}% off</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
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
                            <div class="product-detail">
                                <a class="tag" href="#"></a>
                                <p class="product-title">
                                    
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ $row->title }}</a>
                                </p>
                                <div style="display: none;" class="product-rating">
                                    <div class="star-rating" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated 4 out of 5">
                                        <span style="width: 60%"></span>
                                    </div>
                                    <a href="#" class="product-rating-count"><span class="count">3</span> Reviews</a>
                                </div>
                                <p class="product-description">
                                    {{ $row->excerpt }}
                                </p>
                                <h5 class="item-price">                                    
                                    <?php $price = ''; ?>
                                    @if( $row->discount )
                                        <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                        <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                    @endif
                                    <span class="fa fa-inr"></span> {{ $price ? $price : $row->price }}
                                </h5>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </section>
            @endif


            <!-- Promo Banner -->
            <section style="display: none;" id="promo-banner" class="section-padding">
                <div class="container">
                    <div class="row">
                        <!--Left Side-->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-30">
                                    <!-- banner No.1 -->
                                    <div class="promo-banner-wrap">
                                        <a href="#" class="promo-image-wrap">
                                            <img src="{{ asset('assets/img/banner/promo-banner4.jpg') }}" alt="Accesories" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Right Side-->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-30">
                                    <!-- banner No.3 -->
                                    <div class="promo-banner-wrap">
                                        <a href="#" class="promo-image-wrap">
                                            <img src="{{ asset('assets/img/banner/promo-banner4.jpg') }}" alt="Accesories" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Promo Banner -->



            <!-- Latest (Tab with Slider) -->
            <section class="section-padding-b">
                <div class="container">
                    <h1 class="page-title">New Products</h1>
                </div>
                <div class="container">

                <?php $latestProduct = App\model\Product::limit(10)->orderby('created_at', 'DESC')->get(); ?>

                    @if( $latestProduct )
                    
                    <div id="new-product" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">

                        @foreach( $latestProduct as $row )
                        <!-- item.1 -->
                        <div class="product-item">
                            <div class="product-item-inner">
                                <div class="product-img-wrap">
                                    <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                        <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 260, 350 ) ) ) }}" alt="{{ $row->title }}">
                                        @if( $row->discount )
                                            <div class="sale-label discount">
                                                <span>{{ $row->discount }}% off</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
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
                            <div class="product-detail">
                                <a class="tag" href="#"></a>
                                <p class="product-title">
                                    
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ $row->title }}</a>
                                </p>
                                <div style="display: none;" class="product-rating">
                                    <div class="star-rating" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated 4 out of 5">
                                        <span style="width: 60%"></span>
                                    </div>
                                    <a href="#" class="product-rating-count"><span class="count">3</span> Reviews</a>
                                </div>
                                <p class="product-description">
                                    {{ $row->excerpt }}
                                </p>
                                <h5 class="item-price">                                    
                                    <?php $price = ''; ?>
                                    @if( $row->discount )
                                        <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                        <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                    @endif
                                    <span class="fa fa-inr"></span> {{ $price ? $price : $row->price }}
                                </h5>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else

                    @endif

                </div>
            </section>

            

            
            <!-- Review blocks -->
            <section class="section-padding testimonial">
                <div class="container">
                    <div class="home-about-blocks">
                        <div class="col-12">
                            <div class="row">
                                <!--Customer Say-->
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 customer-say">
                                    <div class="about-box-inner">
                                        <h1 class="mb-25">Customer Say</h1>

                                        <!--Customer Carousel-->
                                        <div class="testimonials-carousel owl-carousel owl-theme nf-carousel-theme1">
                                            <div class="product-item">
                                                <p class="large quotes">This is one of the best gift shop website.</p>
                                                <h6 class="quotes-people">- Rahul</h6>
                                            </div>
                                            <div class="product-item">
                                                <p class="large quotes">I am happy with service provided by SurpriseGenie.</p>
                                                <h6 class="quotes-people">- Vikas</h6>
                                            </div>
                                        </div>
                                        <!--End Customer Carousel-->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Review blocks -->



            <!-- Product (Tab with Slider) -->
            <section class="section-padding">
                <div class="container">
                    <h1 class="page-title">Shop by Category</h1>
                </div>
                <?php $menu = App\model\Post::where(['title' => 'shop by category', 'type' => 'menu'])->first(); ?>
                @if( $menu )
                    <?php $menu = json_decode( $menu->content ); ?>
                <div class="container">
                    <ul class="product-filter nav" role="tablist">
                        @foreach( $menu as $key => $m )
                            @if( $m->type === 'category' )
                            <?php $cat = App\model\Category::where('slug', $m->slug)->value('name'); ?>
                            <li class="nav-item">
                                <a class="nav-link {{ $key === 0 ? 'active' : '' }}" href="#{{ $m->slug }}" role="tab" data-toggle="tab">{{ $cat }}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <!-- Tab1 - Latest Product -->
                        
                    @foreach( $menu as $key => $m )
                        @if( $m->type === 'category' )
                        <?php 
                            $products = false;
                            $category = App\model\Category::where('slug', $m->slug)->first();
                            if( $category )
                                $products = $category->product()->orderby('id', 'DSEC')->paginate(10);
                        ?>
                        <div id="{{ $m->slug }}" role="tabpanel" class="tab-pane fade in {{ $key === 0 ? 'active' : '' }}">
                            @if( $category && $products && count( $products ) )
                            <div id="new-product" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">
                                <!-- item.1 -->
                                @foreach( $products as $row )
                                <div class="product-item">
                                    <div class="product-item-inner">
                                        <div class="product-img-wrap">
                                            <a href="{{ url('/'.$category->slug.'/'.$row->slug.'/'.$row->product_id.'?source=category') }}">
                                            <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 260, 350 ) ) ) }}" alt="{{ $row->title }}">
                                            @if( $row->discount )
                                                <div class="sale-label discount">
                                                    <span>{{ $row->discount }}% off</span>
                                                </div>
                                            @endif
                                            </a>
                                        </div>
                                        <div class="product-button">
                                            <a role="button" class="js_tooltip" id="addToCartProduct" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i></a>
                                            <a role="button" class="js_tooltip" id="addToWishlist" data-value="{{ $row->product_id }}" data-id="{{ $row->id }}" data-mode="top" data-tip="Add To Whishlist"><i class="fa {{ in_array( $row->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-detail">
                                        <a class="tag" href="#">Men Fashion</a>
                                        <p class="product-title">
                                            <a href="{{ url('/'.$category->slug.'/'.$row->slug.'/'.$row->product_id.'?source=category') }}">{{ $row->title }}</a>
                                        </p>
                                        <div class="product-rating">
                                            <div class="star-rating" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated 4 out of 5">
                                                <span style="width: 60%"></span>
                                            </div>
                                            <a href="#" class="product-rating-count"><span class="count">3</span> Reviews</a>
                                        </div>
                                        <p class="product-description">
                                            When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic remaining essentially unchanged.
                                        </p>
                                        <h5 class="item-price">                                    
                                            <?php $price = ''; ?>
                                            @if( $row->discount )
                                                <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                                <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                            @endif
                                            <span class="fa fa-inr"></span> {{ $price ? $price : $row->price }}
                                        </h5>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-center">No product found!</p>
                            @endif
                        </div>
                        @endif

                        @endforeach

                    </div>
                </div>
                @endif
            </section>
            <!-- End Product (Tab with Slider) -->


            <?php $all = App\model\Product::orderby('updated_at', 'DESC')->paginate(8); ?>
            @if( $all && count( $all ) )
            <section class="section-padding-b">
                <div class="container">
                    <h1 class="page-title">All Products</h1>
                </div>
                <div class="container all-product-container" id="all-product-container">
                    <?php $c = 0; ?>
                   @foreach( $all as $row )

                   @if( $c < 1 || $c === 4 )
                        <?php $c = 0; ?>
                        <?php echo '<div class="row product-list-item">'; ?>
                    @endif
                    <div class="product-item-element col-lg-3 col-md-3 col-sm-6 col-6">
                        <!-- item.1 -->
                        <div class="product-item">
                            <div class="product-item-inner">
                                <div class="product-img-wrap">
                                    <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">
                                        <img src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, 260, 350 ) ) ) }}" alt="{{ $row->title }}">
                                        @if( $row->discount )
                                            <div class="sale-label discount">
                                                <span>{{ $row->discount }}% off</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>
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
                            <div class="product-detail">
                                <a class="tag" href="#"></a>
                                <p class="product-title">
                                    
                                    <a href="{{ url('/' .$cat_slug . '/' . $row->slug . '/' . $row->product_id . '?source=home') }}">{{ $row->title }}</a>
                                </p>
                                <div style="display: none;" class="product-rating">
                                    <div class="star-rating" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated 4 out of 5">
                                        <span style="width: 60%"></span>
                                    </div>
                                    <a href="#" class="product-rating-count"><span class="count">3</span> Reviews</a>
                                </div>
                                <p class="product-description">
                                    {{ $row->excerpt }}
                                </p>
                                <h5 class="item-price">                                    
                                    <?php $price = ''; ?>
                                    @if( $row->discount )
                                        <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                        <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                    @endif
                                    <span class="fa fa-inr"></span> {{ $price ? $price : $row->price }}
                                </h5>
                            </div>
                        </div>
                    </div>

                    @if( $c === 3 )
                        <?php echo '</div>'; ?>
                    @endif

                    <?php $c++; ?>
                    @endforeach

                    @if( $c <= 3 )
                        <?php echo '</div>'; ?>
                    @endif

                    <div class="row mt-5">
                        <div class="col-lg-12 col-md-12 text-center">
                            <button data-id="1" id="loadMoreBtnHome" class="btn btn-primary btn-load-more">Load More</button>
                        </div>
                    </div>

                </div>
                
            </section>

    

            @endif

            {{ Form::open(['url' => route('subscribe'), 'id' => 'subscribeForm']) }}

            <div class="form-group">
                <label>Enter your email address *</label>
                <input type="email" name="email" class="form-control">
            </div>

            <button class="btn btn-primary" type="submit">Subscribe</button>

            {{ Form::close() }}

        </div>
        <!-- End Page Content Wraper -->


@endsection