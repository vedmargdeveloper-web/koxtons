<!DOCTYPE html>
<html>
<head>
	<title>Payment Request</title>
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
		.pay {
			margin-left: 30px;
			padding: 5px 8px;
			
			background: blue;
			color: #fff;
			border-radius: 4px;
		}
	</style>
</head>
<body>
	<div class="container">
		<p>Hi {{ $order->first_name }},</p>
		<div class="thankyou">
			<h3>Order No: {{ $order->order_id }}</h3>
		</div>
		<p>Your have placed an order but you have not paid.</p>
		<p>Please pay the pending payment for the further processing.</p>
		<h3>Product details:</h3>

		@if( $order && $product )

			<?php $orderMeta = App\model\OrderMeta::where('order_id', $order->order_id)->first(); ?>
			<?php $coupon = $orderMeta ? App\model\Coupon::where('id', $orderMeta->coupon_id)->first() : false; ?>
			<?php $price = $product->price; ?>
			@if( $orderMeta )
				@if( $orderMeta->discount_type == 'inr' )
					<?php $price = $price - $orderMeta->discount; ?>
				@else
					<?php $price = $price - ($price * $orderMeta->discount) / 100; ?>
				@endif
			@endif
			@if( $product->discount )
				<?php $price = $price - ($price * $product->discount) / 100; ?>
			@endif

			<table class="table">
				<tbody>
					<tr>
						<th>Product Name</th>
						<td>{{ $product->title }}</td>
					</tr>
					<tr>
						<th>Image</th>
						<td><img class="img-thumbnail" src="{{ asset('public/'.product_file(thumb($product->feature_image, 130, 140))) }}"></td>
					</tr>
					<tr>
						<th>Quantity</th>
						<td>{{ $order->quantity }}</td>
					</tr>
					<?php $variation = $order->variation ? json_decode($order->variation) : false; ?>
					<tr>
						<th>Color</th>
						<td>{{ isset($variation->color) ? ucfirst($variation->color) : '' }}</td>
					</tr>
					<tr>
						<th>Size</th>
						<td>{{ isset($variation->size) ? ucfirst($variation->size) : '' }}</td>
					</tr>
					<?php $attribute_meta = isset($variation->c_size) ? App\model\ProductAttributeMeta::where('id', $variation->c_size)->first() : false; ?>
					<?php $attribute = $attribute_meta && isset($attribute_meta->product_attribute_id) ? App\model\ProductAttribute::where('id', $attribute_meta->product_attribute_id)->first() : false; ?>
					<tr>
						<th>
							@if( $attribute )
								@if( isset($attribute->label) && $attribute->label )
									{{ $attribute->label }}
								@else
									{{ isset($attribute->dimension) ? $attribute->dimension : '' }}
								@endif
							@endif
						</th>
						<td>
							@if( $attribute_meta && isset( $attribute_meta->value ) )
								<?php $meta = $attribute_meta->value ? json_decode($attribute_meta->value) : false; ?>
								@if( $attribute_meta->type == 'custom_size' )
									{{ isset( $meta->name ) ? ucfirst($meta->name) : '' }}
								@endif
							@endif
						</td>
					</tr>
					<tr>
						<th>Product Price</th>
						<td>{{ round($product->price, 0) . ' INR' }}</td>
					</tr>
					@if( $product->discount )
						<tr>
							<th>Discount</th>
							<td>{{ $product->discount.'%' }}</td>
						</tr>
					@endif
					@if( $orderMeta && isset($orderMeta->discount) )
						<tr>
							<th>Discount</th>
							<td>
								@if( $orderMeta->discount_type == 'inr' )
									{{ $orderMeta->discount.' INR' }}
								@else
									{{ $orderMeta->discount.' %' }}
								@endif
							</td>
						</tr>
					@endif
					<tr>
						<th>Payable Amount:</th>
						<td>{{ round($price, 0) .' INR' }} <a style="color:#fff" class="pay" target="_blank" href="{{ route('order.payment.request', $order->order_id) }}">Pay Now</a> </td>
					</tr>
				</tbody>
			</table>

			<br>
			<h3>Pay:</h3>
			<p>Click here to <a class="pay" style="color:#fff" target="_blank" href="{{ route('order.payment.request', $order->order_id) }}">Pay Now</a></p>

		@endif

		<div class="signature">
			<?php $signature = App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>

			<?php echo $signature; ?>
		</div>

	</div>


</body>
</html>