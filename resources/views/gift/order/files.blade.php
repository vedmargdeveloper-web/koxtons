@extends( _app() )

@section('content')

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Page Content -->
    <section class="content-page">
        <div class="container mb-80">
            <div class="row">
                <div class="col-sm-12">
                    <article class="post-8 text-center">
                        <h3>Upload Files</h3>

                        <p>Upload files for customization in your order.</p>
                        <span>Files must be jpg, jpeg, png, gif only. Each file size must be less than 1MB.</span>
                        <span>You can upload upto 20 files!</span>
                        {{ Form::open(['url' => route('product.order.files.upload'), 'files' => true]) }}

                            <input type="file" name="files[]" multiple>
                            <input type="hidden" name="orderno" value="{{ $order->order_id }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button class="btn btn-primary">Upload</button>

                        {{ Form::close() }}
                        @if( $errors->has('files.*') )
                            <span class="text-warning">{{ $errors->first('files.*') }}</span>
                        @endif

                        @if( Session::has('file_status') )
                            <span class="text-warning">{{ Session::get('file_status') }}</span>
                        @endif
                        @if( Session::has('file_success') )
                            <span class="text-success">{{ Session::get('file_success') }}</span>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection