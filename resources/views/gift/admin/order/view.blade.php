@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<a href="{{ route('orders') }}">Go Back</a>
	</div>
	<div class="card-body pt-4">
		

		@if( $order )
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-5">
				<h5>Order Details</h5>
				<table class="table table-bordered mb-2">
					<tbody>
						<tr>
							<th>Order No.</th>
							<td>{{ $order->order_id }}</td>
						</tr>
						<tr>
							<th>Amount</th>
							<td><span class="fas fa-rupee-sign"></span> {{ $order->total_amount }}</td>
						</tr>
						<tr style="display: none;">
							<th>Membership Amount</th>
							<td><span class="fas fa-rupee-sign"></span> {{ $order->membership_amount }}</td>
						</tr>
						<tr>
							<th>Remark</th>
							<td>{{ $order->remark }}</td>
						</tr>
						<tr>
							<th>Ordered At</th>
							<td>{{ $order->created_at->format('d M, Y H:i:s') }}</td>
						</tr>
					</tbody>
				</table>

				@if( $order->order_products && count( $order->order_products ) > 0 )
					<h5>Product Details</h5>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Product ID</th>
								<th>Product Title</th>
								<th>Amount</th>
								<th>Discount</th>
								<th>Quantity</th>
								<th>Image</th>
								<th>Color</th>
								<th>Size</th>
							</tr>
						</thead>

						<tbody>
							@foreach( $order->order_products as $key => $product )
								<?php $variation = $product->variations ? json_decode($product->variations) : false; ?>
								<?php $v_title = $variation->variation_name ? $variation->title . ' - ' . $variation->variation_name : $variation->title; ?>
								<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $product->product_no }}</td>
									<td><a href="{{ $variation->url }}">{{ $v_title }}</a></td>
									<td><span class="fas fa-rupee-sign"></span> {{ $variation ? $variation->price : '' }}</td>
									<td>{{ $variation ? $variation->discount.'%' : '' }}</td>
									<td>{{ $variation ? $variation->quantity : '' }}</td>
									<td><img width="60" src="{{ $variation ? $variation->feature_image : '' }}"></td>
									<td>{{ $variation ? ucfirst($variation->color) : '' }}</td>
									<td>

										<?php $meta = App\model\ProductAttributeMeta::where('id', $variation->size)->first(); ?>

										@if( $meta )
											{{ ucfirst($meta->name) }}
										@endif
										

										
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				@endif
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-5">
				<h5>Payment Details</h5>
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>Total Amount</th>
							<td><span class="fas fa-rupee-sign"></span> {{ $order->total_amount }}</td>
						</tr>
						<tr>
							<th>Payment Mode</th>
							<td>{{ strtoupper($order->payment_mode) }}</td>
						</tr>
						<tr>
							<th>Payment Status</th>
							<td>
								@if($order->payment_status==1)
								Sucess
								@endif
								{{-- {{ ucfirst($order->payment_status) }} --}}
							</td>
						</tr>
						<tr>
							<th>TXN ID</th>
							<td>{{ $order->payment->razorpay_order_id ?? '' }}</td>
						</tr>


						<tr>
							<th>Coupon</th>
							<td>{{ ucfirst($order->c_coupon) }}</td>
						</tr>						
						<tr>
							<th>Order Status</th>
							<td>{{ ucfirst($order->order_status) }}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h5>Customer Details</h5>
				@if( $order->order_customer && count( $order->order_customer ) > 0 )

					<table class="table table-bordered">
						<tbody>
							<tr>
								<th>Customer Name</th>
								<td>{{ ucfirst($order->order_customer[0]->first_name .' '. $order->order_customer[0]->last_name) }}</td>
							</tr>
							<tr>
								<th>Email ID</th>
								<td>{{ $order->order_customer[0]->email }}</td>
							</tr>
							<tr>
								<th>Mobile no</th>
								<td>{{ $order->order_customer[0]->mobile }}</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>{{ implode(', ', json_decode($order->order_customer[0]->address) ) }}</td>
							</tr>
							<tr>
								<th>City</th>
								<td>{{ $order->order_customer[0]->city }}</td>
							</tr>
							<tr>
								<th>State</th>
								<td>{{ $order->order_customer[0]->state }}</td>
							</tr>
							<tr>
								<th>Country</th>
								<td>{{ $order->order_customer[0]->country }}</td>
							</tr>
							<tr>
								<th>Pincode</th>
								<td>{{ $order->order_customer[0]->pincode }}</td>
							</tr>
							
						</tbody>

					</table>

				@endif
			</div>
			
		@else

			<p>No details found!</p>

		@endif

	</div>
</div>

@endsection