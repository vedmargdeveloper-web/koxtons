@extends( _app() )
@section('og-title', 'Koxtonsmart: Checkout Our Latest Blogs')

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
   <section>
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

    <!-- Page Content -->
    <section class="content-page bg-white">
        <div class="container">
            <div class="row">
           <div class="blog-buttons mb-4 text-center">
                <a href="{{ url('blogs') }}" class="btn {{ $filter == 'latest' ? 'btn-primary' : 'btn-secondary' }} mx-2">Latest Articles</a>
                <a href="{{ url('blogs?filter=all') }}" class="btn {{ $filter == 'all' ? 'btn-primary' : 'btn-secondary' }} mx-2">All Blog Posts</a>
                <a href="{{ url('blogs?filter=popular') }}" class="btn {{ $filter == 'popular' ? 'btn-primary' : 'btn-secondary' }} mx-2">Popular Articles</a>
            </div>


                <div class="col-md-12">
                    @if( $blogs )

                    <div class="title text-center mb-5">
                        <h2></h2>
                    </div>

                    <?php $c = 0; ?>

                    <div class="content blog-section">
                         <div class="row">
                        @foreach( $blogs as $key => $row )
                       
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                <div class="col-post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="{{ route('view.blog', $row->slug) }}">
                                                <figure>
                                                    <div class="img-fluid">
                                                        @if($row->feature_image)
                                                        <img src="{{ asset( 'public/' . post_file( thumb( $row->feature_image, 260, 200 ) ) ) }}" alt="{{ $row->title }}">
                                                        @else
                                                            <img src="https://via.placeholder.com/200x200?text={{ $row->title }}" alt="{{ $row->title }}">
                                                        @endif
                                                    </div>
                                                </figure>
                                            </a>
                                        </div>
                                        <div class="col-md-8">
                                            <a href="{{ route('view.blog', $row->slug) }}">
                                                <div class="post-heading">
                                                    <h3>{{ get_excerpt($row->title,3) }}</h3>
                                                    <p>{!! get_excerpt($row->content,20) !!}  <span class="text-right"> <i class="fa fa-clock-o"></i> {{date('d M, Y',strtotime($row->created_at))}}</span></p>
                                                   
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        @endforeach

                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
                                {{ $blogs->links() }}
                            </div>
                        </div>

                    </div>

                    @else
                        <p>Page not found!</p>
                    @endif
                </div>

            </div>
        </div>
    </section>

</div>

@endsection