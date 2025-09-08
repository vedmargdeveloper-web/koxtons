@extends(_app())
<?php $image_url = asset('public/assets/images/logo.jpg'); ?>
@section('og-url', url('/'))
@section('og-type', 'Product')
@section('og-title', 'Koxtonsmart: Buy Sports & Fitness Equipment Online in India')
@section('og-content',
    'Online store to Buy Fitness Equipment, Sports Accessories/Goods Online at best prices. Get
    Premium Quality product every time with free shipping and 10 days replacement warranty.')

@section('og-keywords',
    'Fitness Equipment, Sports equipment, sports equipment online, table tennis table equipment, gym
    fitness equipment, carrom board online,')

@section('og-image-url', $image_url)

@section('content')


    <div id="common-home">

        <?php $agent = new Jenssegers\Agent\Agent(); ?>

        <?php $slide = App\model\Slide::where(['type' => 'mainslider', 'status' => 'active'])
            ->limit(5)
            ->get(); ?>
        <!--============= Top Slider Start ===========================-->

        <div class="slideshow home-top-slider hidden-sm hidden-xs">
            <div class="swiper-viewport">
                <div id="slideshow0" class="swiper-container">
                    <div class="swiper-wrapper">
                        @if ($slide)
                            @foreach ($slide as $key)
                                <div class="swiper-slide text-center Main-banner1">
                                    <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}">
                                        <img src="{{ asset('public/' . public_file($key->image)) }}" alt="{{ $key->image_alt ?? '' }}"
                                            class="img-responsive" />
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="swiper-pagination slideshow0"></div>
                <div class="swiper-pager">
                    <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                    <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <?php $mobile_slide = App\model\Slide::where(['type' => 'mobileslider', 'status' => 'active'])
            ->limit(5)
            ->get(); ?>
        <!--============= Top Slider Start ===========================-->

        <div class="slideshow home-top-slider hidden-lg hidden-md">
            <div class="swiper-viewport">
                <div id="slideshow1" class="swiper-container">
                    <div class="swiper-wrapper">
                        @if ($mobile_slide)
                            @foreach ($mobile_slide as $key)
                                <div class="swiper-slide text-center Main-banner1">
                                    <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}">
                                        <img src="{{ asset('public/' . public_file($key->image)) }}" alt="{{ $key->image_alt ?? '' }}"
                                            class="img-responsive" />
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="swiper-pagination slideshow0"></div>
                <div class="swiper-pager">
                    <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                    <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                </div>
            </div>
        </div>


        <script>
            $('#slideshow0').swiper({
                mode: 'horizontal',
                slidesPerView: 1,
                pagination: '.slideshow0',
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 0,
                autoplay: 4000,
                autoplayDisableOnInteraction: true,
                loop: true
            });

             $('#slideshow1').swiper({
                mode: 'horizontal',
                slidesPerView: 1,
                pagination: '.slideshow0',
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 0,
                autoplay: 4000,
                autoplayDisableOnInteraction: true,
                loop: true
            });
        </script>
        <!--============= Top Slider End ===========================-->

        <div class="service-box">
            <div class="promo-item container">
                <div class="row">
                    <div class="service-item col-md-4 col-sm-4 col-xs-4 p-0">
                        <div class="service">
                            <div class="service-icon icon-plane"></div>
                            <div class="service-content">
                                <h4 class="promo-title">Door to Door </h4>
                                <span class="promo-desc block">Delivery Available </span>
                            </div>
                        </div>
                    </div>
                    <div class="service-item col-md-4 col-sm-4 col-xs-4 p-0">
                        <div class="service">
                            <div class="service-icon icon-wallet"></div>
                            <div class="service-content">
                                <h4 class="promo-title">Easy 7 Days Return</h4>
                                <span class="promo-desc block">* Term & Conditions applied</span>
                            </div>
                        </div>
                    </div>
                    <div class="service-item col-md-4 col-sm-4 col-xs-4 p-0">
                        <div class="service">
                            <div class="service-icon icon-support"></div>
                            <div class="service-content">
                                <h4 class="promo-title">Customer Service</h4>
                                <span class="promo-desc block">Call us at +91-8476000167</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
        // $collection = App\model\Slide::where(['type' => 'collection', 'status' => 'active'])
        //     ->limit(3)
        //     ->get();

        $collection = App\model\Slide::where(['type' => 'collection', 'status' => 'active'])->get();
        ?>
        @if (!$agent->isMobile())
            <div class="container dd-dd desktop-view-collection">
                <div class="banner-outer container-outer html1 mt-20 ml-2 mr-2">
                    <div class="row align-items-center" style="gap: 15px;">
                        @if ($collection)
                            @foreach ($collection as $key)
                                <?php $heading_title = [0 => '', 1 => ''];
                                $heading_title = explode(' ', $key->title); ?>
                                <div class="banner1 col-xs-1 p-0">
                                    <div class="inner1">
                                        <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}">
                                            <img src="{{ asset('public/' . public_file($key->image)) }}" alt="{{ $key->image_alt ?? 'Slider Banner' }}"
                                                class="img-responsive" />
                                            <div class="inner2">
                                                <div class="promo-text-box">
                                                    <h1 class="promo-title">
                                                        <span>{{ $heading_title[0] ? $heading_title[0] : '' }} {{ isset($heading_title[1]) ? $heading_title[1] : '' }}</span>
                                                    </h1>
                                                    <button type="button" class="promo-btn btn">SHOP NOW</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        @endif

        @if ($agent->isMobile())
            <div class="mobile-view-collection">
                <!-- Mobile view product slide -->
                <div class="swiper-viewport">
                    <div class="swiper-container mySwiper-collection">
                        <div class="swiper-wrapper">
                            @if ($collection)
                                @foreach ($collection as $key)
                                    <?php $heading_title = [0 => '', 1 => ''];
                                    $heading_title = explode(' ', $key->title); ?>
                                    <div class="banner1 swiper-slide">
                                        <div class="inner1">
                                            <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}"><img
                                                    src="{{ asset('public/' . public_file($key->image)) }}" alt="{{ $key->image_alt ?? '' }}"
                                                    class="img-responsive" />
                                                <div class="inner2">
                                                    <div class="promo-text-box">
                                                        <h1 class="promo-title">
                                                            <span>{{ $heading_title[0] ? $key->title : '' }}</span>
                                                        </h1>
                                                        <button type="button" class="promo-btn btn">SHOP NOW</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <script>
            $('.mySwiper-collection').swiper({
                mode: 'horizontal',
                slidesPerView: "auto",
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 0,
                autoplay: 4000,
                autoplayDisableOnInteraction: true,
                loop: false
            });
        </script>
        <!-- Mobile view product slide -->
    </div>



    <?php $wishlist = Cookie::get('wishlistProduct'); ?>
    <?php $wishListProduct = $wishlist ? json_decode($wishlist) : []; ?>

    @if (!$agent->isMobile())

        <?php $dd_new_ids = App\model\Category::where('id', 44)->first(); ?>

        <?php $dds = explode(',', $dd_new_ids->product_priority_desktop); ?>
        <?php $new_arrivals = App\model\Product::with([
            'review',
            'product_category' => function ($q) {
                $q->where('category_id', 44);
            },
        ])
            ->limit(8)
            ->where(['status' => 'active'])
            ->where('discount', '=', null)
            ->where('available', '>', 0)
            ->whereIn('id', $dds)
            ->get(); ?>

        <!--========= Start New Arrivals Section =================-->
        <div class="box all-products mt-50 section-bg-light-grey desktop-view-product">
            <div class="container">
                <div class="box-heading">
                    <div class="box-content special">
                        <div class="page-title toggled">
                            <h1><span>New Arrivals</span></h1>
                        </div>

                        <div class="block_box row">
                            <div id="special-carousel" class="box-product product-carousel-home clearfix" data-items="4">
                                @if ($dds)
                                    @foreach ($dds as $id)
                                        <?php $row = $new_arrivals->where('id', $id)->first(); ?>

                                        @if( $row )

                                            <?php
                                            
                                            $cat = $row->product_category ? $row->product_category->first() : null;
                                            $cat_slug = $cat->slug ?? ''; // App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                            <?php $reviews = $row->review; // App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                            <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                            <div class="product-layout col-xs-12">
                                                <div class="product-thumb transition clearfix">
                                                    {{--  @if ($row->discount)
                                                        <div class="sale-text"><span class="section-sale">Sale</span></div>
                                                @endif --}}
                                                    <div class="image">
                                                        <a
                                                            href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                            <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                               alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                            <img class="img-responsive hover-img-1"
                                                                src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
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
                                                        <button role="button" style="background: red;color: #fff;"
                                                            id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                            Cart</button>
                                                        {{--  <a class="view-product-a" href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i class="icon-eye"></i></a> --}}
                                                        <button role="button" style="background: #383085;color: #fff;"
                                                            class="btn-wishlist" id="addToWishlist"
                                                            data-value="{{ $row->product_id }}" data-id="{{ $row->id }}"
                                                            data-mode="top" data-tip="Add To Whishlist"><i
                                                                class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                            Wishlist</button>
                                                    </div>

                                                    <div class="thumb-description clearfix">
                                                        <?php $rat = $rating; ?>
                                                        <div class="caption">
                                                            <h4 class="product-title"><a
                                                                    href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
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

                                                                <p class="rating">
                                                                    {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                                </p>
                                                            </div>


                                                            <div class="product-footer-btn">
                                                                <button role="button"
                                                                    style="background: red; color: #fff;"
                                                                    id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                                    data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                    Add to cart</button>
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

                                        @endif

                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--============== End New Arrivals Section =============-->
    @endif


    @if ($agent->isMobile())

        <?php $dd_new_ids = App\model\Category::where('id', 44)->first(); ?>

        <?php $dds = explode(',', $dd_new_ids->product_priority_mobile); ?>
        <?php $new_arrivals = App\model\Product::with([
            'review',
            'product_category' => function ($q) {
                $q->where('category_id', 44);
            },
        ])
            ->limit(8)
            ->where(['status' => 'active'])
            ->where('discount', '=', null)
            ->where('available', '>', 0)
            ->whereIn('id', $dds)
            ->get(); ?>

        <!-- Mobile view product slide -->
        <div class="mobile-veiw-product section-bg-light-grey">
            <div class="page-title toggled">
                <h1><span>New Arrivals</span></h1>
            </div>
            <div class="swiper-viewport">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        @if ($dds)
                            @foreach ($dds as $id)
                                <?php $row = $new_arrivals->where('id', $id)->first(); ?>

                                @if( $row )
                                
                                    <?php
                                    
                                    $cat = $row->product_category ? $row->product_category->first() : null;
                                    $cat_slug = $cat->slug ?? ''; // App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                    <?php $reviews = $row->review; // App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                    <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>

                                    <div class="product-layout swiper-slide">
                                        <div class="product-thumb transition clearfix">
                                            <div class="image">
                                                <a
                                                    href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                    <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                       alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                    <img class="img-responsive hover-img-1"
                                                        src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
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
                                                            href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
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

                                                        {{-- <p class="rating">
                                                            {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                        </p> --}}
                                                    </div>


                                                  {{--   <div class="product-footer-btn">
                                                        <button role="button" style="background: red; color: #fff;"
                                                            id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                            Cart</button>
                                                        <button role="button" style="background: #383085; color: #fff;"
                                                            class="btn-wishlist" id="addToWishlist"
                                                            data-value="{{ $row->product_id }}"
                                                            data-id="{{ $row->id }}" data-mode="top"
                                                            data-tip="Add To Wishlist"><i
                                                                class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                            Wishlist</button>
                                                    </div> --}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script>
        $('.mySwiper').swiper({
            mode: 'horizontal',
            slidesPerView: "auto",
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            autoplay: 1000000,
            autoplayDisableOnInteraction: true,
            loop: false
        });
        var mySwiper = document.querySelector('.swiper-container').swiper();

        $(".swiper-container").mouseenter(function() {
            $('.mySwiper').swiper().autoplay.stop();
            console.log('slider stopped');
        });

        $(".swiper-container").mouseleave(function() {
            $('.mySwiper').swiper().autoplay.start();
            console.log('slider started again');
        });
    </script>
    <!-- Mobile view product slide -->


    <?php $video = App\model\Slide::where(['type' => 'video', 'status' => 'active'])
        ->orderBy('id', 'DESC')
        ->first(); ?>
    <!--================== Deal Of The Day Section Start ====================-->

    <?php $deal_of_the_day_product_ids = App\model\CategoryProduct::select('product_id')->where('category_id', 41)->get()->toArray(); ?>
    <?php $deal_of_the_day = App\model\Product::limit(8)
        ->where(['status' => 'active'])
        ->where('available', '>', 0)
        ->whereIn('id', $deal_of_the_day_product_ids)
        ->get(); ?>

    <span style="display: none;">

        @foreach ($deal_of_the_day as $row)
            {{ $row->title }}
        @endforeach
    </span>
    <div class="banner-outer container-outer html3 col-lg-5 col-xs-6 hidden-md hidden-sm hidden-xs">
        <div class="banner4">
            <div class="inner1">
                <a href="#">
                    @if (!empty($video->image))
                        <video class="home-page-video" width="420" height="940" autoplay loop muted>
                            <source src="{{ asset('public/' . public_file('video/' . $video->image)) }}"
                                type="video/mp4">
                            <source src="{{ asset('public/' . public_file('video/' . $video->image)) }}"
                                type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </a>
                <div class="inner2">
                    <div class="promo-text-box">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="curent_date" style="display: none" data-id="<?= date('Y-m-d') ?>"></span>
    <div class="special-countdown col-lg-7 col-xs-12">
        <div class="countdown-carousel list-products box-content">
            <div class="page-title deal-title">
                <h1>Deal of the day</h1>
            </div>
            <div class="block_box countdown-inner">
                <div id="special-count" class="box-product special-count-carousel clearfix">
                    @if ($deal_of_the_day and count($deal_of_the_day) > 0)
                        @foreach ($deal_of_the_day as $row)
                            <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                            <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                            <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                            <?php $rat = $rating; ?>
                            <div class="product-layout col-xs-12">
                                <div class="product-thumb transition clearfix">
                                    <div class="countdown-images">
                                        <div class="special-image">
                                            @if ($row->discount)
                                                <div class="sale-text"><span
                                                        class="section-sale">{{ $row->discount . '% Off' }}</span></div>
                                            @endif
                                            <div class="image">
                                                <a
                                                    href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                    <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                       alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                    <img class="img-responsive hover-img-1"
                                                        src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
                                                </a>


                                            </div>
                                        </div>
                                    </div>
                                    <?php $price = $row->price;
                                    $without_discount = $row->price; ?>
                                    @if ($row->discount)
                                        <?php $price = $price - ($price * $row->discount) / 100; ?>
                                    @endif

                                    @if ($row->tax)
                                        <?php $price = $price + ($price * $row->tax) / 100; ?>
                                    @endif
                                    <div class="thumb-description">
                                        <div class="caption">
                                            <h4 class="product-title">
                                                <a
                                                    href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
                                            </h4>
                                            <div class="price-rating">
                                                <p class="price"><span class="price-new fa fa-inr">
                                                        {{ round($price) }}</span>
                                                    @if ($price < $row->mrp)
                                                        <span class="mrp"></span> <span class="price-old fa fa-inr">
                                                            <del>{{ round($row->mrp) }}</del>
                                                        </span>
                                                    @endif
                                                </p>

                                                <p class="rating deal-rating">
                                                    {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                </p>
                                            </div>


                                        </div>
                                        <div style="display: none" id="countdown_<?= $row->id ?>" class="item-countdown"
                                            data-date="<?= date('Y-m-d') ?>">

                                        </div>
                                        <div id="countdown">
                                            <ul class="item-countdown">
                                                {{-- <li><span id="days" style="display: none;"></span></li> --}}
                                                <li><span class="hours" id="hours"></span>Hours</li>
                                                <li><span class="minutes" id="minutes"></span>Min</li>
                                                <li><span class="seconds" id="seconds"></span>Sec</li>
                                            </ul>
                                        </div>

                                        <div class="product-footer-btn button-groups">
                                            <button role="button" id="addToCartProduct"
                                                style="background: red; color: #fff;"
                                                data-value="{{ $row->product_id }}" data-id="{{ $row->id }}"><i
                                                    class="icon-bag"></i> Add to cart</button>
                                            <button role="button" style="background: #383085; color: #fff;"
                                                class="btn-wishlist" id="addToWishlist"
                                                data-value="{{ $row->product_id }}" data-id="{{ $row->id }}"
                                                data-mode="top" data-tip="Add To Whishlist"><i
                                                    class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                Add to wishlist</button>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            $(".item-countdown").each(function() {
                                                // var date = $('.curent_date').attr('data-id');
                                                var date = $(this).data("date");

                                                $(this).lofCountDown({
                                                    TargetDate: date,
                                                    DisplayFormat: "<div>%%H%% <span>Hours</span></div><div>%%M%% <span>Min</span></div><div>%%S%% <span>Sec</span></div>",
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
                                                <!--
                                                    $(document).ready(function() {
                                                        setSpecialCarousel();
                                                    });

                                                    function setSpecialCarousel() {
                                                        const additional1 = $('html').attr('dir');
                                                        $('.special-count-carousel').each(function () {
                                                            if ($(this).closest('#column-left').length == 0 && $(this).closest('#column-right').length == 0) {
                                                                $(this).addClass('owl-carousel owl-theme');
                                                                const items = $(this).data('items') || 1;
                                                                const sliderOptions = {
                                                                    loop: false,
                                                                    nav: true,
                                                                    autoplay: false,
                                                                    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                                                                    dots: false,
                                                                    items: items,
                                                                    responsiveRefreshRate: 200,
                                                                    responsive: {
                                                                        0: { items:1 },
                                                                        541: { items:2 },
                                                                        992: { items:3 },
                                                                        1200: { items:1 }
                                                                    }
                                                                };
                                                                if (additional1 == 'rtl') sliderOptions['rtl'] = true;
                                                                $(this).owlCarousel(sliderOptions);
                                                            }
                                                        });
                                                    }

                                                
                                            </script>
    <!--================== Deal Of The Day Section End ====================-->




    <?php $basketball_equipment_product_ids = App\model\CategoryProduct::select('product_id')->where('category_id', 45)->get()->toArray(); ?>
    <?php $basketball_equipment = App\model\Product::limit(8)
        ->where(['status' => 'active'])
        ->where('available', '>', 0)
        ->whereIn('id', $basketball_equipment_product_ids)
        ->get(); ?>
    @if (!$agent->isMobile())
        <!--========= Start New Arrivals Section =================-->
        <div class="box all-products mt-50 section-bg-light-grey desktop-view-product">
            <div class="container">
                <div class="box-heading">
                    <div class="box-content special">
                        <div class="page-title toggled">
                            <h1><span>Trending Products</span></h1>
                        </div>

                        <div class="block_box row">
                            <div id="special-carousel" class="box-product product-carousel-home clearfix" data-items="4">
                                @if ($basketball_equipment)
                                    @foreach ($basketball_equipment as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <?php $rat = $rating; ?>
                                        <div class="product-layout col-xs-12">
                                            <div class="product-thumb transition clearfix">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
                                                    </a>
                                                    {{--  @if ($row->discount)
                                                    <div class="sale-text"><span class="section-sale">Sale</span></div>
                                                @endif --}}
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
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i></button>
                                                    <a class="view-product-a"
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i
                                                            class="icon-eye"></i></a>
                                                    <button role="button" class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Whishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                </div>

                                                <div class="thumb-description clearfix">
                                                    <div class="caption">
                                                        <h4 class="product-title"><a
                                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
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

                                                            <p class="rating">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p>
                                                        </div>


                                                        <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: red; color: #fff;"
                                                                id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                Add to cart</button>
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
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    @if ($agent->isMobile())
        <!-- Mobile view product slide -->
        <div class="mobile-veiw-product section-bg-light-grey">
            <div class="page-title toggled">
                <h1><span>Trending Products</span></h1>
            </div>
            <div class="swiper-viewport">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        @if ($basketball_equipment)
                            @foreach ($basketball_equipment as $row)
                                <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                <div class="product-layout swiper-slide">
                                    <div class="product-thumb transition clearfix">
                                        <div class="image">
                                            <a
                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                   alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                <img class="img-responsive hover-img-1"
                                                    src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}" />
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
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
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
                                                    {{-- 
                                                    <p class="rating">
                                                        {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                    </p> --}}
                                                </div>


                                               {{--  <div class="product-footer-btn">
                                                    <button role="button" style="background: red; color: #fff;"
                                                        id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                        Cart</button>
                                                    <button role="button" style="background: #383085; color: #fff;"
                                                        class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Wishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                        Wishlist</button>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif


    <script>
        $('.mySwiper').swiper({
            mode: 'horizontal',
            slidesPerView: "auto",
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            autoplay: 1000000,
            autoplayDisableOnInteraction: true,
            loop: false
        });
    </script>
    <!-- Mobile view product slide -->




    <?php $top_banner = App\model\Slide::where(['type' => 'top-promo-banner', 'status' => 'active'])
        ->limit(2)
        ->get(); ?>
    <!--=========== Middle Section Start =============-->
    <div class="middle-section">
        <div class="container">
            <div class="row">
                @if ($top_banner)
                    @foreach ($top_banner as $key)
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}">
                                <div class="middle-image">
                                    <img src="{{ asset('public/' . public_file($key->image)) }}"  alt="{{ $key->image_alt ?? $key->title }}">
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- ============Middle Section End ===================-->






    <?php $gymnastic_equipment_product_ids = App\model\CategoryProduct::select('product_id')->where('category_id', 46)->get()->toArray(); ?>

    <?php $gymnastic_equipment = App\model\Product::limit(8)
        ->where(['status' => 'active'])
        ->where('available', '>', 0)
        ->whereIn('id', $gymnastic_equipment_product_ids)
        ->get(); ?>
    @if (!$agent->isMobile())
        <!--========= Start New Arrivals Section =================-->
        <div class="box all-products mt-50 section-bg-light-grey desktop-view-product">
            <div class="container">
                <div class="box-heading">
                    <div class="box-content special">
                        <div class="page-title toggled">
                            <h1><span>Best from Home Gym Equipment</span></h1>
                        </div>

                        <div class="block_box row">
                            <div id="special-carousel" class="box-product product-carousel-home clearfix" data-items="4">
                                @if ($gymnastic_equipment)
                                    @foreach ($gymnastic_equipment as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>

                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <?php $rat = $rating; ?>
                                        <div class="product-layout col-xs-12">
                                            <div class="product-thumb transition clearfix">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                           alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
                                                    </a>
                                                    {{--  @if ($row->discount)
                                                    <div class="sale-text"><span class="section-sale">Sale</span></div>
                                                @endif --}}
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
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i></button>
                                                    <a class="view-product-a"
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i
                                                            class="icon-eye"></i></a>
                                                    <button role="button" class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Whishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                </div>

                                                <div class="thumb-description clearfix">
                                                    <div class="caption">
                                                        <h4 class="product-title"><a
                                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
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

                                                            <p class="rating">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p>
                                                        </div>


                                                        <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: red; color: #fff;"
                                                                id="addToCartProduct"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                Add to cart</button>
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
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif







    @if ($agent->isMobile())
        <!-- Mobile view product slide -->
        <div class="mobile-veiw-product section-bg-light-grey">
            <div class="page-title toggled">
                <h1><span>Best from Home Gym Equipment</span></h1>
            </div>
            <div class="swiper-viewport">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        @if ($gymnastic_equipment)
                            @foreach ($gymnastic_equipment as $row)
                                <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                <div class="product-layout swiper-slide">
                                    <div class="product-thumb transition clearfix">
                                        <div class="image">
                                            <a
                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                   alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                <img class="img-responsive hover-img-1"
                                                    src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
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
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
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

                                                   {{--  <p class="rating">
                                                        {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                    </p> --}}
                                                </div>


                                               {{--  <div class="product-footer-btn">
                                                    <button role="button" style="background: red; color: #fff;"
                                                        id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                        Cart</button>
                                                    <button role="button" style="background: #383085; color: #fff;"
                                                        class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Wishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                        Wishlist</button>
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script>
        $('.mySwiper').swiper({
            mode: 'horizontal',
            slidesPerView: "auto",
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            autoplay: 1000000,
            autoplayDisableOnInteraction: true,
            loop: false
        });
    </script>
    <!-- Mobile view product slide -->


    <?php $fitness_equipment_product_ids = App\model\CategoryProduct::select('product_id')->where('category_id', 47)->get()->toArray(); ?>
    <?php $fitness_equipment = App\model\Product::limit(8)
        ->where(['status' => 'active'])
        ->where('available', '>', 0)
        ->whereIn('id', $fitness_equipment_product_ids)
        ->get(); ?>
    @if (!$agent->isMobile())
        <!--========= Start New Arrivals Section =================-->
        <div class="box all-products mt-50 desktop-view-product">
            <div class="container">
                <div class="box-heading">
                    <div class="box-content special">
                        <div class="page-title toggled">
                            <h1><span>Best From Fitness Equipment</span></h1>
                        </div>

                        <div class="block_box row">
                            <div id="special-carousel" class="box-product product-carousel-home clearfix" data-items="4">
                                @if ($fitness_equipment)
                                    @foreach ($fitness_equipment as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <?php $rat = $rating; ?>
                                        <div class="product-layout col-xs-12">
                                            <div class="product-thumb transition clearfix">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                           alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
                                                    </a>
                                                    {{--  @if ($row->discount)
                                                    <div class="sale-text"><span class="section-sale">Sale</span></div>
                                                @endif --}}
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
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i></button>
                                                    <a class="view-product-a"
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i
                                                            class="icon-eye"></i></a>
                                                    <button role="button" class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Whishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                </div>

                                                <div class="thumb-description clearfix">
                                                    <div class="caption">
                                                        <h4 class="product-title"><a
                                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
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

                                                            <p class="rating">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p>
                                                        </div>


                                                        <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: red; color: #fff;"
                                                                id="addToCartProduct"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                Add to cart</button>
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
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif




    @if ($agent->isMobile())
        <!-- Mobile view product slide -->
        <div class="mobile-veiw-product">
            <div class="page-title toggled">
                <h1><span>Best From Fitness Equipment</span></h1>
            </div>
            <div class="swiper-viewport">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        @if ($fitness_equipment)
                            @foreach ($fitness_equipment as $row)
                                <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                <div class="product-layout swiper-slide">
                                    <div class="product-thumb transition clearfix">
                                        <div class="image">
                                            <a
                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                   alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                <img class="img-responsive hover-img-1"
                                                    src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
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
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
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

                                                   {{--  <p class="rating">
                                                        {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                    </p> --}}
                                                </div>


                                                {{-- <div class="product-footer-btn">
                                                    <button role="button" style="background: red; color: #fff;"
                                                        id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                        Cart</button>
                                                    <button role="button" style="background: #383085; color: #fff;"
                                                        class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Wishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                        Wishlist</button>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script>
        $('.mySwiper').swiper({
            mode: 'horizontal',
            slidesPerView: "auto",
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            autoplay: 1000000,
            autoplayDisableOnInteraction: true,
            loop: false
        });
    </script>
    <!-- Mobile view product slide -->









    <?php $bottom_banner = App\model\Slide::where(['type' => 'bottom-promo-banner', 'status' => 'active'])
        ->limit(2)
        ->get(); ?>
    <!--=========== Middle Section Start =============-->
    @if ($bottom_banner && count($bottom_banner) > 0)
        <div class="middle-section dsda">
            <div class="container">
                <div class="row">
                    @if ($bottom_banner)
                        @foreach ($bottom_banner as $key)
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <a href="{{ $key->see_more_link ? $key->see_more_link : '#' }}">
                                    <div class="middle-image">
                                        <img src="{{ asset('public/' . public_file($key->image)) }}"  alt="{{ $key->image_alt ?? '' }}">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endif
    <!-- ============Middle Section End ===================-->



    <?php $bottomslide = App\model\Slide::where(['type' => 'bottomslider', 'status' => 'active'])
        ->limit(5)
        ->get();
    $flag = 0;
    $flag1 = 0; ?>


    <!--================== Full Slider Width Start ========-->
    <div id="carousel-example-generic" class="carousel slide td-slider" data-ride="carousel">
        <!-- Indicators -->
        @if ($bottomslide)
            <ol class="carousel-indicators">
                @foreach ($bottomslide as $key)
                    <?php ++$flag1; ?>
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="<?php if ($flag1 == 1) {
                        echo 'active';
                    } ?>"></li>
                @endforeach
            </ol>
        @endif

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

            @if ($bottomslide)
                @foreach ($bottomslide as $key)
                    <?php ++$flag; ?>
                    <div class="item <?php if ($flag == 1) {
                        echo 'active';
                    } ?> slider-midd-img">
                        <img src="{{ asset('public/' . public_file($key->image)) }}" alt="{{ $key->image_alt ?? '' }}">
                        <div class="carousel-caption">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!--============== Full SLider Width End ================-->


    <?php $featured = App\model\Product::limit(8)
        ->where(['type' => 'featured', 'status' => 'active'])
        ->where('discount', '=', null)
        ->where('available', '>', 0)
        ->get(); ?>
    @if (!$agent->isMobile())
        <!--========= Start New Arrivals Section =================-->
        <div class="box all-products mt-50 desktop-view-product">
            <div class="container">
                <div class="box-heading">
                    <div class="box-content special">
                        <div class="page-title toggled">
                            <h1><span>Featured Products</span></h1>
                        </div>

                        <div class="block_box row">
                            <div id="special-carousel" class="box-product product-carousel-home clearfix" data-items="4">
                                @if ($featured)
                                    @foreach ($featured as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <?php $rat = $rating; ?>
                                        <div class="product-layout col-xs-12">
                                            <div class="product-thumb transition clearfix">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                        <img class="img-responsive hover-img-1"
                                                            src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}" />
                                                    </a>
                                                    {{--  @if ($row->discount)
                                                <div class="sale-text"><span class="section-sale">Sale</span></div>
                                            @endif --}}
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
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i></button>
                                                    <a class="view-product-a"
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i
                                                            class="icon-eye"></i></a>
                                                    <button role="button" class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Whishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i></button>
                                                </div>

                                                <div class="thumb-description clearfix">
                                                    <div class="caption">
                                                        <h4 class="product-title"><a
                                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 10) }}</a>
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

                                                            <p class="rating">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p>
                                                        </div>


                                                        <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: red; color: #fff;"
                                                                id="addToCartProduct"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                Add to cart</button>
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
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    @if ($agent->isMobile())
        <!-- Mobile view product slide -->
        <div class="mobile-veiw-product">
            <div class="page-title toggled">
                <h1><span>Featured Products</span></h1>
            </div>
            <div class="swiper-viewport">
                <div class="swiper-container mySwiper">
                    <div class="swiper-wrapper">
                        @if ($featured)
                            @foreach ($featured as $row)
                                <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                <div class="product-layout swiper-slide">
                                    <div class="product-thumb transition clearfix">
                                        <div class="image">
                                            <a
                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                   alt="{{ $row->feature_image_alt ?? '' }}" title="" class="img-responsive" />
                                                <img class="img-responsive hover-img-1"
                                                    src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}" alt="{{ $row->feature_image_alt ?? '' }}"/>
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
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 8) }}</a>
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

                                                   {{--  <p class="rating">
                                                        {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                    </p> --}}
                                                </div>


                                                {{-- <div class="product-footer-btn">
                                                    <button role="button" style="background: red; color: #fff;"
                                                        id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                        Cart</button>
                                                    <button role="button" style="background: #383085; color: #fff;"
                                                        class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Wishlist"><i
                                                            class="fa {{ in_array($row->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                        Wishlist</button>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script>
        $('.mySwiper').swiper({
            mode: 'horizontal',
            slidesPerView: "auto",
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 0,
            autoplay: 1000000,
            autoplayDisableOnInteraction: true,
            loop: false
        });
    </script>
    <!-- Mobile view product slide -->











    <!--========== Subscribe Emails POP Up Start ===============-->
    <div class="modal fade newsletter-popup" id="newsletter-popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="newsletter-wrap clearfix">
                        <div class="newsletter-content"></div>
                        <div class="newsletter-content-innner">
                            <h1>LOCATION</h1>
                            <p>Select your location/address to see accurate product delivery date.</p>
                            {{ Form::open(['url' => route('availability'), 'class' => 'checkpincode-form-modal', 'id' => 'checkAvailability_home']) }}
                            <div class="check-availability">
                                <div class="input-group">
                                    <input type="text" name="pincode" class="form-control"
                                        placeholder="Enter your area pincode" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button type="submit" id="checkDeliveryAvailability"
                                            class="btn btn-primary btn-dark" name="Check">Check</button>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                            <div class="newsletter-popup-message"></div>
                            {{--  <div class="newsletter-content-bottom">
                                                    <input type="checkbox" id="popup_dont_show_again" />
                                                    <label for="popup_dont_show_again">Don't show this popup again!</label>
                                                </div> --}}
                        </div>

                        <button type="button" class="newsletter-btn-close close" data-dismiss="modal"
                            aria-label="Close"><i class="icon-close"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #checkAvailability_home .input-group button.btn {
            height: 42px;
        }

        .newsletter-content {
            background: url({{ asset('public/assets/img/delivery.png') }}) no-repeat center center;
            max-width: 250px;
            width: 100%;
            height: 280px;
            max-height: 100%;
            margin-right: 50px;
        }
    </style>

    <script>
        function subscribe_popup() {
            $.ajax({
                type: 'post',
                url: '#',
                dataType: 'html',
                data: $("#frmnewsletterpopup").serialize(),
                success: function(html) {
                    try {
                        eval(html);
                    } catch (e) {}
                }
            });
        }
    </script>
    <script>
        <!--
        // check for validation
        $(document).ready(function() {
            $('#newsletter_usr_popup_email').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    subscribe_popup();
                }
            });

            //transition effect
            // if($.cookie("showpopup") != 1){
            //     $('#newsletter-popup').modal('show');
            // }
            // $('#popup_dont_show_again').on('change', function(){
            //     if($.cookie("showpopup") != 1){
            //         $.cookie("showpopup",'1')
            //     }else{
            //         $.cookie("showpopup",'0')
            //     }
            // });
        });
        //
        -->
    </script>

    <!--========== Subscribe Emails POP Up End ===============-->
    </div>




@endsection
