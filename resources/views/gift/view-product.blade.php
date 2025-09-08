@extends( _app() )

<?php $image_url = ''; ?>

@if( $product )
<?php $image_url = asset( 'public/'. product_file( thumb( $product->feature_image, 130, 140 ) ) ); ?>
@endif

@section('og-url', current_url())
@section('og-type', 'product')
{{-- @section('og-title', $product ? $product->title : '') --}}
@section('og-title', $product ? ($product->metatitle ?? $product->title) : '')
@section('og-content', $product ? $product->excerpt : '')
@section('og-image-url', $image_url)

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">

    @if( isset( $product ) && $product )

    <?php $reviews = App\model\Review::where('product_id', $product->product_id)->orderby('created_at', 'DESC')->paginate(10); ?>

    <?php $category = App\model\Category::where('id', $product->category_id)->first(); ?>
    <?php $parentcategory = $category ? App\model\Category::where('id', $category->parent)->first() : false; ?>
    <?php $category_name = $category ? $category->name : ''; 
    $category_slug = $category ? $category->slug : '';  ?>

    <!-- Bread Crumb -->
    <section class="">
        <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <nav class="breadcrumb-link">
                            <a href="{{ url('/') }}">Home</a>
                                @if( $parentcategory )
                                    <a href="{{ url('/' . $parentcategory->slug) }}">
                                    {{ ucwords( $parentcategory->name ) }}</a>
                                    <a href="{{ url('/' . $parentcategory->slug.'/'.$category_slug) }}">
                                    {{ ucwords( $category_name ) }}</a>
                                @else
                                    <a href="{{ url('/' . $category_slug) }}">{{ ucwords( $category_name ) }}</a>
                                @endif
                            <span>{{ ucwords($product->title) }}</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bread Crumb -->

    

    <!-- Page Content -->
    <section id="product-{{ $product->product_id }}" class="content-page single-product-content">

        <!-- Product -->
        <div id="product-detail" class="container-fluid">

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-30">

                        <div class="product-page-image">
                            <!-- Slick Image Slider -->
                            <div class="product-image-slider product-image-gallery" id="product-image-gallery" data-pswp-uid="3">
                                <div class="item">
                                    <a class="product-gallery-item" href="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" data-size="" data-med="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" data-med-size="">
                                        <img src="{{ asset( 'public/'. product_file( $product->feature_image ) ) }}" alt="{{ $row->feature_image_alt ?? $row->title }}" />
                                    </a>
                                </div>

                                <?php $medias = false; ?>
                                @if( isset($product->media[0]) && count( $product->media ) > 0 )
                                    <?php $medias = $product->media ?>
                                    @foreach( $medias as $media )
                                        @if( $media->type === 'gallery' )
                                            <?php $files = explode(',', $media->files); ?>
                                            @foreach( $files as $file )
                                                <div class="item">
                                                    <a class="product-gallery-item" href="{{ asset( 'public/'. product_file( $file ) ) }}" data-size="" data-med="{{ asset( 'public/'. product_file( $file ) ) }}" data-med-size="">
                                                        <img src="{{ asset( 'public/'. product_file( $file ) ) }}" alt="{{ $product->file_alt ?? 'Gallery Image' }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                            <!-- End Slick Image Slider -->
                            <a href="javascript:void(0)" id="zoom-images-button" class="zoom-images-button"><i class="fa fa-expand" aria-hidden="true"></i></a>
                        </div>

                        <!-- Slick Thumb Slider -->
                        <div class="product-image-slider-thumbnails">
                            <div class="item">
                                <img src="{{ $image_url }}" alt="image 1" />
                            </div>
                            @if( $medias )
                                @foreach( $medias as $media )
                                    @if( $media->type === 'gallery' )
                                        <?php $files = explode(',', $media->files); ?>
                                        @foreach( $files as $file )
                                             <div class="item">
                                                <img src="{{ asset( 'public/'. product_file( thumb( $file, 130, 140 ) ) ) }}"  alt="{{ $product->file_alt ?? 'Gallery Image' }}" title="{{ $media->title ?? '' }}" />
                                            </div>                                    
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                           
                        </div>

                    </div>
                    <!-- End Product Image -->

                    <!-- Product Content -->
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-30 pl-0">
                        <div class="product-page-content">
                            <h1 class="product-title">{{ ucwords( $product->title ) }}</h1>
                            <?php $totalrating = $reviews && count($reviews) ? $reviews->sum('rating') / count( $reviews ) : false;  ?>
                            <div style="" class="product-rating">
                                @if( $totalrating )
                                <div class="star-ratings-sprite" title="Rated {{ $totalrating }} out of 5">
                                    <span style="width:{{ $totalrating * 10 * 2 }}%;" class="star-ratings-sprite-rating"></span>
                                </div> {{ $totalrating }}
                                @endif
                                <a role="button" id="tabReview" class="product-rating-count"><span class="count">{{ count($reviews) }}</span> Reviews</a>
                            </div>
                            <div class="product-price product-price-wrapper">
                                @if( $product->price_range )
                                     <span><span class="fa fa-inr"></span> 
                                    <span class="product-price-text">{{ $product->price_range  }}</span>
                                    </span>
                                @else

                                    <?php $price = $product->price; ?>
                                    @if( $product->discount )
                                    <?php $price = $product->price - ( $product->price * $product->discount ) / 100; ?>
                                    <del><span class="fa fa-inr"></span> {{ $product->price }}</del>
                                    @endif
                                    <span><span class="fa fa-inr"></span> 
                                    <span class="product-price-text">{{ round($price)  }}</span>
                                    @if( $product->discount)
                                        <sup class="discount-off">{{ $product->discount.'% off' }}</sup>
                                    @endif
                                    </span>
                                @endif
                            </div>
                            <div class="product-description">
                                @if( $product->excerpt )
                                <h3>About This Item</h3>
                                    <p>{{ ucfirst( get_excerpt($product->excerpt, 20) ).'...' }} 
                                     <a class="description active" id="readMoreTab" href="{{ current_url().'#read-more' }}" role="tab" data-toggle="tab">Read more</a>
                                    </p>
                                @endif

                                <?php $video = ''; ?>
                                @if( isset($product->media[0]) && count( $product->media ) > 0 )
                                    @foreach( $product->media as $media )
                                        @if( $media->type === 'video' )
                                            <?php $video = $media->files; ?>
                                        @endif
                                    @endforeach
                                @endif
                                @if( $video )
                                <p>
                                    <a role="button" title="Watch Video" class="product-video">
                                        <img style="width:30px;" src="{{ asset('assets/img/video-icon.png') }}" alt="{{ $product->file_alt ?? '' }}">
                                    </a>
                                </p>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product-filters">

                                <form class="product-add-to-cart-form" data-id="{{ $product->id }}" data-product="{{ $product->product_id }}">

                                    {{ csrf_field() }}

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row filter-row">
                                        @if( $product->productMeta[0]->color )
                                            <div class="col-md-12 filters-color mb-3">
                                                <label for="select-color">Select Color</label>
                                                <?php $color = explode(',', $product->productMeta[0]->color); ?>
                                                <div class="color-selector">
                                                    @foreach( $color as $key => $c )
                                                        <div data-value="{{ $c }}" class="color entry {{ $key < 1 ? 'active' : '' }}" title="{{ ucwords($c) }}" style="background: {{ $c }};">&nbsp;</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        

                                        <?php $custom_size = []; ?>
                                        <?php $tsizes = []; ?>
                                        @if( $product->product_attribute_meta )
                                        <?php $attrCSize = App\model\ProductAttributeMeta::where(['product_id' => $product->id])->first(); ?>
                                            
                                            @if( $attrCSize )
                                                @foreach( $product->product_attribute_meta as $meta )
                                                    @if( $meta->type === 'custom_size' )
                                                        <?php $json = json_decode($meta->value); ?>
                                                        @if( $json && isset( $json->name ) && $json->name )
                                                            <?php $custom_size[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name]; ?>
                                                        @endif
                                                    @else
                                                        @if( $meta->type === 'size' )
                                                            <?php $json = json_decode($meta->value); ?>
                                                            @if( $json && isset( $json->name ) && $json->name )
                                                                <?php $tsizes[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name, 'stock' => $json->stock];
                                                                ?>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                        
                                        @if( $custom_size && count( $custom_size ) > 0 )
                                            <?php $label = $product->product_attribute->where('attribute_name', 'custom_size')->first(); ?>
                                            <div class="col-md-12 filters-color mb-3">
                                                <label for="select-color">{{ isset($label->label) ? $label->label : '' }}</label>
                                                <div class="color-selector select-product-cm-size">
                                                @foreach( $custom_size as $key => $size )
                                                    <div data-product="{{ $product->product_id }}" data-value="{{ $size['id'] }}" data-type="{{ $size['type'] }}" class="color product-cm-size entry {{ $key < 1 ? 'active' : '' }}" title="{{ ucfirst($size['name']) }}" style="">&nbsp;</div> <span style="padding-right: 10px;">{{ ucfirst($size['name']) }}</span>
                                                @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                    </div>


                                    @if( $tsizes && count( $tsizes ) > 0 )
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row filter-row filters-size mb-2">
                                            <label for="select-color">Select Size</label>
                                            <div class="color-selector size-selector">
                                                @foreach( $tsizes as $key => $meta )
                                                    @if( $meta['stock'] <= 0 )
                                                        <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size disabled" title="Out of Stock" style="">N/A</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                    @else
                                                        <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size-attribute-selector size entry {{ $key < 1 ? 'active' : '' }}" title="{{ ucwords($meta['name']) }}" style="">&nbsp;</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    


                                
                                    @if( $product->available < 1 )
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row filter-row">
                                                <span class="not-available">Our of stock</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row filter-row">
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

                                                <button type="submit" data-value="{{ $product->product_id }}" data-id="{{ $product->id }}" class="btn btn-lg btn-black"><i class="fa fa-shopping-bag" aria-hidden="true"></i>Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
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
                                <div id="otherDetails"></div>
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

                            @if( isset($product->buy_also) && $product->buy_also )
                                <div class="product-frequently">
                                    <span><strong>Buy It Also:</strong></span>
                                    <?php $frequently = App\model\Product::where('id', $product->buy_also)->first(); ?>
                                    @if( $frequently )
                                        <div class="product-item">
                                            <div class="product-item-inner">
                                                <div class="product-img-wrap">
                                                    <a href="{{ url('/'.$category_slug.'/'.$frequently->slug.'/'.$frequently->product_id.'?source=product') }}">
                                                    <img src="{{ asset( 'public/'. product_file( thumb( $frequently->feature_image, 130, 140 ) ) ) }}" alt="{{ $frequently->feature_image_alt ?? $frequently->title }}">
                                                    @if( $frequently->discount )
                                                        <div class="sale-label discount">
                                                            <span>{{ $frequently->discount }}% off</span>
                                                        </div>
                                                    @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-detail">
                                                <a class="tag" href="#"></a>
                                                <p class="product-title">
                                                    <a href="{{ url('/'.$category_slug.'/'.$frequently->slug.'/'.$frequently->product_id.'?source=product') }}">{{ $frequently->title }}</a></p>
                                                <h5 class="item-price" style="display: block;">                                    
                                                    <?php $price = $frequently->price; ?>
                                                    @if( $frequently->discount )
                                                        <del><sub><span class="fa fa-inr"></span> {{ $frequently->price }}</sub></del>
                                                        <?php $price = $frequently->price - ( $frequently->price * $frequently->discount ) / 100; ?>
                                                    @endif
                                                    <span class="fa fa-inr"></span> {{ round($price) }}
                                                </h5>
                                                @if( $frequently->available > 0 )
                                                    <a role="button" class="btn btn-lg btn-black" id="addToCartProduct" data-value="{{ $frequently->product_id }}" data-id="{{ $frequently->id }}" data-mode="top" data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i> Add</a>
                                                @else
                                                    <div class="out-stock">
                                                        <span>Out of stock</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            

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
        <div class="product-tabs-wrapper container-fluid">

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                <ul class="product-content-tabs nav nav-tabs" role="tablist">
                    @if( $product->description )
                        <li class="nav-item">
                            <a class="description {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? '' : 'active' }}" href="#tab_description" role="tab" data-toggle="tab">Description</a>
                        </li>
                    @endif
                    
                    <li class="nav-item">
                        <a class="{{ !$product->description ? 'active' : '' }} review {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? 'active' : '' }}" href="#tab_reviews" role="tab" data-toggle="tab">Reviews (<span>{{ count($reviews) }}</span>)</a>
                    </li>
                </ul>

                <div class="product-content-Tabs_wraper tab-content">
                    @if( $product->description )
                        <div id="tab_description" role="tabpanel" class="tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? '' : 'in active show' }}">
                            <!-- Accordian Title -->

                            <div id="tab_description-coll" class="shop_description product-collapser">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="row">
                                        <?php echo ucfirst($product->content); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End Accordian Content -->
                        </div>
                    @endif

                    <div id="tab_reviews" role="tabpanel" class="{{ !$product->description ? 'active show' : '' }} reviews tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? 'in active show' : '' }}">
                        <div id="tab_reviews-coll" class=" product-collapse">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
                                                <label>Your Review</label>
                                                <textarea id="comment" class="form-full-width" name="review" cols="45" rows="8" aria-required="true" >{{ old('review') }}</textarea>
                                            </div>
                                            
                                            @if( $errors->has('name') )
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                            <div class="form-field-wrapper">
                                                <label>Name <span class="required">*</span></label>
                                                <input id="name" class="input-md form-full-width" name="name" value="{{ Auth::check() ? Auth::user()->first_name.' '.Auth::user()->last_name : '' }}"  required="" type="text">
                                            </div>

                                            @if( $errors->has('email') )
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                            <div class="form-field-wrapper">
                                                <label>Email <span class="required">*</span></label>
                                                <input id="email" class="input-md form-full-width" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" size="30" aria-required="true" required="" type="email">
                                            </div>
                                            
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Product Content Tab -->

        <!-- Product Carousel -->
        <div class="container-fluid product-carousel">

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center">

                <h2 class="page-title">Related Products</h2>
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
                                        <?php $price = $row->price; ?>
                                        @if( $row->discount )
                                            <del><sub><span class="fa fa-inr"></span> {{ $row->price }}</sub></del>
                                            <?php $price = $row->price - ( $row->price * $row->discount ) / 100; ?>
                                        @endif
                                        <span class="fa fa-inr"></span> {{ round($price) }}
                                    </h5>
                                </div>
                            </div>
                            <!-- End Product Item-->
                        @endforeach

                    @endif

                </div>
            </div>
        </div>
        <!-- End Product Carousel -->

    </section>
    <!-- End Page Content -->

        <?php $video = ''; ?>
        @if( isset($product->media[0]) && count( $product->media ) > 0 )
            @foreach( $product->media as $media )
                @if( $media->type === 'video' )
                    <?php $video = $media->files; ?>
                @endif
            @endforeach
        @endif

        @if( $video )
            <section class="video-overlay">
                <div class="subs-popup">
                    <a href="javascript:void(0)" class="close-popup">
                        <span class="fa fa-close"></span>
                    </a>
                    <iframe height="300" style="width: 100%;" src="{{ $video.'?rel=0' }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </section>
        @endif

    @else

    <section class="section-padding text-center">
        <h3>Oops! Looks like this product is not found.</h3>
    </section>

    @endif

</div>


@endsection