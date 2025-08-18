@extends('seller.app')

@section('title', $title)

@section('content')


	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12">
			<div class="breadcrumb">
	            <h1>{{ $title }}</h1>
	        </div>

			<a href="{{ route('seller.orders') }}">Go back</a>
	        <div class="separator-breadcrumb border-top"></div>
	    </div>
	</div>

    <div class="row mb-2">
        <div class="col-md-12 col-lg-12 col-xs-12">
			
			@if( $order_product )

			<?php $order = App\model\Order::find($order_product->order_id); ?>

			<?php $variation = $order_product->variations ? json_decode($order_product->variations) : false; ?>

			<div class="section mb-3">
				<h3>Product Details</h3>
				<table class="table table-bordered table-hover">
					<tbody>
						<tr>
							<th>Product Title</th>
							<td>
								<a href="{{ url($variation->url) }}">
									{{ $variation ? $variation->title : '' }}
								</a>
							</td>
						</tr>
						<tr>
							<th>Product Price</th>
							<td><span class="fas fa-rupee-sign"></span> {{ $variation ? round($variation->price,0) : '' }}</td>
						</tr>
						<tr>
							<th>Product Discount</th>
							<td>{{ $variation ? $variation->discount : '' }}</td>
						</tr>
						<tr>
							<th>Quantity</th>
							<td>{{ $variation ? $variation->quantity : '' }}</td>
						</tr>
						<tr>
							<th>Color</th>
							<td>{{ $variation ? $variation->color : '' }}</td>
						</tr>
						<tr>
							<th>Image</th>
							<td>
								<a href="{{ $variation ? url($variation->url) : '' }}">
									<img src="{{ $variation ? $variation->feature_image : '' }}" alt="{{ $variation ? $variation->title : 'Variation Image' }}">
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="section mb-3">
				<h3>Order Details</h3>
				@if( $order )
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<th>Order No.</th>
								<td>{{ $order->order_id }}</td>
							</tr>
							<tr>
								<th>Amount</th>
								<td><span class="fas fa-rupee-sign"></span> {{ round($order->total_amount,0) }}</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>{{ $order->address }}</td>
							</tr>
							<tr>
								<th>Mobile</th>
								<td>{{ $order->mobile }}</td>
							</tr>
							<tr>
								<th>Payment Mode</th>
								<td>{{ strtoupper($order->payment_mode) }}</td>
							</tr>
							<tr>
								<th>Payment Status</th>
								<td>{{ ucfirst($order->payment_status) }}</td>
							</tr>
							<tr>
								<th>Order Status</th>
								<td>{{ ucfirst($order->order_status) }}</td>
							</tr>
							<tr>
								<th>Remark</th>
								<td>{{ $order->remark }}</td>
							</tr>
						</tbody>
					</table>
				@endif
			</div>


			<div class="section mb-3">
				<h3>Customer Details</h3>
				<?php $customer = $order ? App\model\OrderCustomer::where('order_id', $order->id)->first() : false; ?>
				@if( $customer )
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<th>Name</th>
								<td>{{ ucwords($customer->first_name.' '.$customer->last_name) }}</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>{{ $customer->email }}</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>{{ implode(', ', json_decode($customer->address)) }}</td>
							</tr>
							<tr>
								<th>Mobile</th>
								<td>{{ $customer->mobile }}</td>
							</tr>
							<tr>
								<th>City</th>
								<td>{{ $customer->city }}</td>
							</tr>
							<tr>
								<th>State</th>
								<td>{{ $customer->state }}</td>
							</tr>
							<tr>
								<th>Country</th>
								<td>{{ $customer->country }}</td>
							</tr>
							<tr>
								<th>Pincode</th>
								<td>{{ $customer->pincode }}</td>
							</tr>
						</tbody>
					</table>
				@endif
			</div>


			@endif			

        </div>
    </div>


@endsection