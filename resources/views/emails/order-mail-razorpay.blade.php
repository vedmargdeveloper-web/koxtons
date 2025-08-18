<!DOCTYPE html>
<html>
<head>
	<title>Order placed successfully</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<style type="text/css">
		html,body {
			padding: 0;
			margin: 0;
		}
		.container {
			padding: 1em;
		}
		table.table {
			font-family: verdana,arial,sans-serif;
			font-size:11px;
			color:#333333;
			border-width: 1px;
			border-color: #ccc;
			border-collapse: collapse;
			text-align: left;
			width: 100%;
		}
		table.table th {
			border-width: 1px;
			padding: 8px 10px;
			border-style: solid;
			border-color: #ccc;
			background-color: #e31f23;
			font-size: 17px;
			color: #fff;
		}
		.red-color{
			background-color: #e31f23;
			color: #fff !important;
		}
		table.table td {
			border-width: 1px;
			padding: 8px 10px;
			border-style: solid;
			border-color: #ccc;
			background-color: #ffffff;
			font-size: 16px;
		}
		table.table thead th{
			padding: 15px 10px;			
		}
		table.table tbody {

		}
		table.table tr {

		}
		img.img-thumbnail {
			padding: 5px;
			border-radius: 5px;
			border: 1px solid #ccc;
			width: 60%;
		}
		.thankyou {
			background: #383085;
			padding: 20px;
			text-align: center;
		}
		.thankyou h3 {
			color: #fff;
			margin: 0;
			font-size: 1.5em;
		}
		.billing {
			background: #f3fbfb;
			padding: 1em 1.5em;
			border: 4px solid #ccc;
		}
		address {
			line-height: 28px;
		}
	</style>
</head>
<body>

	<div class="container">

		<p>Hi {{ $request->first_name }},</p>
		<div class="thankyou">
			<h3>Thank you for your order {{ $request->order_id }}</h3>
		</div>
		<p>Your order has been placed successfully.</p>
		<p>Here are the following details of your order:</p>
		<h3>Product details:</h3>

		<?php $total = 0; ?>

		    @if( $cart )

		    	<?php $shipping_charge = 0; ?>

				<table class="table">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Image</th>
							<th>Name</th>
							<th>Quantity</th>
							<th>Color, Size</th>
							<th>Price</th>
							<th>Discount</th>
							<th>Sub total</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $cart as $key => $row )
						
						<?php $variation = json_decode($row->variations); ?>
						<?php $shipping_charge += $variation ? $variation->shipping_charge : 0; ?>
						<?php $price = $variation->price;
							if( isset($variation->discount) && $variation->discount )
								$price = $variation->price - ( $variation->price * $variation->discount ) / 100;
							if( $variation->tax )
								$price = $price + ( $price * $variation->tax ) / 100;

							$price = round( $price );
						?>
						<tr>
							<td>{{ ++$key.'.' }}</td>
							<td><img class="img-thumbnail" src="{{ $variation->feature_image }}"></td>
							<td>{{ $variation->title }}</td>
							<td>{{ $variation->quantity }}</td>
							<td>
								@if( isset( $variation->color ) && $variation->color )
									<p><strong>color:</strong>{{ ucfirst($variation->color) }}</p>
								@endif

								@if( isset( $variation->size ) && $variation->size )
									<?php $meta = App\model\ProductAttributeMeta::where('id', $variation->size)->first(); ?>
									@if( $meta )
										<p><strong>Size:</strong> {{ $variation->size }} {{ ucfirst($meta->name) }}</p>
									@endif
								@endif
								@if( isset( $variation->c_size ) && $variation->c_size )
									<?php $meta = App\model\ProductAttributeMeta::where('id', $variation->c_size)->first(); ?>
									@if( $meta )
										<p><strong>Size:</strong> {{ ucfirst($meta->name) }}</p>
									@endif
								@endif
							</td>
							<td>&#8377; {{ $variation->price }} {{ $variation->tax ? '+ '.$variation->tax.'% GST' : '' }}</td>
							<td>
								@if( $variation->discount )
									{{ $variation->discount.'%' }}
								@endif
							</td>
							<td>&#8377; {{ $variation->quantity * $price }}</td>
							
							<?php $total += $variation->quantity * $price; ?>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="5" class="red-color"><strong>Sub Total:</strong></th>
							<td colspan="3"> &#8377; {{ $total }}</td>
						</tr>
						@if($request->c_coupon)
							<tr>
								<td colspan="5" class="red-color"><strong>Coupon:</strong></td>
								<td colspan="3"> {{ $request->c_coupon }}</td>
							</tr>
						@endif
						
						@if( isset( $coupon ) && $coupon )
							@if( $coupon->start && $coupon->end )
				                <?php $start = new \DateTime( date('Y-m-d H:i:s', strtotime($coupon->start)) );
						                $end = new \DateTime( date('Y-m-d H:i:s', strtotime($coupon->end)) );
						                $current = new \DateTime( date('Y-m-d H:i:s') );
						                $off = 0; ?>
						        @if( $start < $current && $end > $current )
						        	<?php $discount = 0; ?>

						        	@if( $coupon->discount_type === 'percent' )
										<tr>
											<td colspan="4">Offer discount</td>
											<td>{{ $request->coupon }}</td>
											<td colspan="3"><?php echo $discount = isset($coupon->discount) ? $coupon->discount : 0  ?>%</td>
											@if( $discount )
												<td colspan="3"> - &#8377;{{ $off = ( $total * $coupon->discount ) / 100 }}</td>
											@endif
										</tr>
										@if( $request->use_coupon && $memCoupon )
											<?php 
												$dis = $subtotal * 10 / 100;
												$subtotal = $subtotal - $dis; ?>
											<tr>
												<td colspan="5"><strong>Member Discount</strong></td>
												<td colspan="3"> - &#8377; {{ $dis }}</td>
											</tr>
										@endif
										<tr>
											<td colspan="5">Sub Total Amount</td>
											<td>&#8377; {{ $subtotal = $total - $off }}</td>
										</tr>
										<tr>
											<td colspan="5" class="red-color"><strong>Shipping charge</strong></td>
											<td colspan="3"> + &#8377; {{ $shipping_charge }}</td>
										</tr>
										<tr>
											<th colspan="5">Total Amount</th>
											<td>&#8377; {{ $subtotal + $shipping_charge }}</td>
										</tr>
										
						        	@else
						        		@if( $coupon )
							        		<tr>
												<td colspan="4">Offer discount</td>
												<td>{{ $request->coupon }}</td>
												<td colspan="3">  - &#8377; {{ $discount = $coupon->discount }}</td>
											</tr>
										@endif
										@if( $request->use_coupon && $memCoupon )
											<?php 
												$dis = $subtotal * 10 / 100;
												$subtotal = $subtotal - $dis; ?>
											<tr>
												<td colspan="5"><strong>Member Discount</strong></td>
												<td colspan="3"> - &#8377; {{ $dis }}</td>
											</tr>
										@endif
										<tr>
											<td colspan="5">Sub Total Amount</td>
											<td colspan="3">&#8377; {{ $subtotal = $total - $discount }}</td>
										</tr>
										<tr>
											<td colspan="5" class="red-color" ><strong>Shipping charge</strong></td>
											<td colspan="3">+ &#8377; {{ $shipping_charge }}</td>
										</tr>
										<tr>
											<th colspan="5">Total Amount</h>
											<td colspan="3">&#8377; {{ $subtotal + $shipping_charge }}</td>
										</tr>
										
						        	@endif

						        @endif
						    @endif
						@else
							@if( $request->use_coupon && $memCoupon )
								<?php 
									$dis = $total * 10 / 100;
									$total = $total - $dis; ?>
								<tr>
									<td colspan="5"><strong>Member Discount</strong></td>
									<td colspan="3"> - &#8377; {{ $dis }}</td>
								</tr>
							@endif
							{{-- <tr>
								<th colspan="5">Sub Total</th>
								<td colspan="3">&#8377; {{ $total }}</td>
							</tr> --}}
							<tr>
								<td colspan="5"class="red-color"><strong>Shipping charge</strong></td>
								<td colspan="3">+ &#8377; {{ $shipping_charge }}</td>
							</tr>		
							<tr>
								<th colspan="5"class="red-color">Total Amount</th>
								<td colspan="3">&#8377; {{ $total + $shipping_charge }}</td>
							</tr>
						@endif
						<tr>
							<th colspan="5" class="red-color"><strong>Payment Method</strong></th>
							<td colspan="3"><strong>{{ strtoupper($request->payment_method) }}</strong></td>
						</tr>

						

						@if( $request->payment_method === 'wallet' )
							<tr>
								<td colspan="5"><strong>Payment Status</strong></td>
								<td colspan="3"><strong>Paid through Wallet</strong></td>
							</tr>
						@endif
					</tfoot>
				</table>
			@endif


			@if( isset( $remarks ) && $remarks )

				<?php $remarks = json_decode($remarks); ?>

				@if( $remarks )
				<br>
					<h3>Remarks</h3>
					<table class="table">
						<body>
							<tr>
								<td><strong>Remark</strong></td>
								<td>{{ isset( $remarks->remarks ) ? $remarks->remarks : '' }}</td>
							</tr>

							<tr>
								<td><strong>File</strong></td>
								<td>
									@if(isset($remarks->file))
										<a target="_blank" href="{{ asset('public/images/'. $remarks->file) }}">
											<img width="200" src="{{ asset('public/images/'. $remarks->file) }}">
										</a>
									@endif
								</td>
							</tr>
						</body>
					</table>

				@endif

		@endif

		<h3>Billing/Shipping details:</h3>
		<div class="billing">
			<p>{{ ucfirst($request->first_name). ' ' . $request->last_name }}</p>
			<?php if($request->payment_method=='cod'): ?>
				<p><?php echo implode(',',$request->address); ?></p>
			<?php else:?>
				<p>{{ ucfirst( $request->address ) }}</p>
			<?php endif;?>
			{{-- <p>{{ $request->city }}, {{ App\model\State::where('id', $request->state)->value('name') }}, {{ App\model\Country::where('id', $request->country)->value('name') }}, {{ $request->pincode }}</p> --}}
			<p>+91 - {{ $request->mobile }}</p>
			@if( $request->alternate )
				<p>{{ $request->alternate }}</p>
			@endif
			<p>{{ $request->email }}</p>
		</div>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>