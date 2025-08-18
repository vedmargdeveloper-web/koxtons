@extends( _app() )

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">

    <!-- Page Content -->
    <section class="content-page return return-page">
        <div class="container">
            <div class="row">

                <!-- Product Content -->
                <div class="col-12 text-center">

                    <div class="form-horizontal">

                        @if( $complain )
                        
                           <p>Your complain successfully sent!</p>
                           <p><strong>Complain SRN:</strong> {{ $complain->complain_no }}</p>

                       @endif

                    </div>

                </div>

            </div>
        </div>
    </section>

</div>

@endsection