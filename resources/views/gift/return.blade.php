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
                        
                        {{ Form::open(['url' => route('order.search'), 'id' => 'orderSearchForm']) }}
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>Search your order and help us to know what made you to return/refund order.</p>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <input type="text" class="form-control" name="order_no" placeholder="Order No.">
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No.">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>
        </div>
    </section>

</div>

@endsection