@extends(_app())

@section('content')

    <!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page products-page">
            <div class="container product-container category" data-id="{{ $category ? $category->slug : '' }}">

                <div class="row">

                    <div class="col-12">
                        @if (!empty($products) && $parent && !empty($category))
                            <div class="">
                              <nav class="breadcrumb-link" style="display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">Home</a>
                                    <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                    <span style="margin-right: 5px; color: #555;">{{ $title }}</span>

                                    @if ($parent && $category)
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <a href="{{ url('/' . $parent->slug) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                            {{ ucwords($parent->name) }}
                                        </a>
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <span style="color: #555; font-weight: 600;">{{ ucwords($category->name) }}</span>
                                    @else
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <span style="color: #555; font-weight: 600;">{{ ucwords($category->name) }}</span>
                                    @endif
                                </nav>

                            </div>
                        @endif
                    </div>

                    <aside class="col-lg-3 sidebar">
                        <div class="filter-button">
                            <a role="button" class="mobile-filter-menu">Filters <span class="fa fa-filter"></span></a>
                        </div>
                        <div class="filter-sidebar">
                            <div class="product-filter-wrapper">
                                @if ($parent)
                                    <form class="filter-form"
                                        action="{{ $parent && $category ? route('product.category', $parent->slug) : '' }}">
                                    @else
                                        <form class="filter-form"
                                            action="{{ $category ? route('product.category', $category->slug) : '' }}">
                                @endif
                                <div class="product-filter-row">
                                    <div class="filter-title">
                                        <span>Categories</span>
                                        <span class="plus-sign open"></span>
                                    </div>
                                    <div class="filter-content-categories filter-content">
                                        <?php $notids = [41, 44, 45, 46, 47]; ?>
                                        <?php $categories = App\model\Category::whereNotIn('id', $notids)->where('status', 'active')->orderBy('name', 'asc')->get();
                                        $c = 0; ?>
                                        @if ($categories && count($categories) > 0)
                                            <ul class="filter-list simple-radio perfect-scrollbar">
                                                @foreach ($categories as $key => $cat)
                                                    @if (!$cat->parent)
                                                        <li class="filter-item">
                                                            <p
                                                                class="filter expand-list {{ $cat->slug === Request::segment(1) ? 'active' : '' }}  ">
                                                                @if ($categories->where('parent', $cat->id)->first())
                                                                    <span
                                                                        class="plus-sign {{ $parent && $parent->slug === $cat->slug ? 'open' : '' }}"></span>
                                                                @endif
                                                                <input
                                                                    class="{{ $category && $category->slug === $cat->slug ? 'checked' : '' }}"
                                                                    data-parent="" type="radio" name="category"
                                                                    id="{{ $cat->slug . ++$c }}"
                                                                    value="{{ $cat->slug }}">
                                                                <label class="radio" for="{{ $cat->slug . $c }}">
                                                                    {{ ucwords($cat->name) }}
                                                                </label>
                                                            </p>
                                                            @if ($categories->where('parent', $cat->id)->first())
                                                                <ul
                                                                    class="filter-list child-category {{ $parent && $parent->slug === $cat->slug ? 'show' : '' }}">
                                                                    @foreach ($categories as $child)
                                                                        @if ($cat->id == $child->parent)
                                                                            <li class="filter-item">
                                                                                <p class="filter">
                                                                                    <input
                                                                                        data-parent="{{ $cat->slug }}"
                                                                                        class="{{ $category && $category->slug === $child->slug ? 'checked' : '' }}"
                                                                                        type="radio" name="category"
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
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                <?php
                                $minPrice = Input::has('min') ? Input::get('min') : '';
                                $maxPrice = Input::has('max') ? Input::get('max') : '';
                                $brandFilter = Input::has('brand') ? Input::get('brand') : '';
                                ?>


                                <div class="product-filter-row">
                                    <div class="filter-title">
                                        <span>Price</span>
                                        <span class="plus-sign open"></span>
                                    </div>
                                    <div class="filter-content-price filter-content">
                                        <input id="min" class="filter-price" name="min"
                                            value="{{ $minPrice }}" placeholder="Min price" type="text">
                                        <input id="max" name="max" class="filter-price"
                                            value="{{ $maxPrice }}" placeholder="Max price" type="text">
                                        <button class="btn btn-go filter-price-btn">Go</button>
                                    </div>
                                </div>

                                <div class="product-filter-row" style="display: none;">
                                    <div class="filter-title" s>
                                        <span>Brand</span>
                                        <span class="plus-sign open"></span>
                                    </div>
                                    <div class="filter-content-brand filter-content">
                                        <ul class="filter-list simple-radio perfect-scrollbar">
                                            <?php $brands = App\model\Brand::orderby('name', 'ASC')->get(); ?>

                                            @if ($brands && count($brands) > 0)
                                                <?php $brand = $brands->where('slug', $brandFilter)->first(); ?>
                                                @if ($brand)
                                                    <li class="filter-item">
                                                        <p class="filter">
                                                            <input type="radio" class="checked" checked name="brand"
                                                                id="{{ $brand->slug }}" value="{{ $brand->slug }}">
                                                            <label class="radio" for="{{ $brand->slug }}">
                                                                {{ ucwords($brand->name) }}
                                                            </label>

                                                            <span class="clear-brand-filter close"></span>
                                                        </p>
                                                    </li>
                                                @endif
                                                @foreach ($brands as $brand)
                                                    @if ($brand->slug !== $brandFilter)
                                                        <li class="filter-item">
                                                            <p class="filter">
                                                                <input type="radio" name="brand"
                                                                    id="{{ $brand->slug }}" value="{{ $brand->slug }}">
                                                                <label class="radio" for="{{ $brand->slug }}">
                                                                    {{ ucwords($brand->name) }}
                                                                </label>
                                                            </p>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>


                                <div class="product-filter-row1" style="display:none;">
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

                            @if (!$agent->isMobile())

                                <div class="featured-product-row">
                                    <div class="row-title">Featured Product</div>
                                    <?php $featured = App\model\Product::with('product_category')
                                        ->where(['type' => 'featured', 'status' => 'active'])
                                        ->limit(4)
                                        ->orderby('updated_at', 'DESC')
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
                                                                    <span class="fa fa-inr"></span>
                                                                    {{ $price }}
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
                                    <div class="featured-footer text-center">
                                        <a href="{{ route('product.featured') }}" class="btn-more mt-2">View More</a>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </aside>


                    <div class="col-lg-9">


                        @php $subcategories = $category ? $category->where('parent', $category->id)->get() : false; @endphp

                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="my-top-bar">

                                    @if ($category)
                                        {{ ucwords($category->name) }}
                                        @if ($subcategories && count($subcategories) > 0)
                                        @else
                                            <small style="text-transform: lowercase;color:#bdbbbb;">
                                                ({{ $products->total() ? $products->total() . ' products' : '' }})</small>
                                        @endif
                                    @endif

                                </h1>
                            </div>



                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sort-by-col">
                                @if ($parent)
                                    {{ Form::open(['url' => route('category.product', [$parent->slug, $category->slug]), 'class' => 'product-sort-by pull-right', 'id' => 'sorting-form', 'method' => 'GET']) }}
                                @else
                                    {{ Form::open(['url' => route('product.category', [$category->slug]), 'class' => 'product-sort-by pull-right', 'id' => 'sorting-form', 'method' => 'GET']) }}
                                @endif
                                <label for="short-by">Short By</label>
                                <?php $sortby = $sortby ?? 'latest'; ?>
                                <?php $sort_by = isset($_GET['sort-by']) && $_GET['sort-by'] ? $_GET['sort-by'] : $sortby; ?>
                                <select name="sort-by" id="product-short-by" class="nice-select-box">
                                    <option {{ $sort_by === 'latest' ? 'selected' : '' }} value="latest">Latest</option>
                                    <option {{ $sort_by === 'low_to_high' ? 'selected' : '' }} value="low_to_high">Price:
                                        Low to High</option>
                                    <option {{ $sort_by === 'high_to_low' ? 'selected' : '' }} value="high_to_low">Price:
                                        High to Low</option>
                                </select>
                                {{ Form::close() }}
                            </div>
                        </div>




                        @if ($subcategories && count($subcategories) > 0)
                            <div class="row">

                                @foreach ($subcategories as $d)
                                    @if ($d->status == 'active')
                                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-6 category-view">
                                            <?php $url = URL::to(Request::segment(1)) . '/' . $d->slug; ?>

                                            <figure class="image">
                                                <a href="{{ $url }}">
                                                    @if ($d->feature_image and $d->feature_image != '-300x300.')
                                                        <img
                                                            src="{{ asset('public/' . public_file(thumb($d->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $d->title ?? 'Product image' }}">
                                                    @else
                                                        <img src="https://via.placeholder.com/300x300?text={{ $d->name }}"
                                                            alt="koxton">
                                                    @endif
                                                    <h4>{{ $d->name }}</h4>
                                                </a>
                                            </figure>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                        @elseif(!empty($products) && !empty($category))
                            @if (!empty($products) && !empty($category))


                                <!-- Title -->
                                <div class="list-page-title row">

                                    {{-- <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h1 class="">{{ ucwords($category->name) }} <small> ({{ $products->total() }} Products)</small></h1>
                                </div> --}}

                                    @if ($category->description)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cat-desc">
                                            <?php //echo $category->description;
                                            ?>
                                        </div>
                                    @endif

                                </div>
                                <!-- End Title -->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="border-bottom-1"></div>
                                    </div>
                                </div>

                                <?php $segment = Request::segment(1) ? Request::segment(1) : 'dont-use-this'; ?>
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

                                            <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                            <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                            <div
                                                class="product-item-element col-md-4 col-lg-4 col-sm-12 col-xs-12 desktop-product-view">
                                                <!--Product Item-->
                                                <div class="product-layout">
                                                    <div class="product-thumb transition clearfix">

                                                        <div class="image">
                                                            <a
                                                                href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">
                                                                <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                                    alt="{{ $row->title ?? 'Product image' }}" title=""
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
                                                                        href="{{ route('product.view', [$row->product_category[0]->slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
                                                                </h4>
                                                                <div class="price-rating">
                                                                    <p class="price"><span class="price-new fa fa-inr">
                                                                            {{ round($price) }}</span> <span
                                                                            class="mrp">MRP</span> <span
                                                                            class="price-old fa fa-inr">
                                                                            {{ round($row->mrp) }}</span></p>

                                                                    <p class="rating">
                                                                        {{ round($rat) }} / 5 <i class="fa fa-star"></i>
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
                                                                    alt="{{ $row->title ?? 'Product image' }}" title=""
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
                                                                            {{ round($price) }}</span> <span
                                                                            class="mrp">MRP</span> <span
                                                                            class="price-old fa fa-inr">
                                                                            {{ round($row->mrp) }}</span></p>
                                                                    <p class="rating" style="display: none;">
                                                                        {{ $rat }} / 5 <i class="fa fa-star"></i>
                                                                    </p>
                                                                </div>


                                                                <div class="product-footer-btn">
                                                                    <button role="button"
                                                                        style="background: #e31f23; color: #fff;"
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
                                                                            {{ $rat }} / 5 <i
                                                                                class="fa fa-star"></i>
                                                                        </p>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Product Item-->
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
