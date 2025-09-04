@extends( _app() )




@if( $blog )
<?php $image_url = asset( 'public/' . post_file( thumb( $blog->feature_image, 260, 200 ) ) ); ?>

@section('og-url', current_url())
@section('og-type', 'Blog')
@section('og-title', $blog ? ($blog->metatitle ?? $blog->title) : '')
@section('og-content', $blog ? $blog->metadescription : '')
@section('og-image-url', $image_url)
@endif
@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-10">
                <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                    <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                    @if(!empty($title))
                        <span style="margin: 0 5px;">&raquo;</span>
                        <span>{{ ucwords($title) }}</span>
                    @endif
                </nav>
            </div>
            </div>
        </div>
    </section>
    <!-- Bread Crumb -->

@if( Session::has('comment_err') || Session::has('comment_msg') || count($errors) > 0 )
    <script type="text/javascript">
        /*$('html, body').animate({
            scrollTop: $("#comments").offset().top
        }, 2000);*/
        
        $(window).scrollTop($('#comments').offset().top);

        
    </script>
@endif

    <!-- Page Content -->
    <section class="content-page">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if( $blog )

                    <div class="row">

                        <div class="col-md-9 blog-single style-1">
                            <div class="blog-box">
                                <div class="blog-img-wrap">
                                    @if($blog->feature_image)
                                        <img src="{{ asset( 'public/' . post_file( $blog->feature_image ) ) }}" alt="{{ $blog->title }}" />
                                    @else
                                        <img src="https://via.placeholder.com/200x200?text={{ $blog->title }}" alt="">
                                    @endif
                                </div>
                                <div class="blog-box-content">
                                    <div class="blog-box-content-inner">
                                        <h1 class="blog-title">{{ $blog->title }}</h1>
                                        <p class="info">Posted on: <span>{{ date('d M, Y', strtotime($blog->created_at)) }}</span>
                                           @if (!empty($blog->category))
                                                <p class="info">Category: <span>{{ $blog->category->name ?? '' }}</span></p>
                                            @endif

                                        {{-- <p class="info">In: <span>{{ $blog->category->name ?? ''}}</span> --}}
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
                                                
                                                <li><a href="mailto:?subject=Check this {{ current_url() }}" target="_blank"><i class="fa fa-envelope"></i></a></li>
                                            </ul>
                                        </div>
                                        </p>
                                        <div class="blog-description-content">
                                            <?php echo $blog->content; ?>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div id="comments" class="review-form-wrapper col-md-8 pt-5" style="display: none;">
                                    @auth
                                    @else
                                        <span>You have not logged in</span>
                                    @endauth
                                    
                                    @if( Session::has('comment_err') )
                                        <span class="text-danger">{{ Session::get('comment_err') }}</span>
                                    @endif
                                    <form method="POST" class="comment-form" action="{{ route('comment.store') }}">
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        {{ csrf_field() }}
                                        @if( $errors->has('star') )
                                            <span class="text-danger">{{ $errors->first('star') }}</span>
                                        @endif
                                        <?php $star = old('star') ? old('star') : 5; ?>
                                        <div class="form-field-wrapper">
                                            <div class="stars">
                                                <input {{ $star == 5 ? 'checked' : '' }} class="star star-5" value="5" id="star-5" type="radio" name="star"/>
                                                <label class="star star-5" for="star-5"></label>
                                                <input {{ $star == 4 ? 'checked' : '' }} class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                                <label class="star star-4" for="star-4"></label>
                                                <input {{ $star == 3 ? 'checked' : '' }} class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                                <label class="star star-3" for="star-3"></label>
                                                <input {{ $star == 2 ? 'checked' : '' }} class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                                <label class="star star-2" for="star-2"></label>
                                                <input {{ $star == 1 ? 'checked' : '' }} class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                                <label class="star star-1" for="star-1"></label>
                                            </div>
                                        </div>

                                        
                                        <div class="form-field-wrapper">
                                            <label>Your Review <span class="required">*</span></label>
                                            <textarea id="comment" class="form-full-width" name="message" cols="45" rows="8" aria-required="true" >{{ old('message') }}</textarea>
                                            @if( $errors->has('message') )
                                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                            @endif
                                        </div>
                                        @auth
                                        @else
                                            <div class="form-field-wrapper">
                                                <label>Name <span class="required">*</span></label>
                                                <input id="author" class="input-md form-full-width" name="name" value="{{ old('name') }}" size="30" aria-required="true" required="" type="text">
                                                @if( $errors->has('name') )
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-field-wrapper">
                                                <label>Email <span class="required">*</span></label>
                                                <input id="email" class="input-md form-full-width"  name="email" value="{{ old('email') }}" size="30" aria-required="true" required="" type="email">
                                                @if( $errors->has('email') )
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        @endauth
                                        <div class="form-field-wrapper">
                                            <input name="submit" id="submit" class="submit btn btn-md btn-color" value="Submit" type="submit">
                                        </div>
                                    </form>
                                </div>


                                <?php $reviews = App\model\Review::where('blog_id', $blog->id)->get(); ?>


                                <div class="comments col-md-8" style="display: none;">
                                    <h6 class="review-title">Comments</h6>
                                    <!--<p class="review-blank">There are no reviews yet.</p>-->
                                    
                                    @if( $reviews && count($reviews) > 0 )
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

                                    <p>No comment yet.</p>

                                    @endif
                                        
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="sidebar-container col-md-3">
                            <?php $blogs = App\model\Post::where(['type' => 'post', 'status' => 'publish'])->orderby('id', 'DESC')->limit(4)->get(); ?>
                            <!-- Recent Posts -->
                            <div class="widget-sidebar widget-product">
                                <h2 class="widget-title">Recent Posts</h2>
                                @if( $blogs )
                                <ul class="widget-content">
                                    @foreach( $blogs as $row )
                                    <!--Item-->
                                    <li>
                                        <a class="product-img" href="#">
                                            @if($row->feature_image)
                                                <img src="{{ asset( 'public/' . post_file( thumb( $row->feature_image, 260, 200 ) ) ) }}" alt="{{ $row->title }}"/>
                                            @else
                                                <img src="https://via.placeholder.com/260x200?text={{ $row->title }}" alt="">
                                            @endif
                                        </a>
                                        <div class="product-content">
                                            <a class="product-link" href="{{ route('view.blog', $row->slug) }}">{{ $row->title }}</a>
                                            <span class="date-description">{{ date('d M, Y', strtotime($row->created_at)) }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>

                        </div>
                        <!-- End Sidebar -->

                    </div>
                    

                    @else
                        <p>Blog not found!</p>
                    @endif
                </div>

            </div>
        </div>
    </section>

</div>

@endsection