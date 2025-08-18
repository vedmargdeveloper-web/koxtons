@extends('seller.app')

@section('title', $title)

@section('content')


	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12">
			<div class="breadcrumb">
	            <h1>{{ $title }}</h1>
	        </div>

	        <div class="separator-breadcrumb border-top"></div>
	    </div>
	</div>

    <div class="row mb-2">
        <div class="col-md-12 col-lg-12 col-xs-12">

        	<?php $products = App\model\Product::with('order_product')->where('user_id', Auth::id())->orderby('id', 'DESC')->get(); ?>

			<table class="table table-bordered table-hover datatables">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Product ID</th>
						<th>Title</th>
						<th>Image</th>
						<th>Amount</th>
						<th>Discount</th>
						<th>Quantity</th>
						<th>Created at</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if( $products && count( $products ) > 0 )
						@foreach( $products as $key => $row )
							@if( $row->order_product && count( $row->order_product ) > 0 )
								@foreach( $row->order_product as $order )
									<?php $var = $order->variations ? json_decode($order->variations) : false; ?>
									@if( $var )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											{{ $order->product_no }}
										</td>
										<td><a href="{{ url($var->url) }}">{{ $var->title }}</a></td>
										<td>
											<a href="{{ url($var->url) }}">
												<img width="50" src="{{ $var->feature_image }}">
											</a>
										</td>
										<td><span class="fas fa-rupee-sign"></span> {{ round($var->price,0) }}</td>
										<td>{{ $var->discount ? $var->discount.'%' : '' }}</td>
										<td>{{ $var->quantity }}</td>
										<td>{{ $row->created_at }}</td>
										<td>
											<a href="{{ route('seller.order.view', $order->id) }}">View</a>
										</td>
									</tr>
									@endif
								@endforeach
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
			

        </div>
    </div>


@endsection