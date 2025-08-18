<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		html,body {
			padding: 0;
			margin: 0;
			font-size: 13px;
		}
		.container {
			padding: 1em 2em;
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
			padding: 3px 5px;
			border-style: solid;
			border-color: #ccc;
			background-color: #c2c1b2;
			font-size: 13px;
		}
		table.table td {
			border-width: 1px;
			padding: 2px 5px;
			border-style: solid;
			border-color: #ccc;
			background-color: #ffffff;
			font-size: 13px;
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
		.logo, .company-details, .gst {
			display: inline-block;
			text-align: left;
			width: 50%;
		}
		p,h3 {
			margin:0;
			padding:0
		}
		table {
			margin-bottom:5px;
		}
		table p {
			margin-bottom: 10px;
		}
	</style>
</head>


<body>

	<div class="container">

		<table style="width: 100%;">
			<tbody style="width: 100%;">
				<tr style="width:100%;">
					<td style="width:50%">
						<?php $logo = App\model\Meta::where('meta_name', 'app_logo')->value('meta_value'); ?>
						<?php $site_name = App\model\Meta::where('meta_name', 'app_name')->value('meta_value'); ?>
						<img src="{{ asset('public/assets/images/'.$logo) }}"style="width:140px;" alt="{{ $site_name }}">
					</td>
					<td style="width:50%;text-align:right;">
						<h3 style="margin:0;text-align:right">Tax Invoice/Bill of Supply/Cash Memo</h3>
						<p style="margin:0;text-align:right">(Original for recipient)</p>
					</td>
				</tr>
			</tbody>
		</table>

		<table style="width: 100%;">
			<tbody style="width: 100%;">
				<tr style="width:100%;">
					<td style="width:50%">
						<h3 style="margin:0;">Sold By:</h3>
						<?php echo $company_name = App\model\Meta::where('meta_name', 'company_name')->value('meta_value'); ?>
					</td>
					<td style="width:50%;text-align:right;">
						<h3 style="margin:0;padding:0">Billing Address:</h3>
						@if( $order->order_customer && count( $order->order_customer ) > 0 )
							<p style="margin:0">{{ ucwords($order->order_customer[0]->first_name.' '.$order->order_customer[0]->last_name) }}<br>
							{{ ucfirst( implode(', ', json_decode($order->order_customer[0]->address)) ) }}, 
							{{ $order->order_customer[0]->city }}, {{ $order->order_customer[0]->state }}, {{ $order->order_customer[0]->country }}, {{ $order->order_customer[0]->pincode }}, {{ 'Mob: +91'.$order->mobile }}</p>
						@endif

						<h3 style="margin-top:10px;padding:0">Shipping Address:</h3>
						@if( $order->order_customer && count( $order->order_customer ) > 0 )
							<p style="margin:0;padding:0">{{ ucwords($order->order_customer[0]->first_name.' '.$order->order_customer[0]->last_name) }}<br>
							{{ ucfirst( implode(', ', json_decode($order->order_customer[0]->address)) ) }}, 
							{{ $order->order_customer[0]->city }}, {{ $order->order_customer[0]->state }}, {{ $order->order_customer[0]->country }}, {{ $order->order_customer[0]->pincode }}, {{ 'Mob: +91'.$order->mobile }}</p>
						@endif
					</td>
				</tr>
			</tbody>
		</table>


		<table style="width: 100%;">
			<tbody style="width: 100%;">
				<tr style="width:100%;">
					<td style="width:50%">
						<p><strong>GST Number: </strong>{{ App\model\Meta::where('meta_name', 'gst_no')->value('meta_value') }}</p>
						<p><strong>PAN Number: </strong>{{ App\model\Meta::where('meta_name', 'pan_no')->value('meta_value') }}</p>
					</td>
				</tr>
			</tbody>
		</table>


		<table style="width: 100%;">
			<tbody style="width: 100%;">
				<tr style="width:100%;">
					<td style="width:50%">
						<p><strong>Order Number:</strong>{{ $order ? $order->order_id : '' }}</p>
						<p><strong>Order Date:</strong>{{ $order ? $order->created_at->format('d-m-Y') : '' }}</p>
						<p><strong>Payment Mode:</strong> {{ strtoupper($order->payment_mode) }}</p>
						<p><strong>TXN ID:</strong> {{ $order->payment->razorpay_order_id ?? '' }}</p>
					</td>
					<td style="width:50%;text-align:right;">
						<p><strong>Invoice Number:</strong>{{ $order ? $invoice->invoice_no : '' }}</p>
						<p><strong>Invoice Date:</strong>{{ $invoice ? $invoice->created_at->format('d-m-Y') : '' }}</p>
					</td>
				</tr>
			</tbody>
		</table>

		<?php $digital_signature = App\model\Meta::where('meta_name', 'digital_signature')->value('meta_value'); ?>

		<?php $total = 0; ?>

	    @if( $order && $invoice )

	    	<?php $shipping_charge = 0; ?>

			<table class="table">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Name</th>
						<th>Unit Price</th>
						<th>Color/ Size</th>
						<th>Quantity</th>
						<th>Net Amount</th>
						<th>Tax Rate</th>
						<th>Tax Type</th>
						<th>Tax Amount</th>
						<th>total</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $order->order_products as $key => $row )
					
					<?php $variation = json_decode($row->variations); ?>
					<?php $shipping_charge += $variation && isset($variation->shipping_charge) ? $variation->shipping_charge : 0; ?>
					<?php

						$product = App\model\Product::find( $row->product_id );
						$price = $variation->price;
						if( isset($variation->discount) && $variation->discount )
							$price = $variation->price - ( ( $variation->price * $variation->discount ) / 100 );
						if( $order->coupon_discount ) {
							if( $order->coupon_discount_type === 'percent' ) {
								$price = $price - ( ( $price * $order->coupon_discount ) / 100 );
							}
							else if( $order->coupon_discount_type === 'inr' ) {
								$price = $price - $order->coupon_discount;
							}
						}

						$gst_price = 0;
						if( $product && $product->gst ) {
							$div = $product->gst + 100;
							$gst_price = round( ($price * $product->gst) / $div, 2 );
						}

						$price = round( $price, 2 );
						$unit_price = $price - $gst_price;

						$gst_shipping = $shipping_charge ? round($shipping_charge * 18 / 100, 2) : 0;
						$unit_shipping_charge = $shipping_charge ? $shipping_charge - $gst_shipping : 0;
					?>

					<?php  ?>
					<?php $v_title = $variation->variation_name ? $variation->title . ' - ' . $variation->variation_name : $variation->title; ?>
					<tr>
						<td>{{ ++$key.'.' }}</td>
						<td><p>{{ $v_title }}</p>
							@if( $shipping_charge )
								<p>Shipping Charge</p>
							@endif
						</td>
						<td>
							<p>Rs.{{ $unit_price }}</p>
							@if( $unit_shipping_charge )
								<p>Rs.{{ $unit_shipping_charge }}</p>
							@endif
						</td>
						<td>
							@php  echo ucwords($variation->color ?? '') @endphp / <?php $sid = $variation->size ?? 0;  $dd = App\model\ProductAttributeMeta::where('id',$sid)->first(); echo ucwords($dd->name??'');  ?>
						</td>

						<td>{{ $variation->quantity }}</td>
						<td>
							<p>Rs.{{ $variation->quantity * $unit_price }}</p>
							@if( $unit_shipping_charge )
								<p>Rs.{{ $variation->quantity * $unit_shipping_charge }}</p>
							@endif
						</td>
						<td>
							@if( $product )
								<p>{{ $product->gst.'%' }}</p>
							@endif
							@if( $gst_shipping )
								<p>18%</p>
							@endif
						</td>
						<td>
							@if( $gst_price )
								<p>GST</p>
							@endif
							@if( $gst_shipping )
								<p>GST</p>
							@endif
						</td>
						<td>
							@if( $gst_price )
								<p>Rs.{{ $gst_price }}</p>
								@if( $gst_shipping )
									<p>Rs.{{ $variation->quantity * $gst_shipping }}</p>
								@endif
							@endif
						</td>
						<td>
							<p>Rs.{{ ($variation->quantity * $unit_price) + ($variation->quantity * $gst_price) }}</p>
							@if( $shipping_charge )
								<p>Rs.{{ $variation->quantity * $shipping_charge }}</p>
							@endif
						</td>
						
						<?php $total += $shipping_charge ? ($variation->quantity * $shipping_charge) + ($variation->quantity * $price) : $variation->quantity * $price; ?>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					
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
											<td colspan="3">Rs.{{ $off = ( $total * $coupon->discount ) / 100 }}</td>
										@endif
									</tr>
									<tr>
										<td colspan="6">Total</td>
										<th colspan="2">Rs.{{ $subtotal = $total - $off }}</th>
									</tr>
									
					        	@else
					        		@if( $coupon )
						        		<tr>
											<td colspan="4">Offer discount</td>
											<td>{{ $request->coupon }}</td>
											<td colspan="3">Rs.{{ $discount = $coupon->discount }}</td>
										</tr>
									@endif
									<tr>
										<td colspan="6">Total</td>
										<th colspan="2">Rs.{{ $subtotal = $total - $discount }}</th>
									</tr>
									
					        	@endif

					        @endif
					    @endif
					@else
						<tr>
							<td colspan="8">Total</td>
							<th>Rs.{{ $gst_price + $gst_shipping }}</th>
							<th>Rs.{{ $total }}</th>
						</tr>
					@endif
				</tfoot>
			</table>

			<table class="table" style="border:0;">
				<tbody>
					<tr>
						<td style="border:0;"><strong>Date:</strong></td>
						<td style="border:0;text-align:right;"><strong>Digital Signature</strong></td>
					</tr>
					<tr>
						<td style="border:0;">{{ $invoice->created_at->format('d M, Y') }}</td>
						<td style="border:0;text-align:right;">
							<img style="width:60px;" src="{{ asset('public/assets/images/'.$digital_signature) }}">
						</td>
					</tr>
				</tbody>
			</table>

		@endif

	</div>


</body>
</html>