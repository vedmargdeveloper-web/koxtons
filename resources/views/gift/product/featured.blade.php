@extends(_app())

@section('content')

    @if (!empty($category))
        @section('og-url', current_url())
    @section('og-type', 'Category')

    @if ($category->metatitle !== null)
        @section('og-title', $category->metatitle ?? '')
    @else
        @section('og-title', $title)
    @endif

    @section('og-keywords', $category->metakey ?? '')
    @section('og-content', $category->metadescription ?? '')
@endif

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Page Content -->
    <section class="content-page products-page">

        <div class="container product-container category" data-id="{{ $parent }}" data-type="featured">

            <div class="row">

                <div class="col-md-3">
                    <div class="product-filter-wrapper">
                        <form class="filter-form" action="{{ url('/') }}">
                            <div class="product-filter-row">
                                <div class="filter-title">
                                    <span>Categories</span>
                                    <span class="plus-sign"></span>
                                </div>
                                <div class="filter-content-categories filter-content">
                                    <?php $notids = [41, 44, 45, 46, 47]; ?>
                                    <?php $categories = App\model\Category::whereNotIn('id', $notids)->where('status', 'active')->orderBy('name', 'asc')->get();
                                    $c = 0; ?>
                                    @if ($categories && count($categories) > 0)
                                        <ul class="filter-list simple-radio">
                                            @foreach ($categories as $key => $cat)
                                                @if (!$cat->parent)
                                                    <li class="filter-item">
                                                        <p
                                                            class="filter expand-list {{ $cat->slug === Request::segment(1) ? 'active' : '' }}">
                                                            <span class="plus-sign"></span>
                                                            <input type="radio" name="category"
                                                                id="{{ $cat->slug . ++$c }}" value="{{ $cat->slug }}">
                                                            <label class="radio" for="{{ $cat->slug . $c }}">
                                                                {{ ucwords($cat->name) }}
                                                            </label>
                                                        </p>
                                                        <ul class="filter-list child-category">
                                                            @foreach ($categories as $child)
                                                                @if ($cat->id == $child->parent)
                                                                    <li class="filter-item">
                                                                        <p class="filter">
                                                                            <input class="" type="radio"
                                                                                name="category"
                                                                                id="{{ $child->slug . ++$c }}"
                                                                                value="{{ $child->slug }}">
                                                                            <label class="radio inner-label"
                                                                                for="{{ $child->slug . $c }}">
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
                                    <input id="min" class="filter-price" name="min" value=""
                                        placeholder="Min price" type="text">
                                    <input id="max" name="max" class="filter-price" value=""
                                        placeholder="Max price" type="text">
                                    <button class="btn btn-go filter-price-btn">Go</button>
                                </div>
                            </div>


                            <div class="product-filter-row" style="display:none;">
                                <div class="filter-title">
                                    <span>Color</span>
                                </div>
                                <div class="filter-content-colors">
                                    <?php $colors = [
                                        'AliceBlue',
                                        'AntiqueWhite',
                                        'Aqua',
                                        'Aquamarine',
                                        'Azure',
                                        'Beige',
                                        'Bisque',
                                        'Black',
                                        'BlanchedAlmond',
                                        'Blue',
                                        'BlueViolet',
                                        'Brown',
                                        'BurlyWood',
                                        'CadetBlue',
                                        'Chartreuse',
                                        'Chocolate',
                                        'Coral',
                                        'CornflowerBlue',
                                        'Cornsilk',
                                        'Crimson',
                                        'Cyan',
                                        'DarkBlue',
                                        'DarkCyan',
                                        'DarkGoldenRod',
                                        'DarkGray',
                                        'DarkGrey',
                                        'DarkGreen',
                                        'DarkKhaki',
                                        'DarkMagenta',
                                        'DarkOliveGreen',
                                        'DarkOrange',
                                        'DarkOrchid',
                                        'DarkRed',
                                        'DarkSalmon',
                                        'DarkSeaGreen',
                                        'DarkSlateBlue',
                                        'DarkSlateGray',
                                        'DarkSlateGrey',
                                        'DarkTurquoise',
                                        'DarkViolet',
                                        'DeepPink',
                                        'DeepSkyBlue',
                                        'DimGray',
                                        'DimGrey',
                                        'DodgerBlue',
                                        'FireBrick',
                                        'FloralWhite',
                                        'ForestGreen',
                                        'Fuchsia',
                                        'Gainsboro',
                                        'GhostWhite',
                                        'Gold',
                                        'GoldenRod',
                                        'Gray',
                                        'Grey',
                                        'Green',
                                        'GreenYellow',
                                        'HoneyDew',
                                        'HotPink',
                                        'IndianRed',
                                        'Indigo',
                                        'Ivory',
                                        'Khaki',
                                        'Lavender',
                                        'LavenderBlush',
                                        'LawnGreen',
                                        'LemonChiffon',
                                        'LightBlue',
                                        'LightCoral',
                                        'LightCyan',
                                        'LightGoldenRodYellow',
                                        'LightGray',
                                        'LightGrey',
                                        'LightGreen',
                                        'LightPink',
                                        'LightSalmon',
                                        'LightSeaGreen',
                                        'LightSkyBlue',
                                        'LightSlateGray',
                                        'LightSlateGrey',
                                        'LightSteelBlue',
                                        'LightYellow',
                                        'Lime',
                                        'LimeGreen',
                                        'Linen',
                                        'Magenta',
                                        'Maroon',
                                        'MediumAquaMarine',
                                        'MediumBlue',
                                        'MediumOrchid',
                                        'MediumPurple',
                                        'MediumSeaGreen',
                                        'MediumSlateBlue',
                                        'MediumSpringGreen',
                                        'MediumTurquoise',
                                        'MediumVioletRed',
                                        'MidnightBlue',
                                        'MintCream',
                                        'MistyRose',
                                        'Moccasin',
                                        'NavajoWhite',
                                        'Navy',
                                        'OldLace',
                                        'Olive',
                                        'OliveDrab',
                                        'Orange',
                                        'OrangeRed',
                                        'Orchid',
                                        'PaleGoldenRod',
                                        'PaleGreen',
                                        'PaleTurquoise',
                                        'PaleVioletRed',
                                        'PapayaWhip',
                                        'PeachPuff',
                                        'Peru',
                                        'Pink',
                                        'Plum',
                                        'PowderBlue',
                                        'Purple',
                                        'RebeccaPurple',
                                        'Red',
                                        'RosyBrown',
                                        'RoyalBlue',
                                        'SaddleBrown',
                                        'Salmon',
                                        'SandyBrown',
                                        'SeaGreen',
                                        'SeaShell',
                                        'Sienna',
                                        'Silver',
                                        'SkyBlue',
                                        'SlateBlue',
                                        'SlateGray',
                                        'SlateGrey',
                                        'Snow',
                                        'SpringGreen',
                                        'SteelBlue',
                                        'Tan',
                                        'Teal',
                                        'Thistle',
                                        'Tomato',
                                        'Turquoise',
                                        'Violet',
                                        'Wheat',
                                        'White',
                                        'WhiteSmoke',
                                        'Yellow',
                                        'YellowGreen',
                                    ];
                                    ?>
                                    <ul class="filter-list simple-radio">
                                        @foreach ($colors as $key => $color)
                                            <li class="filter-item">
                                                <p class="filter">
                                                    <input type="radio" name="color" id="{{ slug($color) . $key }}"
                                                        value="">
                                                    <label class="radio" for="{{ slug($color) . $key }}">
                                                        {{ ucwords($color) }} <span class="color-square"
                                                            style="background: {{ $color }}"></span>
                                                    </label>
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php $agent = new Jenssegers\Agent\Agent(); ?>
                    <div class="featured-product-row">
                        <div class="row-title">New Products</div>
                        <?php $featured = App\model\Product::with('product_category')
                            ->where(['status' => 'active'])
                            ->limit(4)
                            ->orderby('id', 'DESC')
                            ->get(); ?>
                        @if ($featured && count($featured))
                            @foreach ($featured as $row)
                                @if ($row->product_category && count($row->product_category) > 0)
                                    <div class="product-list-wrapper product-item">
                                        <div class="product-image-wrapper">
                                            <a
                                                href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                <?php if($row->feature_image): ?>
                                                <img class="lazyload"
                                                    data-src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))) }}"
                                                    alt="">
                                                <?php else: ?>
                                                <img class="lazyload"
                                                    data-src="http://via.placeholder.com/350x350?text=Clothing%20Mantra">
                                                <?php endif; ?>
                                                @if ($row->discount)
                                                    <div class="sale-label discount">
                                                        <span>-{{ $row->discount }}%</span>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product-detail">
                                            <div class="product-title">
                                                <a
                                                    href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
                                            </div>
                                            <h5 class="item-price">
                                                <?php $price = $row->price; ?>
                                                @if ($row->discount)
                                                    <del>
                                                        <span class="fa fa-inr"></span> {{ $price }}
                                                    </del>
                                                    <?php $price = $price - ($price * $row->discount) / 100; ?>
                                                @endif

                                                @if ($row->tax)
                                                    <?php $price = $price + ($price * $row->tax) / 100; ?>
                                                @endif
                                                <span class="fa fa-inr"></span> {{ round($price) }}
                                            </h5>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        {{--  <div class="featured-footer text-center">
                            <a href="{{ route('product.new') }}" class="btn-more mt-2">View More</a>
                        </div> --}}
                    </div>
                </div>


                <div class="col-md-9">

                    @if (!empty($products))

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
                                <h1 class="">{{ $title }} <small> ({{ $products->total() }}
                                        Products)</small></h1>
                            </div>
                        </div>
                        <!-- End Title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border-bottom-1"></div>
                            </div>
                        </div>


                        <!-- Product Grid -->

                        <?php $wishlist = Cookie::get('wishlistProduct'); ?>
                        <?php $wishListProduct = $wishlist ? json_decode($wishlist) : []; ?>

                        <!-- items -->
                        <?php $c = 0; ?>
                        @if (!$agent->isMobile())
                            <div class="desktop-product-view">
                                @foreach ($products as $key => $row)
                                    @if ($c < 1 || $c === 3)
                                        <?php $c = 0; ?>
                                        <?php echo '<div class="row product-list-item">'; ?>
                                    @endif

                                    @if ($row->product_category && count($row->product_category) > 0)
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <div class="product-item-element col-sm-4 col-md-4 col-lg-4 col-12">
                                            <!--Product Item-->
                                            <div class="product-layout col-xs-12">
                                                <div class="product-thumb transition clearfix">
                                                    @if ($row->discount)
                                                        <div class="sale-text"><span class="section-sale">Sale</span>
                                                        </div>
                                                    @endif
                                                    <div class="image">
                                                        <a
                                                            href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                            <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                                alt="{{ $row->title ?? 'Product Image' }}" title=""
                                                                class="img-responsive" />
                                                            <img class="img-responsive hover-img-1"
                                                                src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" />
                                                        </a>

                                                    </div>

                                                    <?php $price = $row->price;
                                                    $without_discount = $row->price; ?>
                                                    @if ($row->discount)
                                                        <?php $price = $price - ($price * $row->discount) / 100; ?>
                                                    @endif

                                                    @if ($row->tax)
                                                        <?php $price = $price + ($price * $row->tax) / 100; ?>
                                                    @endif
                                                    <div class="button-group" style="display: none;">
                                                        <button role="button" id="addToCartProduct"
                                                            data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}"><i
                                                                class="icon-bag"></i></button>
                                                        <a class="view-product-a"
                                                            href="{{ route('product.view', [$row->product_category[0]->cat_slug, $row->slug, $row->product_id]) }}"><i
                                                                class="icon-eye"></i></a>
                                                        <button role="button" class="btn-wishlist"
                                                            id="addToWishlist" data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}" data-mode="top"
                                                            data-tip="Add To Whishlist"><i
                                                                class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                    </div>

                                                    <div class="thumb-description clearfix">
                                                        <?php $rat = $rating; ?>
                                                        <div class="caption">
                                                            <h4 class="product-title"><a
                                                                    href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
                                                            </h4>
                                                            <div class="price-rating">
                                                                <p class="price">
                                                                    <span class="price-new fa fa-inr">
                                                                        {{ round($price) }}</span>
                                                                    @if ($price < $row->mrp)
                                                                        <span class="mrp"></span> <span
                                                                            class="price-old fa fa-inr">
                                                                            <del>{{ round($row->mrp) }}</del></span>
                                                                    @endif
                                                                </p>

                                                                <p class="rating">
                                                                    {{ $rat }} / 5 <i class="fa fa-star"></i>
                                                                </p>
                                                            </div>


                                                            <div class="product-footer-btn">
                                                                <button role="button"
                                                                    style="background: red; color: #fff;"
                                                                    id="addToCartProduct"
                                                                    data-value="{{ $row->product_id }}"
                                                                    data-id="{{ $row->id }}"><i
                                                                        class="icon-bag"></i> Add to cart</button>
                                                                <button role="button"
                                                                    style="background: #383085; color: #fff;"
                                                                    class="btn-wishlist" id="addToWishlist"
                                                                    data-value="{{ $row->product_id }}"
                                                                    data-id="{{ $row->id }}" data-mode="top"
                                                                    data-tip="Add To Whishlist"><i
                                                                        class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                                    Wishlist</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Product Item-->
                                        </div>
                                    @endif

                                    @if ($c == 2)
                                        <?php echo '</div>'; ?>
                                    @endif

                                    <?php $c++; ?>
                                @endforeach

                                @if ($c <= 2)
                                    <?php echo '</div>'; ?>
                                @endif
                            </div>
                        @endif
                        @if ($agent->isMobile())
                            <div class="mobile-product-view other-pages-view">
                                @foreach ($products as $key => $row)
                                    <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                    <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                    <div class="product-item-element col-md-4 col-lg-4 col-sm-6 col-xs-6">
                                        <!--Product Item-->
                                        <div class="product-layout">
                                            <div class="product-thumb transition clearfix">

                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->title ?? 'Product Image' }}" title=""
                                                            class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" />
                                                    </a>

                                                </div>

                                                <?php $price = $row->price;
                                                $without_discount = $row->price; ?>
                                                @if ($row->discount)
                                                    <?php $price = $price - ($price * $row->discount) / 100; ?>
                                                @endif

                                                @if ($row->tax)
                                                    <?php $price = $price + ($price * $row->tax) / 100; ?>
                                                @endif

                                                <div class="thumb-description clearfix">
                                                    <?php $rat = $rating; ?>
                                                    <div class="caption">
                                                        <h4 class="product-title"><a
                                                                href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) . '..' }}</a>
                                                        </h4>
                                                        <div class="price-rating">
                                                            <p class="price"><span class="price-new fa fa-inr">
                                                                    {{ round($price) }}</span>
                                                                @if ($price < $row->mrp)
                                                                    <span class="mrp"></span> <span
                                                                        class="price-old fa fa-inr">
                                                                        <del>{{ round($row->mrp) }}</del></span>
                                                                @endif
                                                            </p>
                                                           {{--  <p class="rating" style="display: none;">
                                                                {{ $rat }} / 5 <i class="fa fa-star"></i>
                                                            </p> --}}
                                                        </div>


                                                        {{-- <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: red; color: #fff;"
                                                                id="addToCartProduct"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i
                                                                    class="icon-bag"></i></button>
                                                            <button role="button"
                                                                style="background: #383085; color: #fff;"
                                                                class="btn-wishlist" id="addToWishlist"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}" data-mode="top"
                                                                data-tip="Add To Whishlist"><i
                                                                    class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                            <button role="button" class="rating-button">
                                                                <p class="rating">
                                                                    {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                                </p>
                                                            </button>
                                                        </div> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Item-->
                                    </div>
                                @endforeach
                            </div>
                            <div class="mobile-product-view product-mobile-design other-pages-view">
                                @foreach ($products as $key => $row)
                                    <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                    <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                    <div class="product-item-element col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-sm-4 col-xs-4 col-td-4">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->title ?? 'Product Image' }}" title=""
                                                            class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 col-td-8">
                                                <div class="product-layout">
                                                    <div class="product-thumb transition clearfix">

                                                        <?php $price = $row->price;
                                                        $without_discount = $row->price; ?>
                                                        @if ($row->discount)
                                                            <?php $price = $price - ($price * $row->discount) / 100; ?>
                                                        @endif
                                                        @if ($row->tax)
                                                            <?php $price = $price + ($price * $row->tax) / 100; ?>
                                                        @endif

                                                        <div class="thumb-description clearfix">
                                                            <?php $rat = $rating; ?>
                                                            <div class="caption">
                                                                <h4 class="product-title"><a
                                                                        href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 20) . '..' }}</a>
                                                                </h4>
                                                                <div class="price-rating">
                                                                    <p class="price"><span
                                                                            class="price-new fa fa-inr">
                                                                            {{ round($price) }}</span>
                                                                        @if ($price < $row->mrp)
                                                                            <span class="mrp"></span> <span
                                                                                class="price-old fa fa-inr">
                                                                                <del>{{ round($row->mrp) }}</del></span>
                                                                        @endif
                                                                    </p>
                                                                    <p class="rating">
                                                                        {{ $rat }} / 5 <i
                                                                            class="fa fa-star"></i>
                                                                    </p>
                                                                </div>


                                                                <div class="product-footer-btn">
                                                                    <button role="button"
                                                                        style="background: red; color: #fff;"
                                                                        id="addToCartProduct"
                                                                        data-value="{{ $row->product_id }}"
                                                                        data-id="{{ $row->id }}"><i
                                                                            class="icon-bag"></i> Add to Cart</button>
                                                                    <button role="button"
                                                                        style="background: #383085; color: #fff;"
                                                                        class="btn-wishlist" id="addToWishlist"
                                                                        data-value="{{ $row->product_id }}"
                                                                        data-id="{{ $row->id }}" data-mode="top"
                                                                        data-tip="Add To Whishlist"><i
                                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                                        Wishlist</button>
                                                                    <button role="button" class="rating-button"
                                                                        style="display:none">
                                                                        <p class="rating">
                                                                            {{ $rat }} / 5 <i
                                                                                class="fa fa-star"></i>
                                                                        </p>
                                                                    </button>
                                                                </div>
                                                                <div class="product-free-delivery">
                                                                    @if (!$row->shipping_charge or $row->shipping_charge == 0)
                                                                        <p><i class="fa fa-map-marker"></i> FREE
                                                                            Delivery</p>
                                                                    @else
                                                                        <p> Shipping Charges: <i
                                                                                class="fa fa-inr font-11"></i>
                                                                            {{ $row->shipping_charge }}</p>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="loadMoreRow"></div>

                        <div class="pagination-wraper">
                            {{ $products->appends($_GET)->links() }}
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
