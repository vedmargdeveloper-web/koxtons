@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">            


    	<div class="col-md-12">
    		<div class="card">
                <div class="card-header">{{ __('Members') }}</div>

                <div class="card-body">

                    @if( $errors->has('can_err') )
                        <span class="text-warning">{{ $errors->first('can_err') }}</span>
                    @endif
                    @if( $errors->has('can_msg') )
                        <span class="text-success">{{ $errors->first('can_msg') }}</span>
                    @endif

                	<table class="table table-bordered table-hover datatables">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Total Amount</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Payment Status</th>
                                <th>Payment Type</th>
                                <th>Order Status</th>
                                <th>Order At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $orders = App\model\Order::where('user_id', Auth::id())->orderby('created_at', 'DESC')->get(); ?>

                            @if( $orders && count( $orders ) > 0 )

                                @foreach( $orders as $key => $order )
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><a href="{{ route('user.my.order.view', $order->id) }}">{{ $order->order_id }}</a></td>
                                        <td><span class="fas fa-rupee-sign"></span> {{ $order->total_amount }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->mobile }}</td>
                                        <td>{{ $order->payment_status ? $order->payment_status : 'Not Paid' }}</td>
                                        <td>{{ strtoupper($order->payment_mode) }}</td>
                                        <td>
                                            {{ ucfirst($order->order_status) }}
                                        </td>
                                        
                                        <td>
                                            {{ $order->created_at->format('d M, Y') }}
                                        </td>
                                        <td>
                                            @if( $order->order_status !== 'cancel' && $order->order_status !== 'shipped' && $order->order_status !== 'delivered' )
                                            {{ Form::open(['url' => route('order.cancel')]) }}
                                                <input type="hidden" name="id" value="{{ $order->id }}">
                                                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                                <button onclick="return confirm('Are you sure?');" class="btn btn-default">Cancel</button>
                                            {{ Form::close() }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            @endif

                        </tbody>
                    </table>
              	</div>
            </div>
    	</div>
        

    </div>

@endsection