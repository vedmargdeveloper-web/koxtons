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
			/*background: linear-gradient(135deg, #e31f23 0, #383085 100%);*/
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
		<p>Hi,</p>
		<div class="thankyou">
			<h1>A new order placed, Order No: {{ $order->order_id }}</h1>
		</div>
		<p>Here are the following details of ther order:</p>
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
						<?php $v_title = $variation->variation_name ? $variation->title . ' - ' . $variation->variation_name : $variation->title; ?>
						<tr>
							<td>{{ ++$key.'.' }}</td>
							<td><img class="img-thumbnail" src="{{ $variation->feature_image }}"></td>
							<td>{{ $v_title }}</td>
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
							<td colspan="5" class="red-color"><strong>Sub Total:</strong></td>
							<td colspan="3"> &#8377; {{ $total }}</td>
						</tr>


						@if($order->c_coupon)
							<tr>
								<td colspan="5" class="red-color"><strong>Coupon:</strong></td>
								<td colspan="3">  {{ $order->c_coupon }}</td>
							</tr>
						@endif
						
						<tr>
							<th colspan="5" class="red-color"><strong>Shipping charge</strong></th>
							<td colspan="3">+ &#8377; {{ $shipping_charge }}</td>
						</tr>		
						<tr>
							<th colspan="5" class="red-color">Total Amount</th>
							<td colspan="3">&#8377; {{ $total + $shipping_charge }}</td>
						</tr>
						<tr>
							<td colspan="5" class="red-color"><strong>Payment Method</strong></td>
							<td colspan="3"><strong>{{ strtoupper($order->payment_mode) }}</strong></td>
						</tr>
						
					</tfoot>
				</table>
			@endif


			@if( $order->remark )
			<br>
				<h3>Remarks</h3>
				<table class="table">
					<body>
						<tr>
							<td><strong>Remark</strong></td>
							<td>{{ isset( $order->remark ) ? $order->remark : '' }}</td>
						</tr>

					</body>
				</table>

			@endif


		<h3>Billing/Shipping details:</h3>
		<div class="billing">
			<p>{{ ucfirst($order->order_customer[0]->first_name)}}</p>
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