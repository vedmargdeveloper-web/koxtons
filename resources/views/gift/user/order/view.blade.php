@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
        <span><strong>Order Status:</strong> {{ $order ? $order->order_status : '' }}</span>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">


        <div class="col-md-12 mb-4">
            <a title="Go Back" href="{{ route('user.my.orders') }}"><span class="fas fa-angle-left"></span></a>
            <div class="card">
                <div class="card-header">{{ __('Order Details') }}</div>
                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Total Amount</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Payment Status</th>
                                <th>Payment Type</th>
                                <th>Order Status</th>
                                
                                <th>Order At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if( $order )
                                <tr>
                                    <td>{{ $order->order_id }}</td>
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
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       

    	<div class="col-md-12">
    		<div class="card">
                <div class="card-header">{{ __('Products') }}</div>
                <div class="card-body">

                	<table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Product name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Quantity</th>
                                <th>Others</th>
                                <th>Image</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if( $order->order_products && count( $order->order_products ) > 0 )

                                @foreach( $order->order_products as $key => $row )

                                <?php $variation = json_decode($row->variations); ?>

                                @if( $variation )

                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><a target="_blank" href="{{ $variation->url }}">{{ $variation->title }}</a></td>
                                        <td><span class="fas fa-rupee-sign"></span>{{ round($variation->original_price,0) }}</td>
                                        <td>{{ $variation->discount ? $variation->discount.'%' : '' }}</td>

                                        <td>{{ $variation->quantity }}</td>
                                        <td>
                                            @if( $variation->color )
                                                <p><strong>Color:</strong> {{ $variation->color }}</p>
                                            @endif
                                            @if( $variation->size )
                                                <?php $attr = App\model\ProductAttributeMeta::where('id', $variation->size)->first(); ?>
                                                <p><strong>Size:</strong> {{ $attr ? strtoupper($attr->name) : '' }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{ $variation->url }}">
                                                <img style="max-width: 80px;" src="{{ $variation->feature_image }}">
                                            </a>
                                        </td>
                                    </tr>
                                
                                @endif

                                @endforeach

                            @endif

                        </tbody>
                    </table>
              	</div>
            </div>
    	</div>
        

    </div>

@endsection