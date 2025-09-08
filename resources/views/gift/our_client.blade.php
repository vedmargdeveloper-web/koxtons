@extends( _app() )

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-10">
                    <nav class="breadcrumb-link"  style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                        <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                        @if( $page )
                         <span style="margin: 0 5px;">&raquo;</span>
                            <span>{{ ucwords($page->title) }}</span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Bread Crumb -->
<?php $client = App\model\OurClient::all(); ?>
    <!-- Page Content -->
    <section class="content-page client-section our-client-single-page  bg-white">
        <div class="container">
            <div class="row">
                @if($client)
                    <div class="col-md-12">
                        <div class="title text-center mb-30">
                            <h1 class="mb-5">{{ $title }}</h1>
                        </div>
                    </div>
                    @foreach($client as $key)
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="product-block blog-block transition">
                                <div class="blog-info">
                                    <div class="image">
                                        <div class="swiper-slide text-center Main-banner1">
                                            <img src="{{ asset( 'public/' . public_file( $key->image ) ) }}"  alt="{{ $key->image_alt ?? 'Client Logo' }}" class="img-responsive" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
        </div>
    </section>

</div>

@endsection