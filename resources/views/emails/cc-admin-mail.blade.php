<!DOCTYPE html>
<html>
<head>
	<title>Order placed successfully</title>
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
			background-color: #c2c1b2;
			font-size: 17px;
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
			background: #484581;
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
		<p>Hi,</p>
		<div class="thankyou">
			<h3>An order placed {{ $order->order_id }}</h3>
		</div>
		
		<p>Here are the following details of the order:</p>
		<h3>Product details:</h3>

		<?php $total = 0; ?>

		    @if( $order && $payment )

		    	<?php $memCoupon = false; ?>
		    	@if( $order->member_coupon_amt && App\User::isMember() )
		    		<?php $memCoupon = App\model\MemberCoupon::where(['user_id' => Auth::id(), 'status' => 'active'])->first(); ?>
		    		@if( !$memCoupon || !$memCoupon->left_amount )
		    			<?php $memCoupon = false; ?>
		    		@endif
		    	@endif

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
						@foreach( $order->order_products as $key => $row )
						
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
										<p><strong>Size:</strong> {{ ucfirst($meta->name) }}</p>
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
							<td colspan="5"><strong>Sub Total:</strong></td>
							<td colspan="3"> &#8377; {{ $total }}</td>
						</tr>
						
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
											<td>{{ $coupon->code }}</td>
											<td colspan="3"><?php echo $discount = isset($coupon->discount) ? $coupon->discount : 0  ?>%</td>
											@if( $discount )
												<td colspan="3"> - &#8377;{{ $off = ( $total * $coupon->discount ) / 100 }}</td>
											@endif
										</tr>
										@if( $memCoupon )
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
											<td colspan="5"><strong>Shipping charge</strong></td>
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
												<td>{{ $coupon->code }}</td>
												<td colspan="3">  - &#8377; {{ $discount = $coupon->discount }}</td>
											</tr>
										@endif
										@if( $memCoupon )
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
											<td colspan="5"><strong>Shipping charge</strong></td>
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
							@if( $memCoupon )
								<?php 
									$dis = $total * 10 / 100;
									$total = $total - $dis; ?>
								<tr>
									<td colspan="5"><strong>Member Discount</strong></td>
									<td colspan="3"> - &#8377; {{ $dis }}</td>
								</tr>
							@endif
							<tr>
								<th colspan="5">Sub Total</th>
								<td colspan="3">&#8377; {{ $total }}</td>
							</tr>
							<tr>
								<td colspan="5"><strong>Shipping charge</strong></td>
								<td colspan="3">+ &#8377; {{ $shipping_charge }}</td>
							</tr>		
							<tr>
								<th colspan="5">Total Amount</th>
								<td colspan="3">&#8377; {{ $total + $shipping_charge }}</td>
							</tr>
						@endif
						<tr>
							<td colspan="5"><strong>Payment Method</strong></td>
							<td colspan="3"><strong>{{ strtoupper($order->payment_mode) }}</strong></td>
						</tr>
						@if( $payment->order_status === 'Success' )
						<tr>
							<td colspan="5"><strong>Payment Status</strong></td>
							<td colspan="3"><strong>Paid</strong></td>
						</tr>
						@endif
					</tfoot>
				</table>

				<br>
				<h3>Payment Info.</h3>
				<table class="table table-bordered">
					<tr>
						<th>Payment ID</th>
						<td>{{ $payment->payment_id }}</td>
					</tr>
					<tr>
						<th>Payment TXN ID</th>
						<td>{{ $payment->tid }}</td>
					</tr>
					<tr>
						<th>Payment Mode</th>
						<td>{{ $payment->payment_mode }}</td>
					</tr>
					<tr>
						<th>Payment Status</th>
						<td>{{ $payment->order_status }}</td>
					</tr>
					<tr>
						<th>Amount</th>
						<td>&#8377; {{ $payment->amount }}</td>
					</tr>
				</table>

				@if( $order->remark )
					<br>
					<h3>Remarks</h3>
					<p>{{ $order->remark }}</p>
				@endif

		@endif

		<h3>Billing/Shipping details:</h3>
		<div class="billing">
			<p>{{ ucfirst($order->order_customer[0]->first_name). ' ' . $order->order_customer[0]->last_name }}</p>
			<p>{{ ucfirst( $order->address ) }}</p>
			
			<p>+91 - {{ $order->mobile }}</p>
			@if( $order->alternate )
				<p>{{ $order->alternate }}</p>
			@endif
			<p>{{ $order->order_customer[0]->email }}</p>
		</div>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>