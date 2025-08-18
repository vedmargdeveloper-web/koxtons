@extends( _app() )

@section('content')

@section('og-url', current_url())
@section('og-type', 'page')

@if( $page->metatitle !==NULL)
    @section('og-title', $page->metatitle ?? '')
@else
    @section('og-title', $title)
@endif

@section('og-keywords', $page->metakey ?? '')
@section('og-content', $page->metadescription ?? '')
<span style="display:none" class="dddd"><?=var_dump($page->metatitle)?></span>
<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-10">
                <nav class="breadcrumb-link" style=" margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px; margin-left:15px;">
                    <a href="{{ url('/') }}"  style="color: #007bff; text-decoration: none; margin-right: 5px;">Home</a>
                    @if($page)
                        &nbsp;&raquo;&nbsp;
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

                    <div class="content custom-padding-content">
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