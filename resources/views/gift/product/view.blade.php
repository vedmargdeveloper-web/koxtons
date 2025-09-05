@extends(_app())

<?php $image_url = asset('public/assets/images/logo.jpg'); ?>

@if ($product)
    <?php $image_url = asset('public/' . product_file($product->feature_image)); ?>
@endif

@section('og-url', current_url())
@section('og-type', 'product')
@if (isset($product) && is_object($product) && $product->metatitle !== null)
    @section('og-title', $product->metatitle ?? '')
@else
    @section('og-title', $title)
@endif

@section('og-keywords', $product ? $product->metakey : '')
@section('og-content', $product ? $product->metadescription : '')
@section('og-image-url', $image_url)


@section('content')

    <!-- Page Content Wraper -->
    <div class="page-content-wraper">

        @if ($product)

            <?php $wishListProduct = []; ?>
            @if (Cookie::get('wishlistProduct'))
                <?php $wishListProduct = json_decode(Cookie::get('wishlistProduct')); ?>
            @endif

            <?php $reviews = App\model\Review::where('product_id', $product->product_id)
                ->orderby('created_at', 'DESC')
                ->paginate(10); ?>

            <?php $category = App\model\Category::where('id', $product->category_id)->first(); ?>
            <?php $parentcategory = $category ? App\model\Category::where('id', $category->parent)->first() : false; ?>
            <?php $category_name = $category ? $category->name : '';
            $category_slug = $category ? $category->slug : ''; ?>

            <!-- Bread Crumb -->
            {{-- <section class="">
                <div class="container ">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-12 mt-10">
                                <nav class="breadcrumb-link">
                                    <a href="{{ url('/') }}">Home</a>
                                    @if ($parentcategory)
                                        <a href="{{ url('/' . $parentcategory->slug) }}">
                                            {{ ucwords($parentcategory->name) }}</a>
                                        <a href="{{ url('/' . $parentcategory->slug . '/' . $category_slug) }}">
                                            {{ ucwords($category_name) }}</a>
                                    @else
                                        <a href="{{ url('/' . $category_slug) }}">{{ ucwords($category_name) }}</a>
                                    @endif
                                    <span>{{ ucwords($product->title) }}</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
           <section>
                <div class="container">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-12 mt-10" style="padding: 10px 0; font-family: Arial, sans-serif; font-size: 14px;">
                                <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">Home</a>
                                    
                                    @if ($parentcategory)
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <a href="{{ url('/' . $parentcategory->slug) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                            {{ ucwords($parentcategory->name) }}
                                        </a>
                                        
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <a href="{{ url('/' . $parentcategory->slug . '/' . $category_slug) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                            {{ ucwords($category_name) }}
                                        </a>
                                    @else
                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                        <a href="{{ url('/' . $category_slug) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                            {{ ucwords($category_name) }}
                                        </a>
                                    @endif
                                    
                                    <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                    <span style="color: #555; ">{{ ucwords($product->title) }}</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Bread Crumb -->

            <!-- Page Content -->
            <section id="product-{{ $product->product_id }}"
                class="content-page single-product-content product-content-page">

                <!-- Product -->
                <div id="product-detail" class="container">
                    <div class="row">
                        @if ($product->status != 'active')
                            <div class="col-12">
                                <p style="margin:0;color:#f34141;">This product is not active, you are seeing preview.</p>
                            </div>
                        @endif

                        <div class="col-md-12" style="display: none;">
                            <div class="">
                               <nav class="breadcrumb-link" style="display: flex; align-items: center; flex-wrap: wrap; font-size: 14px; color: #555;">
                                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">Home</a>

                                    @if ($product->product_category && count($product->product_category) > 0)
                                        @foreach ($product->product_category as $cat)
                                            @if (!$cat->parent)
                                                <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                                <a href="{{ route('product.category', [$cat->slug]) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                                    {{ ucwords($cat->name) }}
                                                </a>

                                                @foreach ($product->product_category as $child)
                                                    @if ($cat->id == $child->parent)
                                                        <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                                        <a href="{{ route('category.product', [$cat->slug, $child->slug]) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                                            {{ ucwords($child->name) }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif

                                    <span style="margin: 0 5px; color: #555; ">{{ ucwords($product->title) }}</span>
                                </nav>

                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-lg-6 col-md-6 col-sm-12 mb-30">

                            <div class="wrapper">

                                <!-- Product Images & Alternates -->
                                <div class="product-images">
                                    <div role="button" class="single-btn-wishlist" id="addToWishlist"
                                        data-value="{{ $product->product_id }}" data-id="{{ $product->id }}"
                                        data-mode="top" data-tip="Add To Whishlist"><i
                                            class="fa {{ in_array($product->product_id, $wishListProduct) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                    </div>
                                    <!-- Begin Product Images Slider -->
                                    <div class="main-img-slider">
                                        <figure>
                                            <a href="{{ asset('public/' . product_file(thumb($product->feature_image, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                data-size="800x800">
                                                <img class="lazyload"
                                                    data-src="{{ asset('public/' . product_file(thumb($product->feature_image, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                    data-lazy="{{ asset('public/' . product_file(thumb($product->feature_image, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                    alt="{{ $product->feature_image_alt ?? 'Feature Image'}}" />
                                            </a>
                                        </figure>

                                        <?php $medias = false; ?>
                                        @if (isset($product->media[0]) && count($product->media) > 0)
                                            <?php $medias = $product->media; ?>
                                            @foreach ($medias as $media)
                                                @if ($media->type === 'gallery')
                                                    <?php $files = explode(',', $media->files); ?>
                                                    @foreach ($files as $file)
                                                        <figure>
                                                            <a class="product-gallery-item"
                                                                href="{{ asset('public/' . product_file(thumb($file, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                                data-size="800x800">
                                                                <img class="lazyload"
                                                                    data-src="{{ asset('public/' . product_file(thumb($file, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                                    data-lazy="{{ asset('public/' . product_file(thumb($file, config('filesize.large.0'), config('filesize.large.1')))) }}"
                                                                    alt="{{ $product->file_alt  ?? 'Gallery  Image'}}" />
                                                            </a>
                                                        </figure>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <!-- End Product Images Slider -->

                                    <!-- Begin product thumb nav -->
                                    <ul class="thumb-nav product-gallery-slider-div">
                                        <li>
                                            <img class="lazyload" src="{{ $image_url }}" alt="{{ $product->file_alt  ?? 'Product Gallery Image Slider'}}" />
                                        </li>
                                        @if ($product->media && count($product->media) > 0)
                                            @foreach ($product->media as $media)
                                                @if ($media->type === 'gallery')
                                                    <?php $files = explode(',', $media->files); ?>
                                                    @foreach ($files as $file)
                                                        <li>
                                                            <img class="lazyload"
                                                                src="{{ asset('public/' . product_file(thumb($file, config('filesize.thumbnail.0'), config('filesize.thumbnail.1')))) }}"
                                                                alt="{{ $product->file_alt ?? 'Gallery Image' }}" />
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                    <!-- End product thumb nav -->
                                </div>
                                <!-- End Product Images & Alternates -->


                                <!-- Begin Product Image Zoom -->
                                <!--
                                This should live at bottom of page before closing body tag
                                So that it renders on top of all page elements.
                                -->

                                <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                    <!-- Background of PhotoSwipe.
                                                                                                             It's a separate element, as animating opacity is faster than rgba(). -->
                                    <div class="pswp__bg"></div>

                                    <!-- Slides wrapper with overflow:hidden. -->
                                    <div class="pswp__scroll-wrap">

                                        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                        <div class="pswp__container">
                                            <!-- don't modify these 3 pswp__item elements, data is added later on -->
                                            <div class="pswp__item"></div>
                                            <div class="pswp__item"></div>
                                            <div class="pswp__item"></div>
                                        </div>

                                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                        <div class="pswp__ui pswp__ui--hidden">

                                            <div class="pswp__top-bar">

                                                <!--  Controls are self-explanatory. Order can be changed. -->

                                                <div class="pswp__counter"></div>

                                                <button class="pswp__button pswp__button--close"
                                                    title="Close (Esc)"></button>

                                                <button class="pswp__button pswp__button--share" title="Share"></button>

                                                <button class="pswp__button pswp__button--fs"
                                                    title="Toggle fullscreen"></button>

                                                <button class="pswp__button pswp__button--zoom"
                                                    title="Zoom in/out"></button>

                                                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                                <!-- element will get class pswp__preloader--active when preloader is running -->
                                                <div class="pswp__preloader">
                                                    <div class="pswp__preloader__icn">
                                                        <div class="pswp__preloader__cut">
                                                            <div class="pswp__preloader__donut"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                <div class="pswp__share-tooltip"></div>
                                            </div>

                                            <button class="pswp__button pswp__button--arrow--left"
                                                title="Previous (arrow left)">
                                            </button>

                                            <button class="pswp__button pswp__button--arrow--right"
                                                title="Next (arrow right)">
                                            </button>
                                            <div class="pswp__caption">
                                                <div class="pswp__caption__center"></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!--  End product zoom  -->

                            </div>

                            <link href="{{ asset('assets/plugins/photoswipe_popup/photoswipe.css') }}" rel="stylesheet"
                                type="text/css" />
                            <link href="{{ asset('assets/plugins/photoswipe_popup/default-skin/default-skin.css') }}"
                                rel="stylesheet" type="text/css" />
                            <script type="text/javascript" src="{{ asset('assets/js/plugins/slick.min.js') }}"></script>
                            <script type="text/javascript" src="{{ asset('assets/plugins/photoswipe_popup/photoswipe.min.js') }}"></script>
                            <script type="text/javascript" src="{{ asset('assets/plugins/photoswipe_popup/photoswipe-ui-default.min.js') }}">
                            </script>
                            <style type="text/css">
                                .main-img-slider.slick-slider .slick-prev {
                                    left: 0 !important;
                                }

                                .main-img-slider.slick-slider .slick-next {
                                    right: 0 !important;
                                }

                                .sr-text {
                                    position: absolute !important;
                                    top: -9999px !important;
                                    left: -9999px !important;
                                }

                                .slick-slider .slick-prev,
                                .slick-slider .slick-next {
                                    /* z-index: 100; */
                                    font-size: 2.5em;
                                    height: 30px;
                                    width: 30px;
                                    color: #B7B7B7;
                                    position: absolute;
                                    top: 50%;
                                    text-align: center;
                                    color: #000;
                                    background: #fff;
                                    border-radius: 50%;
                                    /* box-shadow: 0 0 2px 1px rgba(0,0,0,.5); */
                                    opacity: .3;
                                    transition: opacity .25s;
                                    cursor: pointer;
                                }

                                .slick-slider .slick-prev:hover,
                                .slick-slider .slick-next:hover {
                                    opacity: .65;
                                }

                                .slick-slider .slick-prev {
                                    left: -33px;
                                }

                                .slick-slider .slick-next {
                                    right: -33px;
                                }

                                .slick-slider .slick-prev:before,
                                .slick-slider .slick-next:before {
                                    line-height: 30px;
                                }

                                .wrapper {
                                    width: 100%;
                                    margin: 0;
                                    font-family: '';
                                    box-shadow: 0 0 5px 0 #ccc6;
                                    background: #fff;
                                    border-radius: 10px;
                                    height: 100%;
                                    /* transition: 0.3s all; */
                                }

                                .wrapper:hover {
                                    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
                                    /* transform: scale(1.02); */
                                }

                                .product-images {
                                    width: 100%;
                                    max-width: 100%;
                                    margin: 0 auto;
                                    padding: 0em 0;
                                }

                                .product-images li,
                                .product-images figure,
                                .product-images a,
                                .product-images img {
                                    display: block;
                                    outline: none;
                                    border: none;
                                    width: 100%;

                                }

                                .product-images .main-img-slider figure {
                                    margin: 0 auto;
                                    padding: 0 0em;
                                }

                                .product-images .main-img-slider figure a {
                                    cursor: pointer;
                                    cursor: -webkit-zoom-in;
                                    cursor: -moz-zoom-in;
                                    cursor: zoom-in;
                                }

                                .product-images .main-img-slider figure a img {
                                    width: 100%;
                                    max-width: 100%;
                                    margin: 0 auto;
                                }

                                .product-images .thumb-nav {
                                    margin: 0 auto;
                                    margin-top: 10px;
                                    margin-bottom: 10px;
                                    max-width: 90%;
                                    padding: 0;
                                }

                                .product-images .thumb-nav.slick-slider .slick-prev,
                                .product-images .thumb-nav.slick-slider .slick-next {
                                    font-size: 1.2em;
                                    height: 30px;
                                    width: 30px;
                                    margin-top: 0px;
                                }

                                .product-images .thumb-nav.slick-slider .slick-prev {
                                    margin-left: 0px;
                                }

                                .product-images .thumb-nav.slick-slider .slick-next {
                                    margin-right: 0px;
                                }

                                .product-images .thumb-nav li {
                                    display: block;
                                    margin: 0 auto;
                                    cursor: pointer;
                                    margin-bottom: 10px;
                                }

                                .product-images .thumb-nav li img {
                                    display: block;
                                    width: 100%;
                                    max-width: -webkit-fill-available;
                                    margin: 0 3px;
                                    border: 1px solid #f3f3f3;
                                    -webkit-transition: border-color .25s;
                                    -ms-transition: border-color .25s;
                                    -moz-transition: border-color .25s;
                                    transition: border-color .25s;
                                    box-shadow: 0 0 5px 0 #ccc6;
                                    background: #fff;
                                    border-radius: 10px;
                                }

                                .product-images .thumb-nav li:hover,
                                .product-images .thumb-nav li:focus {
                                    border-color: #999;
                                }

                                .product-images .thumb-nav li.slick-current img {
                                    border-color: #e31f23;
                                }

                                .pswp__bg {
                                    background: #fff;
                                }

                                .pswp__top-bar {
                                    background-color: transparent !important;
                                }

                                .pswp__button,
                                .pswp__button:before,
                                .pswp__button--close:before,
                                .pswp__button--arrow--left:before,
                                .pswp__button--arrow--right:before {
                                    background: none !important;
                                    background-size: 100%;
                                    width: 30px;
                                    height: 30px;
                                    font-family: 'Fontawesome';
                                }

                                .pswp__counter {
                                    color: #333;
                                }

                                .pswp__button {
                                    color: #000 !important;
                                    opacity: 0.4 !important;
                                    transition: opacity .25s;
                                }

                                .pswp__button:hover {
                                    opacity: 0.65 !important;
                                }

                                .pswp__button:before {
                                    opacity: 1 !important;
                                }

                                .pswp__button.pswp__button--arrow--left:before,
                                .pswp__button.pswp__button--arrow--right:before {
                                    font-size: 30px;
                                }

                                .pswp__button.pswp__button--arrow--left:before {
                                    content: "\f104";
                                }

                                .pswp__button.pswp__button--arrow--right:before {
                                    content: "\f105";
                                }

                                .pswp__button.pswp__button--close {
                                    top: 10px;
                                    right: 20px;
                                }

                                .pswp__button.pswp__button--close:before {
                                    content: "\f00d";
                                    font-size: 30px;
                                }

                                .pswp__button.pswp__button--close:hover {
                                    color: red;
                                }
                            </style>
                            <script type="text/javascript">
                                // Main/Product image slider for product page
                                $('.main-img-slider').slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    infinite: true,
                                    arrows: true,
                                    fade: true,
                                    speed: 300,
                                    lazyLoad: 'ondemand',
                                    asNavFor: '.thumb-nav',
                                    prevArrow: '<div class="slick-prev"><i class="i-chev-left-thin"></i><span class="sr-text">Previous</span></div>',
                                    nextArrow: '<div class="slick-next"><i class="i-chev-right-thin"></i><span class="sr-text">Next</span></div>'
                                });
                                // Thumbnail/alternates slider for product page
                                $('.thumb-nav').slick({
                                    slidesToShow: 5,
                                    slidesToScroll: 1,
                                    infinite: true,
                                    centerPadding: '0px',
                                    asNavFor: '.main-img-slider',
                                    dots: false,
                                    centerMode: true,
                                    draggable: false,
                                    speed: 200,
                                    focusOnSelect: true,
                                    prevArrow: '<div class="slick-prev"><i class="i-chev-left-thin"></i><span class="sr-text">Previous</span></div>',
                                    nextArrow: '<div class="slick-next"><i class="i-chev-right-thin"></i><span class="sr-text">Next</span></div>'
                                });

                                //keeps thumbnails active when changing main image, via mouse/touch drag/swipe
                                $('.main-img-slider').on('afterChange', function(event, slick, currentSlide, nextSlide) {
                                    //remove all active class
                                    $('.thumb-nav .slick-slide').removeClass('slick-current');
                                    //set active class for current slide
                                    $('.thumb-nav .slick-slide:not(.slick-cloned)').eq(currentSlide).addClass('slick-current');
                                });

                                //Photoswipe configuration for product page zoom
                                var initPhotoSwipeFromDOM = function(gallerySelector) {

                                    // parse slide data (url, title, size ...) from DOM elements 
                                    // (children of gallerySelector)
                                    var parseThumbnailElements = function(el) {
                                        var thumbElements = el.childNodes,
                                            numNodes = thumbElements.length,
                                            items = [],
                                            figureEl,
                                            linkEl,
                                            size,
                                            item;

                                        for (var i = 0; i < numNodes; i++) {

                                            figureEl = thumbElements[i]; // <figure> element

                                            // include only element nodes 
                                            if (figureEl.nodeType !== 1) {
                                                continue;
                                            }

                                            linkEl = figureEl.children[0]; // <a> element

                                            size = linkEl.getAttribute('data-size').split('x');

                                            // create slide object
                                            item = {
                                                src: linkEl.getAttribute('href'),
                                                w: parseInt(size[0], 10),
                                                h: parseInt(size[1], 10)
                                            };



                                            if (figureEl.children.length > 1) {
                                                // <figcaption> content
                                                item.title = figureEl.children[1].innerHTML;
                                            }

                                            if (linkEl.children.length > 0) {
                                                // <img> thumbnail element, retrieving thumbnail url
                                                item.msrc = linkEl.children[0].getAttribute('src');
                                            }

                                            item.el = figureEl; // save link to element for getThumbBoundsFn
                                            items.push(item);
                                        }

                                        return items;
                                    };

                                    // find nearest parent element
                                    var closest = function closest(el, fn) {
                                        return el && (fn(el) ? el : closest(el.parentNode, fn));
                                    };

                                    // triggers when user clicks on thumbnail
                                    var onThumbnailsClick = function(e) {
                                        e = e || window.event;
                                        e.preventDefault ? e.preventDefault() : e.returnValue = false;

                                        var eTarget = e.target || e.srcElement;

                                        // find root element of slide
                                        var clickedListItem = closest(eTarget, function(el) {
                                            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                                        });

                                        if (!clickedListItem) {
                                            return;
                                        }

                                        // find index of clicked item by looping through all child nodes
                                        // alternatively, you may define index via data- attribute
                                        var clickedGallery = clickedListItem.parentNode,
                                            childNodes = clickedListItem.parentNode.childNodes,
                                            numChildNodes = childNodes.length,
                                            nodeIndex = 0,
                                            index;

                                        for (var i = 0; i < numChildNodes; i++) {
                                            if (childNodes[i].nodeType !== 1) {
                                                continue;
                                            }

                                            if (childNodes[i] === clickedListItem) {
                                                index = nodeIndex;
                                                break;
                                            }
                                            nodeIndex++;
                                        }



                                        if (index >= 0) {
                                            // open PhotoSwipe if valid index found
                                            openPhotoSwipe(index, clickedGallery);
                                        }
                                        return false;
                                    };

                                    // parse picture index and gallery index from URL (#&pid=1&gid=2)
                                    var photoswipeParseHash = function() {
                                        var hash = window.location.hash.substring(1),
                                            params = {};

                                        if (hash.length < 5) {
                                            return params;
                                        }

                                        var vars = hash.split('&');
                                        for (var i = 0; i < vars.length; i++) {
                                            if (!vars[i]) {
                                                continue;
                                            }
                                            var pair = vars[i].split('=');
                                            if (pair.length < 2) {
                                                continue;
                                            }
                                            params[pair[0]] = pair[1];
                                        }

                                        if (params.gid) {
                                            params.gid = parseInt(params.gid, 10);
                                        }

                                        return params;
                                    };

                                    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                                        var pswpElement = document.querySelectorAll('.pswp')[0],
                                            gallery,
                                            options,
                                            items;

                                        items = parseThumbnailElements(galleryElement);

                                        // define options (if needed)
                                        options = {
                                            // captionEl : false,
                                            // fullscreenEl : false,
                                            // shareEl : false,
                                            // bgOpacity : 1,
                                            // tapToClose : true,
                                            // tapToToggleControls : false,
                                            // closeOnScroll: false,
                                            // history:false,
                                            // closeOnVerticalDrag:false,
                                            // captionEl: false,
                                            // fullscreenEl: false,
                                            // zoomEl: false,
                                            // shareEl: false,
                                            // counterEl: false,
                                            // arrowEl: true,          
                                            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                                            getThumbBoundsFn: function(index) {
                                                // See Options -> getThumbBoundsFn section of documentation for more info
                                                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                                                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                                    rect = thumbnail.getBoundingClientRect();

                                                return {
                                                    x: rect.left,
                                                    y: rect.top + pageYScroll,
                                                    w: rect.width
                                                };
                                            }

                                        };

                                        // PhotoSwipe opened from URL
                                        if (fromURL) {
                                            if (options.galleryPIDs) {
                                                // parse real index when custom PIDs are used 
                                                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                                                for (var j = 0; j < items.length; j++) {
                                                    if (items[j].pid == index) {
                                                        options.index = j;
                                                        break;
                                                    }
                                                }
                                            } else {
                                                // in URL indexes start from 1
                                                options.index = parseInt(index, 10) - 1;
                                            }
                                        } else {
                                            options.index = parseInt(index, 10);
                                        }

                                        // exit if index not found
                                        if (isNaN(options.index)) {
                                            return;
                                        }

                                        if (disableAnimation) {
                                            options.showAnimationDuration = 0;
                                        }

                                        // Pass data to PhotoSwipe and initialize it
                                        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                                        gallery.init();
                                        var psIndex = gallery.getCurrentIndex();
                                        var psIndexSlick = psIndex;
                                        // console.log(psIndexSlick);
                                        gallery.listen('afterChange', function() {
                                            var psIndex = gallery.getCurrentIndex();
                                            var psIndexSlick = psIndex;
                                            // console.log(psIndexSlick);
                                            $(".main-img-slider").slick("slickGoTo", psIndexSlick);
                                        });
                                    };


                                    var options = {
                                        loop: false
                                    };
                                    // loop through all gallery elements and bind events
                                    var galleryElements = document.querySelectorAll(gallerySelector);

                                    for (var i = 0, l = galleryElements.length; i < l; i++) {
                                        galleryElements[i].setAttribute('data-pswp-uid', i + 1);
                                        galleryElements[i].onclick = onThumbnailsClick;
                                    }

                                    // Parse URL and open gallery if it contains #&pid=3&gid=1
                                    var hashData = photoswipeParseHash();
                                    if (hashData.pid && hashData.gid) {
                                        openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
                                    }
                                };

                                // execute above function
                                initPhotoSwipeFromDOM('.product-images');
                            </script>

                        </div>
                        <!-- End Product Image -->

                        <!-- Product Content -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                            <div class="ddd">
                                {{-- <div class=" breadcrumb-large dd-large">
                                    <nav class="breadcrumb-link" style="display: flex; align-items: center; flex-wrap: wrap; font-size: 14px; color: #555;">
                                        <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">Home</a>

                                        @if ($product->product_category && count($product->product_category) > 0)
                                            @foreach ($product->product_category as $cat)
                                                @if (!$cat->parent)
                                                    <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                                    <a href="{{ route('product.category', [$cat->slug]) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                                        {{ ucwords($cat->name) }}
                                                    </a>

                                                    @foreach ($product->product_category as $child)
                                                        @if ($cat->id == $child->parent)
                                                            <span style="margin: 0 5px; color: #555;">&raquo;</span>
                                                            <a href="{{ route('category.product', [$cat->slug, $child->slug]) }}" style="color: #007bff; text-decoration: none; margin-right: 5px;">
                                                                {{ ucwords($child->name) }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif

                                        <span style="margin: 0 5px; color: #555; ">{{ ucwords($product->title) }}</span>
                                    </nav>

                                </div> --}}
                            </div>

                            <div class="product-page-content">
                                @if ($product->product_brand && count($product->product_brand) > 0)
                                    <div class="product-brand">
                                        <a href=""
                                            class="brand-name">{{ ucwords($product->product_brand[0]->name) }}</a>
                                    </div>
                                @endif
                                <h1 class="product-title">{{ ucwords($product->title) }}</h1>
                                @if ($user = App\User::where(['role' => 'seller', 'id' => $product->user_id])->first())
                                    <p><strong>Seller:</strong> {{ ucwords($user->first_name . ' ' . $user->last_name) }}
                                    </p>
                                @endif
                                <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : false; ?>
                                @if ($rating)
                                    <div style="" class="product-rating">
                                        <div class="star-ratings-sprite">
                                            <span style="width:{{ $rating * 10 * 2 }}%;"
                                                class="star-ratings-sprite-rating"></span>
                                        </div> {{ round($rating) . '/5 Stars' }}
                                        <a role="button" id="tabReview" class="product-rating-count" style="color: #007bff !important;">
                                            <span class="count" >{{ count($reviews) }}</span> Reviews</a>
                                    </div>
                                @endif
                                <span class="get-product-mrp" style="display: none" title="{{ $product->mrp }}"></span>
                                <div class="product-price product-price-wrapper">
                                    {{-- @if ($product->price_range) --}}
                                    {{--  <span><span class="fa fa-inr"></span> 
                                    <span class="product-price-text">{{ $product->price_range  }}</span>
                                    </span> --}}
                                    {{-- @else --}}



                                    <?php $price = $product->price; ?>
                                    @if ($product->discount)
                                        {{-- <del><span class="fa fa-inr"></span> {{ $price }}</del> --}}
                                        <?php $price = $price - ($price * $product->discount) / 100; ?>
                                    @endif

                                    <span>
                                        <span class="fa fa-inr"></span>
                                        @if ($product->tax)
                                            <?php $price = $price + ($price * $product->tax) / 100; ?>
                                        @endif
                                        <span class="product-price-text">{{ round($price) }}
                                            @if ($price == $product->mrp)
                                                <p class="mrp-single">MRP</p>
                                            @endif
                                        </span>
                                        @if ($product->discount)
                                            <sup
                                                class="discount-off text-center">{{ '-' . $product->discount . '%' }}</sup>
                                        @endif

                                    </span>
                                    @if ($price < $product->mrp)
                                        <p class="mrp-single">MRP <span class="fa fa-inr">
                                                <del>{{ $product->mrp }}</del></span></p>
                                    @endif

                                    @if ($product->shipping_charge)
                                        <span class="shipping-charge" style="display: none;"> + <span
                                                class="fa fa-inr"></span> {{ $product->shipping_charge }} (Shipping
                                            charge)</span>
                                    @endif
                                    {{-- @endif --}}
                                </div>

                                <div class="product-description">
                                    @if ($product->excerpt)
                                    <h3>About This Item</h3>
                                        <p><?php echo $product->short_content; ?>
                                            <a class="description active" id="readMoreTab"
                                                href="{{ current_url() . '#read-more' }}" role="tab"
                                                data-toggle="tab"></a>
                                        </p>
                                    @endif

                                    <?php $video = ''; ?>
                                    @if (isset($product->media[0]) && count($product->media) > 0)
                                        @foreach ($product->media as $media)
                                            @if ($media->type === 'video')
                                                <?php $video = $media->files; ?>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if ($video)
                                        <p>
                                            <a role="button" title="Watch Video" class="product-video">
                                                <img class="lazyload" style="width:30px;"
                                                    data-src="{{ asset('assets/img/video-icon.png') }}">
                                            </a>
                                        </p>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product-filters">

                                        <form class="product-add-to-cart-form" data-id="{{ $product->id }}"
                                            data-product="{{ $product->product_id }}">

                                            {{ csrf_field() }}
                                            <input type="hidden" name="check_type" class="check-type-form">
                                            <?php $color_meta = App\model\product_meta_colors::where('product_id', $product->id)
                                                ->orderBy('id', 'asc')
                                                ->get(); ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    @if ($color_meta)
                                                        <div class="filters-color mb-3">
                                                            @if ($product->productMeta[0]->color)
                                                                <label for="select-color">Select Color</label>
                                                            @endif
                                                            <?php $color = explode(',', $product->productMeta[0]->color); ?>
                                                            <div class="color-selector">
                                                                @foreach ($color_meta as $key => $c)
                                                                    <div data-value="{{ $c->color }}"
                                                                        data-pid="{{ $product->id }}"
                                                                        class="color entry {{ $key < 1 ? 'active' : '' }}"
                                                                        style="background: {{ $c->color }};">&nbsp;
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif


                                                    <?php $custom_size = $waist_size = $tsizes = $child_size = $footweer_size = []; ?>
                                                    @if ($product->product_attribute_meta)
                                                        <?php $attrCSize = App\model\ProductAttributeMeta::where(['product_id' => $product->id])->first(); ?>

                                                        @if ($attrCSize)
                                                            @foreach ($product->product_attribute_meta as $meta)
                                                                <?php
                                                                if ($meta->type === 'custom_size') {
                                                                    $json = json_decode($meta->value);
                                                                    if ($json && isset($json->name) && $json->name) {
                                                                        $custom_size[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name];
                                                                    }
                                                                } elseif ($meta->type === 'size') {
                                                                    $json = json_decode($meta->value);
                                                                    if ($json && isset($json->name) && $json->name) {
                                                                        $tsizes[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name, 'stock' => $json->stock];
                                                                    }
                                                                } elseif ($meta->type === 'shoe_size') {
                                                                    $json = json_decode($meta->value);
                                                                    if ($json && isset($json->name) && $json->name) {
                                                                        $footweer_size[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name, 'stock' => $json->stock];
                                                                    }
                                                                } elseif ($meta->type === 'waist_size') {
                                                                    $json = json_decode($meta->value);
                                                                    if ($json && isset($json->name) && $json->name) {
                                                                        $waist_size[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name, 'stock' => $json->stock];
                                                                    }
                                                                } elseif ($meta->type === 'child_size') {
                                                                    $json = json_decode($meta->value);
                                                                    if ($json && isset($json->name) && $json->name) {
                                                                        $child_size[] = ['id' => $meta->id, 'type' => $meta->type, 'name' => $json->name, 'stock' => $json->stock];
                                                                    }
                                                                }
                                                                ?>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                    @if ($custom_size && count($custom_size) > 0)
                                                        <?php $label = $product->product_attribute->where('attribute_name', 'custom_size')->first(); ?>
                                                        <div class="col-md-12 pl-0 mt-20 filters-color mb-3">
                                                            <label
                                                                for="select-color">{{ isset($label->label) ? $label->label : '' }}</label>
                                                            {{-- <label for="select-color">Select Size</label> --}}
                                                            <div class="color-selector  dd-cm-size select-product-cm-size">
                                                                <?php $flag__ = 0; ?>
                                                                @foreach ($custom_size as $key => $size)
                                                                    <div data-product="{{ $product->product_id }}"
                                                                        data-value="{{ $size['id'] }}"
                                                                        data-type="{{ $size['type'] }}"
                                                                        class="color product-cm-size entry my-custom-size-<?= $flag__ ?>"
                                                                        style="">&nbsp;</div> <span
                                                                        style="padding-right: 10px;">{{ ucfirst($size['name']) }}</span>
                                                                    <?php ++$flag__; ?>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                            @if ($tsizes && count($tsizes) > 0)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row filters-size mb-2">
                                                        <label for="select-color">Select Size</label>
                                                        <div class="color-selector size-selector">
                                                            @foreach ($tsizes as $key => $meta)
                                                                @if ($meta['stock'] <= 0)
                                                                    {{-- <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size disabled" title="Out of Stock" style="">N/A</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span> --}}
                                                                @else
                                                                    <div data-value="{{ $meta['id'] }}"
                                                                        data-type="{{ $meta['type'] }}"
                                                                        data-product="{{ $product->product_id }}"
                                                                        class="apprasel-size-attribute size-attribute-selector size entry {{ $key < 1 ? 'active' : '' }}"
                                                                        title="{{ ucwords($meta['name']) }}"
                                                                        style="">&nbsp;</div>
                                                                    <span
                                                                        class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($footweer_size && count($footweer_size) > 0)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row filters-size mb-2">
                                                        <label for="select-color">Select Size</label>
                                                        <div class="color-selector size-selector">
                                                            @foreach ($footweer_size as $key => $meta)
                                                                @if ($meta['stock'] <= 0)
                                                                    {{-- <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size disabled" title="Out of Stock" style="">N/A</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span> --}}
                                                                @else
                                                                    <div data-value="{{ $meta['id'] }}"
                                                                        data-type="{{ $meta['type'] }}"
                                                                        data-product="{{ $product->product_id }}"
                                                                        class="footwear-size-attibute size-attribute-selector size entry {{ $key < 1 ? 'active' : '' }}"
                                                                        title="{{ ucwords($meta['name']) }}"
                                                                        style="">&nbsp;</div>
                                                                    <span
                                                                        class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($waist_size && count($waist_size) > 0)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row filters-size mb-2">
                                                        <label for="select-color">Select Size</label>
                                                        <div class="color-selector size-selector">
                                                            @foreach ($waist_size as $key => $meta)
                                                                @if ($meta['stock'] <= 0)
                                                                    {{-- <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size disabled" title="Out of Stock" style="">N/A</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span> --}}
                                                                @else
                                                                    <div data-value="{{ $meta['id'] }}"
                                                                        data-type="{{ $meta['type'] }}"
                                                                        data-product="{{ $product->product_id }}"
                                                                        class="waist-size-attribute size-attribute-selector size entry {{ $key < 1 ? 'active' : '' }}"
                                                                        title="{{ ucwords($meta['name']) }}"
                                                                        style="">&nbsp;</div>
                                                                    <span
                                                                        class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($child_size && count($child_size) > 0)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row filters-size mb-2">
                                                        <label for="select-color">Select Size</label>
                                                        <div class="color-selector size-selector">
                                                            @foreach ($child_size as $key => $meta)
                                                                @if ($meta['stock'] <= 0)
                                                                    {{-- <div data-value="{{ $meta['id'] }}" data-type="{{ $meta['type'] }}" data-product="{{ $product->product_id }}" class="size disabled" title="Out of Stock" style="">N/A</div>
                                                        <span class="mr-2">{{ strtoupper($meta['name']) }}</span> --}}
                                                                @else
                                                                    <div data-value="{{ $meta['id'] }}"
                                                                        data-type="{{ $meta['type'] }}"
                                                                        data-product="{{ $product->product_id }}"
                                                                        class="waist-size-attribute size-attribute-selector size entry {{ $key < 1 ? 'active' : '' }}"
                                                                        title="{{ ucwords($meta['name']) }}"
                                                                        style="">&nbsp;</div>
                                                                    <span
                                                                        class="mr-2">{{ strtoupper($meta['name']) }}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif




                                            @if ($product->available < 1)
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <span class="not-available">Our of stock</span>
                                                    </div>
                                                </div>
                                            @endif



                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="single-variation-wrap">
                                                        <?php $qty = 1; ?>
                                                        @if (Session::has('addToCartProduct') && ($cartProducts = Session::get('addToCartProduct')))
                                                            @if (array_key_exists($product->product_id, $cartProducts))
                                                                <?php $qty = $cartProducts[$product->product_id]['quantity']; ?>
                                                            @endif
                                                        @endif
                                                        <div class="product-quantity">
                                                            <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                            <input id="itemQuantity" class="quantity dd-quantity input-lg"
                                                                step="1" min="1" max="9"
                                                                name="quantity" value="{{ $qty }}"
                                                                title="" type="number" />
                                                            <span data-value="-"
                                                                class="quantity-btn quantityMinus"></span>
                                                        </div>

                                                        @if ($product->status === 'active')
                                                            <button type="submit" style="background: red !important"
                                                                id="addToCartProductbtn"
                                                                data-value="{{ $product->product_id }}"
                                                                data-id="{{ $product->id }}"
                                                                class="btn btn-lg btn-dark addtocart-form-btn"><i
                                                                    class="fa fa-shopping-bag" aria-hidden="true"></i>Add
                                                                to cart</button>

                                                            <button type="button" style="background: green !important"
                                                                data-value="{{ $product->product_id }}"
                                                                data-id="{{ $product->id }}"
                                                                class="btn btn-lg btn-dark buynow-single"> Buy Now</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{--   @if ($product->shipping_charge)
                                <span class="shipping-charge"><span class="fa fa-inr"></span> {{ $product->shipping_charge }} (Shipping charge)</span>
                            @else
                                <span class="badge badge-primary shipping-charge">Free Shipping!</span>
                            @endif --}}

                                @if ($product->payment_option)
                                    <?php $opt = explode(',', $product->payment_option); ?>
                                    @if ($opt && in_array('cod', $opt))
                                        {{-- <span class="badge badge-primary shipping-charge">COD Available!</span> --}}
                                    @endif
                                @endif

                                {{ Form::open(['url' => route('availability'), 'id' => 'checkAvailability']) }}
                                <div class="check-availability">
                                    <label>Check delivery availability</label>
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

                                @if ($product->delivery_time)
                                    <div class="product-meta">
                                        <span>Estimated Delivery Time : {{ $product->delivery_time }}</span>
                                    </div>
                                @endif




                                <div class="product-meta">

                                    <span>Category :
                                        <span class="category" itemprop="category">
                                            <?php $parent = false; ?>
                                            @if ($product->product_category && count($product->product_category) > 0)
                                                @foreach ($product->product_category as $cat)
                                                    @if (!$cat->parent)
                                                        <a class="badge badge-success"
                                                            href="{{ route('product.category', [$cat->slug]) }}">
                                                            {{ ucwords($cat->name) }}
                                                        </a>
                                                        @foreach ($product->product_category as $child)
                                                            @if ($cat->id == $child->parent)
                                                                <a class="badge badge-success"
                                                                    href="{{ route('category.product', [$cat->slug, $child->slug]) }}">
                                                                    {{ ucwords($child->name) }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </span>
                                    </span>

                                </div>

                                <div class="product-share">
                                    <span>Share :</span>
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ current_url() }}"
                                                target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="http://twitter.com/share?url={{ current_url() }}" target="_blank">
                                            {{-- <i
                                                    class="fa fa-twitter"></i> --}}
                                                    <span class="icon-wrapper">
                                        <svg class="fa-twitter" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox=" 0 -5 30 30">
                                            <path d="M26.37,26l-8.795-12.822l0.015,0.012L25.52,4h-2.65l-6.46,7.48L11.28,4H4.33l8.211,11.971L12.54,15.97L3.88,26h2.65 l7.182-8.322L19.42,26H26.37z M10.23,6l12.34,18h-2.1L8.12,6H10.23z"></path>
                                        </svg>
                                    </span>
                                                </a></li>
                                        <li><a href="mailto:?subject=Check this {{ current_url() }}" target="_blank"><i
                                                    class="fa fa-envelope"></i></a></li>
                                        <li>
                                            <a href="whatsapp://send?text={{ current_url() }}"
                                                data-action="share/whatsapp/share">
                                                <i class="fa fa-whatsapp"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                @if (isset($product->buy_also) && $product->buy_also)
                                    <div class="product-frequently">
                                        <span><strong>Buy It Also:</strong></span>
                                        <?php $frequently = App\model\Product::where('id', $product->buy_also)->first(); ?>
                                        @if ($frequently)
                                            <div class="product-item">
                                                <div class="product-item-inner">
                                                    <div class="product-img-wrap">
                                                        <a
                                                            href="{{ url('/' . $category_slug . '/' . $frequently->slug . '/' . $frequently->product_id . '?source=product') }}">
                                                            <img class="lazyload"
                                                                data-src="{{ asset('public/' . product_file(thumb($frequently->feature_image, 150, 150))) }}"
                                                                alt="{{ $frequently->title }}">
                                                            @if ($frequently->discount)
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
                                                        <a
                                                            href="{{ url('/' . $category_slug . '/' . $frequently->slug . '/' . $frequently->product_id . '?source=product') }}">{{ $frequently->title }}</a>
                                                    </p>




                                                    <h5 class="item-price" style="display: block;">
                                                        <?php $price = $frequently->price; ?>
                                                        @if ($frequently->discount)
                                                            <del>
                                                                <span class="fa fa-inr"></span>
                                                                {{ $price }}
                                                            </del>
                                                            <?php $price = $price - ($price * $frequently->discount) / 100; ?>
                                                        @endif
                                                        @if ($frequently->tax)
                                                            <?php $price = $price + ($price * $frequently->discount) / 100; ?>
                                                        @endif
                                                        <span class="fa fa-inr"></span> {{ round($price) }}
                                                    </h5>
                                                    @if ($frequently->available > 0)
                                                        <a role="button" class="btn btn-lg btn-black"
                                                            id="addToCartProduct"
                                                            data-value="{{ $frequently->product_id }}"
                                                            data-id="{{ $frequently->id }}" data-mode="top"
                                                            data-tip="Add To Cart"><i class="fa fa-shopping-bag"></i>
                                                            Add</a>
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
                <!-- End Product -->

                <div id="otherDetails"></div>

                <section class="section-padding" style="display: none;">
                    <div class="container">
                        <div class="row promo-banner">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <a href="">
                                    <img class="lazyload"
                                        data-src="https://cdn.shopify.com/s/files/1/0310/3765/3128/collections/Men_s_Shirt.psd_1.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <a href="">
                                    <img class="lazyload"
                                        data-src="https://cdn.shopify.com/s/files/1/0310/3765/3128/collections/Women_Hand_Bags.psd_1.jpg" />
                                </a>
                            </div>
                        </div>
                    </div>
                </section>


                @if (Session::has('review_err') || Session::has('review_msg') || count($errors))
                    <script type="text/javascript">
                        $(document).ready(function($) {
                            $('html, body').animate({
                                scrollTop: $("#otherDetails").offset().top
                            }, 2000);
                        });
                    </script>
                @endif

                <!-- Product Content Tab -->
                <div class="product-tabs-wrapper container">

                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

                            <ul class="product-content-tabs nav nav-tabs" role="tablist">
                                @if ($product->content)
                                    <li class="nav-item">
                                        <a class="description {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? '' : 'active' }}"
                                            href="#tab_description" role="tab" data-toggle="tab">Description</a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="{{ !$product->content ? 'active' : '' }} review {{ Session::has('review_err') || Session::has('review_msg') || count($errors) ? 'active' : '' }}"
                                        href="#tab_reviews" role="tab" data-toggle="tab">Reviews
                                        (<span>{{ count($reviews) }}</span>)</a>
                                </li>
                                @if ($product->faq)
                                    <li class="nav-item">
                                        <a class="{{ !$product->faq ? 'active' : '' }} faq {{ Session::has('faq_err') || Session::has('faq_msg') ? 'active' : '' }}"
                                            href="#tab_faq" role="tab" data-toggle="tab">
                                            FAQ
                                        </a>
                                    </li>
                                @endif
                               
                            </ul>

                            <div class="product-content-Tabs_wraper tab-content">
                                @if ($product->content)
                                    <div id="tab_description" role="tabpanel"
                                        class="tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? '' : 'in active' }}">
                                        <div id="tab_description-coll" class="shop_description product-collapser">
                                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                                <?php echo ucfirst($product->content); ?>
                                            </div>
                                        </div>
                                        <!-- End Accordian Content -->
                                    </div>
                                @endif

                                <div id="tab_reviews" role="tabpanel"
                                    class="{{ !$product->content ? 'active show' : '' }} reviews tab-pane fade {{ Session::has('review_err') || count($errors) || Session::has('review_msg') ? 'in active show' : '' }}">
                                    <div id="tab_reviews-coll" class=" product-collapse">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <div class="row">
                                                <div class="review-form-wrapper col-md-6">
                                                    @auth
                                                    @else
                                                        <span>You have not logged in</span>
                                                    @endauth

                                                    @if (Session::has('review_err'))
                                                        <span class="text-danger">{{ Session::get('review_err') }}</span>
                                                    @endif
                                                    <form method="POST" class="comment-form"
                                                        action="{{ route('review.store') }}"
                                                        enctype="multipart/form-data">
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->product_id }}">
                                                        {{ csrf_field() }}


                                                        @if ($errors->has('star'))
                                                            <span class="text-danger">{{ $errors->first('star') }}</span>
                                                        @endif
                                                        <div class="form-field-wrapper">
                                                            <div class="stars">
                                                                <input class="star star-5" value="5" id="star-5"
                                                                    type="radio" name="star" />
                                                                <label class="star star-5" for="star-5"></label>
                                                                <input class="star star-4" value="4" id="star-4"
                                                                    type="radio" name="star" />
                                                                <label class="star star-4" for="star-4"></label>
                                                                <input class="star star-3" value="3" id="star-3"
                                                                    type="radio" name="star" />
                                                                <label class="star star-3" for="star-3"></label>
                                                                <input class="star star-2" value="2" id="star-2"
                                                                    type="radio" name="star" />
                                                                <label class="star star-2" for="star-2"></label>
                                                                <input class="star star-1" value="1" id="star-1"
                                                                    type="radio" name="star" />
                                                                <label class="star star-1" for="star-1"></label>
                                                            </div>
                                                        </div>

                                                        @if ($errors->has('review'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('review') }}</span>
                                                        @endif

                                                        <div class="form-field-wrapper">
                                                            <label>Your Review</label>
                                                            <textarea id="comment" class="form-full-width" name="review" cols="45" rows="8"
                                                                aria-required="true">{{ old('review') }}</textarea>
                                                        </div>

                                                        @if ($errors->has('name'))
                                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                        <div class="form-field-wrapper">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input id="name" class="input-md form-full-width"
                                                                name="name"
                                                                value="{{ Auth::check() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : '' }}"
                                                                required="" type="text">
                                                        </div>

                                                        @if ($errors->has('email'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                        <div class="form-field-wrapper">
                                                            <label>Email <span class="required">*</span></label>
                                                            <input id="email" class="input-md form-full-width"
                                                                name="email"
                                                                value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                                                size="30" aria-required="true" required=""
                                                                type="email">
                                                        </div>

                                                        <div class="form-field-wrapper">
                                                            <label>Upload Images</label>
                                                            <input class="input-md form-full-width" name="files[]"
                                                                multiple type="file">
                                                        </div>

                                                        <div class="form-field-wrapper">
                                                            <input name="submit" id="submit"
                                                                style="background: #e31f23 !important;"
                                                                class="submit btn btn-md btn-color" value="Submit"
                                                                type="submit">
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="comments col-md-6">
                                                    <h4 class="review-title">Customer Reviews</h4>
                                                    <!--<p class="review-blank">There are no reviews yet.</p>-->

                                                    @if ($reviews && count($reviews))
                                                        <ul class="commentlist">

                                                            @foreach ($reviews as $review)
                                                                <li id="comment-{{ $review->id }}"
                                                                    class="comment-{{ $review->id }}">
                                                                    <div class="comment-text">
                                                                        <div class="star-rating star-rating-{{ $review->rating }}"
                                                                            itemprop="reviewRating" itemscope=""
                                                                            itemtype="http://schema.org/Rating"
                                                                            title="Rated {{ $review->rating }} out of 5">
                                                                        </div>
                                                                        <p class="meta">
                                                                            <strong
                                                                                itemprop="author">{{ ucwords($review->name) }}</strong>
                                                                            &nbsp;&mdash;&nbsp;
                                                                            <time itemprop="datePublished"
                                                                                datetime="">{{ date('d/M/Y', strtotime($review->created_at)) }}</time>
                                                                        </p>
                                                                        <div class="description" itemprop="description">
                                                                            <p>{{ $review->review }}</p>
                                                                        </div>
                                                                        <?php $reviewgallery = explode(',', $review->file); ?>
                                                                        <div class="row">
                                                                            <?php if($reviewgallery): ?>
                                                                            <div id="lightgallery">
                                                                                <?php foreach($reviewgallery as $key):?>
                                                                                <?php if($key):?>
                                                                                <a
                                                                                    href="{{ asset('public/' . product_file(thumb($key, config('filesize.large.0'), config('filesize.large.1')))) }}">
                                                                                    <img
                                                                                        src="{{ asset('public/' . product_file(thumb($key, config('filesize.large.0'), config('filesize.large.1')))) }}" />
                                                                                </a>
                                                                                <?php endif;?>
                                                                                <?php  endforeach;?>
                                                                            </div>
                                                                            <?php endif; ?>
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
                               @if ($product->faq)
                                    <div id="tab_faq" role="tabpanel"
                                        class="tab-pane fade {{ Session::has('faq_err') || count($errors) || Session::has('faq_msg') ? 'in active' : '' }}">
                                        <div id="tab_faq-coll" class="shop_description product-collapser">
                                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                                <?php echo ucfirst($product->faq); ?>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Product Content Tab -->
                <?php $related_products = false;
                if ($category) {
                    $related_products = $category
                        ->product()
                        ->where('status', 'active')
                        ->where('product_id', '!=', $product->product_id)
                        ->where('available', '>', 0)
                        ->orderby('id', 'DESC')
                        ->paginate(10);
                }
                ?>
                <!-- Product Carousel -->
                <div class="container bg-white desktop-view-product">

                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <h2 class="page-title">Related Products
                                @if ($parentcategory && $category)
                                    <a href="{{ route('category.product', [$parentcategory->slug, $category->slug]) }}"
                                        class="btn-more pull-right">View More</a>
                                @endif
                            </h2>
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="row">

                            <div id="special-carousel" class="box-product related-products product-carousel clearfix"
                                data-items="4">
                                @if ($related_products)
                                    @foreach ($related_products as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
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
                                                            alt="{{ $row->title ?? 'Product image' }}" title="" class="img-responsive" />
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
                                                    <button role="button" style="background: #e31f23;color: #fff;"
                                                        id="addToCartProduct" data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}"><i class="icon-bag"></i> Add to
                                                        Cart</button>
                                                    {{--  <a class="view-product-a" href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}"><i class="icon-eye"></i></a> --}}
                                                    <button role="button" style="background: #383085;color: #fff;"
                                                        class="btn-wishlist" id="addToWishlist"
                                                        data-value="{{ $row->product_id }}"
                                                        data-id="{{ $row->id }}" data-mode="top"
                                                        data-tip="Add To Whishlist"><i
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
                                                                    <span class="mrp">MRP</span> <span
                                                                        class="price-old fa fa-inr">
                                                                        <del>{{ round($row->mrp) }}</del>
                                                                    </span>
                                                                @endif
                                                            </p>

                                                            <p class="rating dddd">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p>
                                                        </div>


                                                        <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: #e31f23; color: #fff;"
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
                <!-- End Product Carousel -->


                <!-- Related Product carousel -->
                <div class="mobile-veiw-product container">
                    <div class="page-title toggled">
                        <h3><span>Related Product</span></h3>
                    </div>
                    <div class="swiper-viewport">
                        <div class="swiper-container mySwiper">
                            <div class="swiper-wrapper">
                                @if ($related_products)
                                    @foreach ($related_products as $row)
                                        <?php $cat_slug = App\model\Category::where('id', $row->category_id)->value('slug'); ?>
                                        <?php $reviews = App\model\Review::where('product_id', $row->product_id)->get(); ?>
                                        <?php $rating = $reviews && count($reviews) ? $reviews->sum('rating') / count($reviews) : 0; ?>
                                        <div class="product-layout swiper-slide">
                                            <div class="product-thumb transition clearfix">
                                                <div class="image">
                                                    <a
                                                        href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">
                                                        <img src="{{ asset('public/' . product_file(thumb($row->feature_image, config('filesize.medium.0'), config('filesize.medium.1')))) }}"
                                                            alt="{{ $row->title ?? 'Product image' }}" title="" class="img-responsive" />
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
                                                                href="{{ route('product.view', [$cat_slug, $row->slug, $row->product_id]) }}">{{ get_excerpt($row->title, 5) }}</a>
                                                        </h4>
                                                        <div class="price-rating">
                                                            <p class="price"><span class="price-new fa fa-inr">
                                                                    {{ round($price) }}</span> <span
                                                                    class="mrp">MRP</span> <span
                                                                    class="price-old fa fa-inr">
                                                                    {{ round($row->mrp) }}</span></p>

                                                            {{-- <p class="rating">
                                                                {{ round($rat) }} / 5 <i class="fa fa-star"></i>
                                                            </p> --}}
                                                        </div>


                                                       {{--  <div class="product-footer-btn">
                                                            <button role="button"
                                                                style="background: #e31f23; color: #fff;"
                                                                id="addToCartProduct"
                                                                data-value="{{ $row->product_id }}"
                                                                data-id="{{ $row->id }}"><i class="icon-bag"></i>
                                                                Add to Cart</button>
                                                            <button role="button"
                                                                style="background: #383085; color: #fff;"
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


                <div class="container" style="display: none">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($product && $product->postmeta)
                                <div class="post-box">
                                    <?= $product->postmeta ?>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <script>
                    $('.mySwiper').swiper({
                        mode: 'horizontal',
                        slidesPerView: "auto",
                        paginationClickable: true,
                        nextButton: '.swiper-button-next',
                        prevButton: '.swiper-button-prev',
                        spaceBetween: 0,
                        autoplay: 4000,
                        autoplayDisableOnInteraction: true,
                        loop: true
                    });
                </script>
                <!-- Related Product carousel -->

            </section>
            <!-- End Page Content -->

            <?php $video = ''; ?>
            @if (isset($product->media[0]) && count($product->media) > 0)
                @foreach ($product->media as $media)
                    @if ($media->type === 'video')
                        <?php $video = $media->files; ?>
                    @endif
                @endforeach
            @endif

            @if ($video)
                <section class="video-overlay">
                    <div class="subs-popup">
                        <a href="javascript:void(0)" class="close-popup">
                            <span class="fa fa-close"></span>
                        </a>
                        <iframe height="300" style="width: 100%;" src="{{ $video . '?rel=0' }}" frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
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
