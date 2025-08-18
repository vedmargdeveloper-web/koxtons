@extends( _app() )

@section('content')

@if(!empty($category))
    @section('og-url', current_url())
    @section('og-type', 'Category')
    
    @if( $category->metatitle !==NULL)
        @section('og-title', $category->metatitle ?? '')
    @else
        @section('og-title', $title)
    @endif

    @section('og-keywords',$category->metakey ?? '')
    @section('og-content', $category->metadescription ?? '')
@endif

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Page Content -->
    <section class="content-page products-page">

        <div class="container product-container category" data-id="{{ $parent }}" data-type="new">

            <div class="row">

                <div class="col-3">
                    <div class="product-filter-wrapper">
                        <form class="filter-form" action="{{ url('/') }}">
                            <div class="product-filter-row">
                                <div class="filter-title">
                                    <span>Categories</span>
                                    <span class="plus-sign"></span>
                                </div>
                                <div class="filter-content-categories filter-content" style="display: none;">
                                    <?php $categories = App\model\Category::all(); $c = 0; ?>
                                    @if( $categories && count($categories) >0 )
                                        <ul class="filter-list simple-radio">
                                        @foreach( $categories as $key => $cat )
                                            @if( !$cat->parent )
                                                <li class="filter-item">
                                                    <p class="filter expand-list">
                                                        <span class="plus-sign"></span>
                                                        <input type="radio" name="category" id="{{ $cat->slug.++$c }}" value="{{ $cat->slug }}">
                                                        <label class="radio" for="{{ $cat->slug.$c }}">
                                                            {{ ucwords($cat->name) }}
                                                        </label>
                                                    </p>
                                                    <ul class="filter-list child-category">
                                                        @foreach( $categories as $child )
                                                            @if( $cat->id == $child->parent )
                                                            <li class="filter-item">
                                                                <p class="filter">
                                                                    <input class="" type="radio" name="category" id="{{ $child->slug.++$c }}" value="{{ $child->slug }}">
                                                                    <label class="radio" for="{{ $child->slug.$c }}">
                                                                        {{ ucwords($child->name) }}
                                                                    </label>
                                                                </p>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="product-filter-row">
                                <div class="filter-title">
                                    <span>Price</span>
                                    <span class="plus-sign"></span>
                                </div>
                                <div class="filter-content-price filter-content" style="display: none;">
                                    <input id="min" class="filter-price" name="min" value="" placeholder="Min price" type="text">
                                    <input id="max" name="max" class="filter-price" value="" placeholder="Max price" type="text">
                                    <button class="btn btn-go filter-price-btn">Go</button>
                                </div>
                            </div>


                            <div class="product-filter-row" style="display:none;">
                                <div class="filter-title">
                                    <span>Color</span>
                                </div>
                                <div class="filter-content-colors">
                                    <?php $colors = ['AliceBlue', 'AntiqueWhite', 'Aqua', 'Aquamarine', 'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond', 'Blue', 'BlueViolet', 'Brown', 'BurlyWood', 'CadetBlue', 'Chartreuse', 'Chocolate', 'Coral', 'CornflowerBlue', 'Cornsilk', 'Crimson', 'Cyan', 'DarkBlue', 'DarkCyan', 'DarkGoldenRod', 'DarkGray', 'DarkGrey', 'DarkGreen', 'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'DarkOrange', 'DarkOrchid', 'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray', 'DarkSlateGrey', 'DarkTurquoise', 'DarkViolet', 'DeepPink', 'DeepSkyBlue', 'DimGray', 'DimGrey', 'DodgerBlue', 'FireBrick', 'FloralWhite', 'ForestGreen', 'Fuchsia', 'Gainsboro', 'GhostWhite', 'Gold', 'GoldenRod', 'Gray', 'Grey', 'Green', 'GreenYellow', 'HoneyDew', 'HotPink', 'IndianRed', 'Indigo', 'Ivory', 'Khaki', 'Lavender', 'LavenderBlush', 'LawnGreen', 'LemonChiffon', 'LightBlue', 'LightCoral', 'LightCyan', 'LightGoldenRodYellow', 'LightGray', 'LightGrey', 'LightGreen', 'LightPink', 'LightSalmon', 'LightSeaGreen', 'LightSkyBlue', 'LightSlateGray', 'LightSlateGrey', 'LightSteelBlue', 'LightYellow', 'Lime', 'LimeGreen', 'Linen', 'Magenta', 'Maroon', 'MediumAquaMarine', 'MediumBlue', 'MediumOrchid', 'MediumPurple', 'MediumSeaGreen', 'MediumSlateBlue', 'MediumSpringGreen', 'MediumTurquoise', 'MediumVioletRed', 'MidnightBlue', 'MintCream', 'MistyRose', 'Moccasin', 'NavajoWhite', 'Navy', 'OldLace', 'Olive', 'OliveDrab', 'Orange', 'OrangeRed', 'Orchid', 'PaleGoldenRod', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'PapayaWhip', 'PeachPuff', 'Peru', 'Pink', 'Plum', 'PowderBlue', 'Purple', 'RebeccaPurple', 'Red', 'RosyBrown', 'RoyalBlue', 'SaddleBrown', 'Salmon', 'SandyBrown', 'SeaGreen', 'SeaShell', 'Sienna', 'Silver', 'SkyBlue', 'SlateBlue', 'SlateGray', 'SlateGrey', 'Snow', 'SpringGreen', 'SteelBlue', 'Tan', 'Teal', 'Thistle', 'Tomato', 'Turquoise', 'Violet', 'Wheat', 'White', 'WhiteSmoke', 'Yellow', 'YellowGreen'];
                                    ?>
                                    <ul class="filter-list simple-radio">
                                        @foreach( $colors as $key => $color )
                                            <li class="filter-item">
                                                <p class="filter">
                                                    <input type="radio" name="color" id="{{ slug($color).$key }}" value="">
                                                    <label class="radio" for="{{ slug($color).$key }}">
                                                        {{ ucwords($color) }} <span class="color-square" style="background: {{ $color  }}"></span>
                                                    </label>
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="featured-product-row">
                        <div class="row-title">Featured Product</div>
                        <?php $featured = App\model\Product::with('product_category')->where(['type' => 'featured', 'status' => 'active'])->limit(4)->orderby('updated_at', 'DESC')->get(); ?>
                        @if( $featured && count( $featured ) )
                            @foreach( $featured as $row )
                                @if( $row->product_category && count( $row->product_category ) > 0 )

                                    <div class="product-list-wrapper product-item">
                                        <div class="product-image-wrapper">
                                            <a href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                  <?php if($row->feature_image): ?>
                                                        <img class="lazyload" data-src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') ) ) ) }}" alt="">
                                                        <?php else: ?>
                                                            <img class="lazyload" data-src="http://via.placeholder.com/350x350?text=Clothing%20Mantra">
                                                        <?php endif; ?>
                                                @if( $row->discount )
                                                    <div class="sale-label discount">
                                                        <span>-{{ $row->discount }}%</span>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product-detail">
                                            <div class="product-title">
                                                <a href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 6) }}</a>
                                            </div>
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
                                    </div>

                                @endif

                            @endforeach
                        @endif
                        <div class="featured-footer text-center">
                            <a href="{{ route('product.featured') }}" class="btn-more mt-2">View More</a>
                        </div>
                    </div>
                </div>


                <div class="col-9">

                    @if( !empty( $products ) )

                    <div class="">
                       <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                                    <span style="margin: 0 5px;">&raquo;</span>
                    
                            <span>{{ $title }}</span>
                        </nav>
                    </div>

                    <!-- Title -->
                    <div class="list-page-title row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <h1 class="">{{ $title }} <small> ({{ $products->total() }} Products)</small></h1>
                        </div>                            
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

                        @if( $c < 1 || $c === 3 )
                            <?php $c = 0; ?>
                            <?php echo '<div class="row product-list-item">'; ?>
                        @endif

                        @if( $row->product_category && count( $row->product_category ) > 0 )

                            <div class="product-item-element col-sm-4 col-md-4 col-lg-4 col-6">
                                <!--Product Item-->
                                <div class="product-item">
                                        <a href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                            <div class="product-item-inner">
                                                <div class="product-img-wrap">
                                                    <img class="lazyload" data-src="{{ asset( 'public/'. product_file( thumb( $row->feature_image, config('filesize.medium.0'), config('filesize.medium.1') ) ) ) }}" alt="" />
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
                                <!-- End Product Item-->
                            </div>

                        @endif

                        @if( $c == 2 )
                            <?php echo '</div>'; ?>
                        @endif

                        <?php $c++; ?>

                    @endforeach

                    @if( $c <= 2 )
                        <?php echo '</div>'; ?>
                    @endif

                    <div id="loadMoreRow"></div>

                    <div class="pagination-wraper">
                        {{-- {{ $products->appends($_GET)->links() }} --}}
                    </div>

                @else
                    <p class="text-center">Oops! content not found</p>
                @endif

                </div>
                <!-- End Product Grid -->
            </div>
            <!-- End Product Content -->

           
                
        </div>

    </section>
    <!-- End Page Content -->

</div>
<!-- End Page Content Wraper -->


@endsection