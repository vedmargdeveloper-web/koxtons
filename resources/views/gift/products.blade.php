@extends(_app())

@section('content')


    <!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Bread Crumb -->
        <section class="">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav class="breadcrumb-link" style="display: flex; align-items: center; flex-wrap: wrap; font-size: 14px; color: #555;">
                            <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                            
                            @if ($parent && $category)
                                <span style="margin: 0 5px;">&raquo;</span>
                                <a href="{{ route('product.category', $parent->slug) }}" style="color: #007bff; text-decoration: none;">
                                    {{ ucwords($parent->name) }}
                                </a>
                                <span style="margin: 0 5px;">&raquo;</span>
                                <span style="color: #555; font-weight: 600;">{{ ucwords($category->name) }}</span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bread Crumb -->

        <!-- Page Content -->
        <section class="content-page">

            <div class="container-fluid product-container category" data-id="{{ $category ? $category->slug : '' }}">

                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                    <div class="row">

                        <div class="col-3">
                            <div class="product-filter-wrapper">
                                <div class="product-filter-header">

                                </div>
                                <div class="product-filter-row">
                                    <div class="filter-title">
                                        <span>Categories</span>
                                    </div>
                                    <div class="filter-content-categories">
                                        <?php $categories = App\model\Category::all();
                                        $c = 0; ?>
                                        @if ($categories && count($categories) > 0)
                                            <ul class="filter-list simple-radio">
                                                @foreach ($categories as $key => $cat)
                                                    @if (!$cat->parent)
                                                        <li class="filter-item">
                                                            <p class="filter expand-list">
                                                                <span class="plus-sign"></span>
                                                                <input type="radio" name="category"
                                                                    id="{{ $cat->slug . ++$c }}"
                                                                    value="{{ ucwords($cat->slug) }}">
                                                                <label class="radio" for="{{ $cat->slug . $c }}">
                                                                    {{ ucwords($cat->name) }}
                                                                </label>
                                                            </p>
                                                            <ul class="filter-list child-category">
                                                                @foreach ($categories as $child)
                                                                    @if ($cat->id == $child->parent)
                                                                        <li class="filter-item">
                                                                            <p class="filter">
                                                                                <input type="radio" name="category"
                                                                                    id="{{ $child->slug . ++$c }}"
                                                                                    value="{{ ucwords($child->slug) }}">
                                                                                <label class="radio"
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
                                    </div>
                                    <div class="filter-content-price">
                                        <input id="min" class="filter-price" name="min" value=""
                                            placeholder="Min price" type="text">
                                        <input id="max" name="max" class="filter-price" value=""
                                            placeholder="Max price" type="text">
                                        <button class="btn btn-go filter-price-btn">Go</button>
                                    </div>
                                </div>


                                <div class="product-filter-row">
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
                            </div>
                        </div>


                        <div class="col-9">

                            @if (!empty($products) && $parent && !empty($category))
                                <!-- Title -->
                                <div class="list-page-title row">

                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <h1 class="">{{ ucwords($category->name) }} <small> {{ $total }}
                                                Products</small></h1>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        {{ Form::open(['url' => route('category.product', [$parent->slug, $category->slug]), 'class' => 'product-sort-by pull-right', 'id' => 'sorting-form', 'method' => 'GET']) }}
                                        <label for="short-by">Short By</label>
                                        <?php $sort_by = isset($_GET['sort-by']) && $_GET['sort-by'] ? $_GET['sort-by'] : 'latest'; ?>
                                        <select name="sort-by" id="product-short-by" class="nice-select-box">
                                            <option {{ $sort_by === 'latest' ? 'selected' : '' }} value="latest">Latest
                                            </option>
                                            <option {{ $sort_by === 'low_to_high' ? 'selected' : '' }} value="low_to_high">
                                                Price: Low to High</option>
                                            <option {{ $sort_by === 'high_to_low' ? 'selected' : '' }} value="high_to_low">
                                                Price: High to Low</option>
                                        </select>
                                        {{ Form::close() }}
                                    </div>
                                    @if ($category->description)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cat-desc">
                                            <?php echo $category->description; ?>
                                        </div>
                                    @endif

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

                                @foreach ($products as $key => $row)
                                    @if ($c < 1 || $c === 3)
                                        <?php $c = 0; ?>
                                        <?php echo '<div class="row product-list-item">'; ?>
                                    @endif
                                    <div class="product-item-element col-sm-4 col-md-4 col-lg-4 col-6">
                                        <!--Product Item-->
                                        <div class="product-item">
                                            <a
                                                href="{{ route('product.view', [$category->slug, $row->slug, $row->product_id]) }}">
                                                <div class="product-item-inner">
                                                    <div class="product-img-wrap">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->feature_image_alt ?? '' }}">
                                                        @if ($row->discount)
                                                            <div class="sale-label discount">
                                                                <span>-{{ $row->discount }}%</span>
                                                            </div>
                                                        @endif
                                                        <div role="button" class="btn-wishlist" id="addToWishlist"
                                                            data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}" data-mode="top"
                                                            data-tip="Add To Whishlist"><i
                                                                class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-detail">
                                                    <p class="product-title">{{ get_excerpt($row->title, 6) }}</p>
                                                    <h5 class="item-price">
                                                        <?php $price = $row->price; ?>
                                                        @if ($row->discount)
                                                            <del><sub><span class="fa fa-inr"></span>
                                                                    {{ $row->price }}</sub></del>
                                                            <?php $price = $row->price - ($row->price * $row->discount) / 100; ?>
                                                        @endif
                                                        <span class="fa fa-inr"></span> {{ round($price) }}
                                                    </h5>
                                                </div>
                                            </a>
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

            </div>

        </section>
        <!-- End Page Content -->

    </div>
    <!-- End Page Content Wraper -->


@endsection
