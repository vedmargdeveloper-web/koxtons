@extends( _app() )

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

    <!-- Page Content -->
    <section class="content-page">
        <div class="container">
            <div class="row">

                <!-- Product Content -->
                <div class="col-12">
                    @if( $page )

                    <div class="title text-center mb-5">
                        <h1>{{ $page->title }}</h1>
                    </div>

                    <div class="content">
                        <?php echo  $page->content; ?>
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