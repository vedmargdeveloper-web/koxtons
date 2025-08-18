@extends( _app() )

<?php $image_url = ''; ?>

@if( $product )
<?php $image_url = asset( 'public/'. product_file( thumb( $product->feature_image, 130, 140 ) ) ); ?>
@endif

@section('og-url', current_url())
@section('og-type', 'product')
@section('og-title', $product ? $product->title : '')
@section('og-content', $product ? $product->excerpt : '')
@section('og-image-url', $image_url)

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">

    @if( isset( $product ) && $product )

    <?php $reviews = App\model\Review::where('product_id', $product->product_id)->orderby('created_at', 'DESC')->paginate(10); ?>

    <?php $category = App\model\Category::where('id', $product->category_id)->first(); ?>
    <?php $category_name = $category ? $category->name : ''; 
    $category_slug = $category ? $category->slug : '';  ?>

    <!-- Bread Crumb -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="breadcrumb-link">
                        <a href="{{ url('/') }}">Home</a>
                            <a href="{{ url('/' . $category_slug) }}">
                            {{ ucwords( $category_name ) }}</a>
                        <span>{{ ucwords($product->title) }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section id="product-{{ $product->product_id }}" class="content-page single-product-content">

        <!-- Product -->
        <div id="product-detail" class="container">
            <div class="row">

                <?php $agent = new Jenssegers\Agent\Agent(); ?>

                @if( $agent->isDesktop() )
                <!-- Product Image -->
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                    <div class="product-page-image">
                        <!-- Slick Image Slider -->
                        <div class="product-image-slider product-image-gallery" id="product-image-gallery" data-pswp-uid="3">
                            <div class="item">
                                <img id="img_01" src="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" data-zoom-image="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}"/>
                            </div>
                        </div>
                        <!-- End Slick Image Slider -->
                    </div>

                    <!-- Slick Thumb Slider -->
                    <div id="gal1" class="product-image-slider-thumbnails">
                        <div class="item">
                            <a href="#" data-image="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" data-zoom-image="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}">
                                <img id="img_01" src="{{ $image_url }}" />
                            </a>
                        </div>
                        @if( isset($product->media[0]->files) )
                            <?php $files = explode(',', $product->media[0]->files); ?>
                            @foreach( $files as $file )
                                 <div class="item">
                                    <a href="#" data-image="{{ asset( 'public/'. product_file( $file ) ) }}" data-zoom-image="{{ asset( 'public/'. product_file( $file ) ) }}">
                                        <img id="img_01" src="{{ asset( 'public/'. product_file( thumb( $file, 130, 140 ) ) ) }}" />
                                    </a>
                                </div>                                    
                            @endforeach
                        @endif
                       
                    </div>
                    <!-- End Slick Thumb Slider -->
                </div>
                <!-- End Product Image -->

                @else

                <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                    <div class="product-page-image">
                        <!-- Slick Image Slider -->
                        <div class="product-image-slider product-image-gallery" id="product-image-gallery" data-pswp-uid="3">
                            <div class="item">
                                <div class="" data-src="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" data-image="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}">
                                    <img class="" src="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}">
                                </div>
                            </div>
                            @if( isset($product->media[0]->files) )
                                <?php $files = explode(',', $product->media[0]->files); ?>
                                @foreach( $files as $file )
                                    <div class="item">
                                        <div class="" data-src="{{ asset( 'public/'. product_file( $file ) ) }}" data-image="{{ asset( 'public/'. product_file( $file ) ) }}">
                                        <img class="" src="{{ asset( 'public/'. product_file( $file ) ) }}">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- End Slick Image Slider -->
                    </div>

                    <!-- Slick Thumb Slider -->
                    <div class="product-image-slider-thumbnails">
                        <div class="item">
                            <img src="{{ $image_url }}" alt="{{ ucwords( $product->title ) }}"/>
                        </div>
                        @if( isset($product->media[0]->files) )
                            <?php $files = explode(',', $product->media[0]->files); ?>
                            @foreach( $files as $file )
                                 <div class="item">
                                    <img src="{{ asset( 'public/'. product_file( thumb( $file, 130, 140 ) ) ) }}" alt="{{ ucwords( $product->title ) }}" />
                                </div>
                            @endforeach
                        @endif
                       
                    </div>
                    <!-- End Slick Thumb Slider -->
                </div>
                <!-- End Product Image -->

                @endif

                <!-- Product Content -->
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                    <div class="product-page-content">
                        <h1 class="product-title">{{ ucwords( $product->title ) }}</h1>
                        <?php $totalrating = $reviews && count($reviews) ? $reviews->sum('rating') / count( $reviews ) : false;  ?>
                        <div style="" class="product-rating">
                            @if( $totalrating )
                            <div class="star-rating star-rating-{{ str_replace('.', '-', $totalrating) }}" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated {{ $totalrating }} out of 5">
                                <span style="width: 60%"></span>
                            </div> {{ $totalrating }}
                            @endif
                            <a role="button" id="tabReview" class="product-rating-count"><span class="count">{{ count($reviews) }}</span> Reviews</a>
                        </div>
                        <div class="product-price">
                            <?php $price = ''; ?>
                            @if( $product->discount )
                            <?php $price = $product->price - ( $product->price * $product->discount ) / 100; ?>
                            <del><span class="fa fa-inr"></span> {{ $product->price }}</del>
                            @endif
                            <span><span class="fa fa-inr"></span> 
                            <span class="product-price-text">{{ $price ? $price : $product->price }}</span>
                            @if( $product->discount)
                                <sup class="discount-off">{{ $product->discount.'% off' }}</sup>
                            @endif
                            </span>
                        </div>
                        <p class="product-description">
                            @if( $product->excerpt )
                            <h3>About This Item</h3>
                            {{ ucfirst( $product->excerpt ).'...' }} 
                            <a class="description active" id="readMoreTab" href="{{ current_url().'#read-more' }}" role="tab" data-toggle="tab">Read more</a>
                            @endif
                        </p>
                        <div class="row product-filters">
                            <form>
                            <div class="col-md-6 filters-color">
                                @if( $product->productMeta[0]->color )
                                    <label for="select-color">Select Color</label>
                                    
                                    <?php $color = explode(',', $product->productMeta[0]->color); ?>
                                    <div class="color-selector">
                                        @foreach( $color as $key => $c )
                                            <div class="entry {{ $key < 1 ? 'active' : '' }}" style="background: {{ $c }};">&nbsp;</div>
                                        @endforeach
                                    </div>
                                @endif
                                
                            </div>
                        
                            @if( $product->available < 1 )
                                <span class="not-available">Our of stock</span>
                            @endif
                            <div class="single-variation-wrap">
                                <?php $qty = 1; ?>
                                @if( Session::has('addToCartProduct') && $cartProducts = Session::get('addToCartProduct') )
                                    @if( array_key_exists($product->product_id, $cartProducts) )
                                        <?php $qty = $cartProducts[$product->product_id]['quantity']; ?>
                                    @endif
                                @endif
                                <div class="product-quantity">
                                    <span data-value="+" class="quantity-btn quantityPlus"></span>
                                    <input id="itemQuantity" class="quantity input-lg" step="1" min="1" max="9" name="quantity" value="{{ $qty }}" title="Quantity" type="number" />
                                    <span data-value="-" class="quantity-btn quantityMinus"></span>
                                </div>

                                <button type="submit" id="addToCartProduct" data-value="{{ $product->product_id }}" data-id="{{ $product->id }}" class="btn btn-lg btn-black"><i class="fa fa-shopping-bag" aria-hidden="true"></i>Add to cart</button>
                            </div>
                            </form>
                        </div>
                        {{ Form::open(['url' => route('availability'), 'id' => 'checkAvailability']) }}
                        <div class="single-variation-wrap">
                            <label>Check delivery availability</label>
                            <div class="input-group">
                                <input type="text" name="pincode" class="form-control" placeholder="Enter your area pincode" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button type="submit" id="checkDeliveryAvailability" class="btn btn-primary" name="Check">Check</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <?php $wishListProduct = array(); ?>
                        @if( Cookie::get('wishlistProduct') )
                            <?php $wishListProduct = json_decode( Cookie::get('wishlistProduct') ); ?>
                        @endif
                        <div class="single-add-to-wrap">
                            <a role="button" class="single-add-to-wishlist" id="addToWishlist" data-value="{{ $product->product_id }}" data-id="{{ $product->id }}" data-mode="top" data-tip="Add To Whishlist">
                                <i class="fa {{ in_array( $product->product_id, $wishListProduct ) ? 'fa-heart' : 'fa-heart-o' }}"></i> 
                                <span>Add to Wishlist</span>
                            </a>

                            <a class="single-add-to-compare" href="{{ route('cart') }}"><i class="fa fa-shopping-bag left" aria-hidden="true"></i><span>View Cart</span></a>
                        </div>
                        <div class="product-meta">
                            <span style="display: none;">SKU : <span class="sku" itemprop="sku">005687</span></span>
                            <span>Category : 
                                <span class="category" itemprop="category">
                                    {{ $category_name }}
                                </span>
                            </span>
                        </div>
                        <div class="product-share">
                            <span>Share :</span>
                            <ul>
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ current_url() }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="http://twitter.com/share?url={{ current_url() }}" target="_blank">
                                    {{-- <i class="fa fa-twitter"></i> --}}
                                    <span class="icon-wrapper">
                                        <svg class="fa-twitter" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox=" 0 -5 30 30">
                                            <path d="M26.37,26l-8.795-12.822l0.015,0.012L25.52,4h-2.65l-6.46,7.48L11.28,4H4.33l8.211,11.971L12.54,15.97L3.88,26h2.65 l7.182-8.322L19.42,26H26.37z M10.23,6l12.34,18h-2.1L8.12,6H10.23z"></path>
                                        </svg>
                                    </span>
                                </a></li>
                                <li><a href="http://plus.google.com/share?url={{ current_url() }}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="mailto:?subject=Check this {{ current_url() }}" target="_blank"><i class="fa fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Product -->

        @if( Session::has('review_err') || Session::has('review_msg') || count($errors) )
            <script type="text/javascript">
                $(document).ready(function($) {
                    $('html, body').animate({
                        scrollTop: $("#otherDetails").offset().top
                    }, 2000);
                }); 
            </script>
        @endif

        <!-- Product Content Tab -->
        <div id="otherDetails" class="product-tabs-wrapper container">
            <ul class="product-content-tabs nav nav-tabs" role="tablist">

                <li class="nav-item">
                    <a class="description {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? '' : 'active' }}" href="#tab_description" role="tab" data-toggle="tab">Descriptiont</a>
                </li>
                
                <li class="nav-item">
                    <a class="review {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? 'active' : '' }}" href="#tab_reviews" role="tab" data-toggle="tab">Reviews (<span>{{ count($reviews) }}</span>)</a>
                </li>

            </ul>
            <div class="product-content-Tabs_wraper tab-content container">
                <div id="tab_description" role="tabpanel" class="tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? '' : 'in active show' }}">
                    <!-- Accordian Title -->

                    <div id="tab_description-coll" class="shop_description product-collapse container">
                        <div class="row">
                            <?php echo ucfirst($product->content); ?>
                        </div>
                    </div>
                    <!-- End Accordian Content -->
                </div>

                
                <div id="tab_reviews" role="tabpanel" class="reviews tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? 'in active show' : '' }}">
                    <!-- Accordian Title -->
                    <div id="tab_reviews-coll" class=" product-collapse container">
                        <div class="row">
                            <div class="review-form-wrapper col-md-6">
                                @auth
                                @else
                                    <span>You have not logged in</span>
                                @endauth
                                
                                @if( Session::has('review_err') )
                                    <span class="text-danger">{{ Session::get('review_err') }}</span>
                                @endif
                                <form method="POST" class="comment-form" action="{{ route('review.store') }}">
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    {{ csrf_field() }}
                                    @if( $errors->has('star') )
                                        <span class="text-danger">{{ $errors->first('star') }}</span>
                                    @endif
                                    <div class="form-field-wrapper">
                                        <div class="stars">
                                            <input class="star star-5" value="5" id="star-5" type="radio" name="star"/>
                                            <label class="star star-5" for="star-5"></label>
                                            <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                            <label class="star star-4" for="star-4"></label>
                                            <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                            <label class="star star-3" for="star-3"></label>
                                            <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                            <label class="star star-2" for="star-2"></label>
                                            <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                            <label class="star star-1" for="star-1"></label>
                                        </div>
                                    </div>

                                    @if( $errors->has('review') )
                                        <span class="text-danger">{{ $errors->first('review') }}</span>
                                    @endif
                                    <div class="form-field-wrapper">
                                        <label>Your Review <span class="required">*</span></label>
                                        <textarea id="comment" class="form-full-width" name="review" cols="45" rows="8" aria-required="true" >{{ old('review') }}</textarea>
                                    </div>
                                    @auth
                                    @else
                                    <div class="form-field-wrapper">
                                        <label>Name <span class="required">*</span></label>
                                        <input id="author" class="input-md form-full-width" name="author" value="" size="30" aria-required="true" required="" type="text">
                                    </div>
                                    <div class="form-field-wrapper">
                                        <label>Email <span class="required">*</span></label>
                                        <input id="email" class="input-md form-full-width" name="email" value="" size="30" aria-required="true" required="" type="email">
                                    </div>
                                    @endauth
                                    <div class="form-field-wrapper">
                                        <input name="submit" id="submit" class="submit btn btn-md btn-color" value="Submit" type="submit">
                                    </div>
                                </form>
                            </div>
                            <div class="comments col-md-6">
                                <h6 class="review-title">Customer Reviews</h6>
                                <!--<p class="review-blank">There are no reviews yet.</p>-->
                                
                                @if( $reviews && count($reviews) )
                                <ul class="commentlist">

                                    @foreach( $reviews as $review )
                                    <li id="comment-101" class="comment-101">
                                        <div class="comment-text">
                                            <div class="star-rating star-rating-{{ $review->rating }}" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated {{ $review->rating }} out of 5">
                                            </div>
                                            <p class="meta">
                                                <strong itemprop="author">{{ ucwords($review->name) }}</strong>
                                                &nbsp;&mdash;&nbsp;
                                            <time itemprop="datePublished" datetime="">{{ date('d m, Y', strtotime($review->created_at)) }}</time>
                                            </p>
                                            <div class="description" itemprop="description">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @else

                                <p>No review yet.</p>

                                @endif
                                    
                            </div>
                        </div>
                    </div>
                    <!-- End Accordian Content -->
                </div>

            </div>
        </div>
        <!-- End Product Content Tab -->

        <!-- Product Carousel -->
        <div class="container product-carousel">
            <h2 class="page-title">Related Products</h2>
            <div id="new-tranding" class="product-item-5 owl-carousel owl-theme nf-carousel-theme1">
                <?php $category = App\model\Category::where('slug', $category_slug)->first();
                    $related_products = false;
                    if( $category )
                        $related_products = $category->product()->where('product_id', '!=', $product->product_id)
                                                        ->orderby('id', 'DESC')->paginate(10);
                ?>
                <!-- item.1 -->
                @if( $related_products )
                    @foreach( $related_products as $row )
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
                                    <a href="{{ url('/'.$category->slug.'/'.$row->slug.'/'.$row->product_id.'?source=category') }}">{{ $row->title }}</a></p>
                                <div class="product-rating">
                                    <div class="star-rating" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating" title="Rated 4 out of 5">
                                        <span style="width: 60%"></span>
                                    </div>
                                    <a href="#" class="product-rating-count"><span class="count">3</span> Reviews</a>
                                </div>
                                <p class="product-description">
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
                        <!-- End Product Item-->
                    @endforeach

                @endif

            </div>
        </div>
        <!-- End Product Carousel -->

    </section>
    <!-- End Page Content -->

    @else

    <section class="section-padding text-center">
        <h3>Oops! Looks like this product is not found.</h3>
    </section>

    @endif

</div>


@endsection