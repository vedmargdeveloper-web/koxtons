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
                             <span style="margin: 0 5px;">&raquo;</span>
                            <span>My Orders</span>
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

                	<div class="col-sm-12">
                        <article class="post-8">

                        @auth

                        <?php $orders = App\model\Order::where('user_id', Auth::id())->get(); ?>

                        @if( $orders )

                            <div class="card">
                                <div class="card-header">
                                    <h3>My Orders</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    @if( $errors->has('can_err') )
                                        <span class="text-warning">{{ $errors->first('can_err') }}</span>
                                    @endif
                                    @if( $errors->has('can_msg') )
                                        <span class="text-success">{{ $errors->first('can_msg') }}</span>
                                    @endif

                                    <table class="table table-bordered table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th>Order No</th>
                                                <th>Total Amount</th>
                                                <th>Payment Status</th>
                                                <th>Payment Type</th>
                                                <th>Order Status</th>
                                                <th>Order At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        @foreach( $orders as $order )

                                        <tr>
                                            <td>{{ $order->order_id }}</td>
                                            <td><span class="fa fa-inr"></span> {{ $order->total_amount }}</td>
                                            <td>
                                                @if($order->payment_status ==1)
                                                    {{'Paid'}}
                                                @else
                                                    {{ $order->payment_status ? $order->payment_status : 'Not Paid' }}
                                                @endif
                                                
                                            </td>
                                            <td>{{ strtoupper($order->payment_mode) }}</td>
                                            <td>
                                                {{ ucfirst($order->order_status) }}
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('d M, Y') }}
                                            </td>
                                            <td>
                                                @if( $order->order_status !== 'cancel' && $order->order_status !== 'delivered' )

                                                    <?php
                                                        $today = Carbon\Carbon::now();
                                                        $last = Carbon\Carbon::parse($order->created_at);
                                                        $diff = $today->diffInHours($last);
                                                    ?>
                                                    @if( $diff < 1 )
                                                        {{ Form::open(['url' => route('order.cancel')]) }}
                                                            <input type="hidden" name="id" value="{{ $order->id }}">
                                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                                            <button onclick="return confirm('Are you sure?');" class="btn btn-default">Cancel</button>
                                                        {{ Form::close() }}
                                                    @endif

                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>

                        @endif

                        @endauth

                        </article>
                    </div>

                </div>
        </div>
    </section>
</div>


@endsection