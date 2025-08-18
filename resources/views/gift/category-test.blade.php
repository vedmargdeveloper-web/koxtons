@extends( _app() )

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-10">
                <nav class="breadcrumb-link" aria-label="breadcrumb" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px; ">
                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                    <span style="margin: 0 5px;">&raquo;</span>
                    
                    <a role="button" style="color: #007bff; text-decoration: none;">Category</a>
                    
                    @if($category)
                        <span style="margin: 0 5px;">&raquo;</span>
                        <span>{{ ucwords($category->name) }}</span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</section>

    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section class="content-page">
        <div class="container product-container" data-id="{{ $category ? $category->slug : '' }}">
            <div class="row">

                <!-- Product Content -->
                <div class="col-12">

                    @if( !empty( $products ) && !empty( $category ) )

                    <!-- Title -->
                    <div class="list-page-title row">
                        
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <h1 class="">{{ ucwords($category->name) }} <small> {{ $total }} Products</small></h1>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            {{ Form::open(['url' => route('product.category', $category->slug), 'class' => 'product-sort-by pull-right', 'id' => 'sorting-form', 'method' => 'GET']) }}
                                <label for="short-by">Short By</label>
                                <?php $sort_by = isset($_GET['sort-by']) && $_GET['sort-by'] ? $_GET['sort-by'] : 'latest'; ?>
                                <select name="sort-by" id="product-short-by" class="nice-select-box">
                                    <option {{  $sort_by === 'latest' ? 'selected' : '' }} value="latest">Latest</option>
                                    <option {{  $sort_by === 'low_to_high' ? 'selected' : '' }} value="low_to_high">Price: Low to High</option>
                                    <option {{  $sort_by === 'high_to_low' ? 'selected' : '' }} value="high_to_low">Price: High to Low</option>
                                </select>
                            {{ Form::close() }}
                            </div>
                            @if( $category->description )
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cat-desc">
                                    <?php echo $category->description; ?>
                                </div>
                            @endif
                        
                    </div>
                    <!-- End Title -->

                    <div class="row">
                        <div class="col-lg-12"><div class="border-bottom-1"></div></div>
                    </div> 


                    <!-- Product Grid -->

                    <?php $wishlist = Cookie::get('wishlistProduct'); ?>
                    <?php $wishListProduct = $wishlist ? json_decode( $wishlist ) : array(); ?>
                    
                        <!-- items -->
                    <?php $c = 0; ?>
                    @foreach( $products as $key => $row )
                        @if( $c < 1 || $c === 4 )
                            <?php $c = 0; ?>
                            <div class="row product-list-item">
                        @endif
                        <div class="product-item-element col-lg-3 col-md-3 col-sm-6 col-6">
                            <!--Product Item-->
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
                                        <span class="fa fa-inr"></span> {{ round($price)  }}
                                    </h5>
                                </div>
                            </div>
                            <!-- End Product Item-->
                        </div>

                        @if( $c === 3 )
                            </div>
                        @endif

                        <?php $c++; ?>

                        @endforeach
                        @if( $c <= 3 )
                            </div>
                        @endif

                        <div id="loadMoreRow"></div>

                    </div>
                    <!-- End Product Grid -->

                    <div class="pagination-wraper">
                        {{-- {{ $products->appends($_GET)->links() }} --}}
                    </div>


                @else

                    <p class="text-center">Oops! content not found</p>

                @endif

                </div>
                <!-- End Product Content -->

            </div>
        </div>
    </section>
    <!-- End Page Content -->

</div>
<!-- End Page Content Wraper -->


@endsection