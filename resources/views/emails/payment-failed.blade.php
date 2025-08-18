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
		<p>You have placed an order but you have aborted the payment.</p>
		<p>Please pay the pending payment for the further processing.</p>
		<h3>Product details:</h3>

		@if( $order )

			<?php $orders = App\model\Order::where('order_id', $order->order_id)->get(); ?>

			<?php $orderMeta = App\model\OrderMeta::where('order_id', $order->order_id)->first(); ?>
			<?php $coupon = $orderMeta ? App\model\Coupon::where('id', $orderMeta->coupon_id)->first() : false; ?>
			<?php $price = 0; $totalPrice = 0; ?>

			@if( $orders && count( $orders ) )
				@foreach( $orders as $o )
					<?php $product = App\model\Product::where('id', $o->product_id)->first(); ?>
					<?php $price = $product ? $product->price : 0; ?>
					@if( $product && $product->discount )
						<?php $totalPrice += $price - ($price * $product->discount) / 100; ?>
					@else
						<?php $totalPrice += $product ? $product->price : 0; ?>
					@endif
				@endforeach
			@endif
			@if( $orderMeta )
				@if( $orderMeta->discount_type == 'inr' )
					<?php $totalPrice = $totalPrice - $orderMeta->discount; ?>
				@else
					<?php $totalPrice = $totalPrice - ($totalPrice * $orderMeta->discount) / 100; ?>
				@endif
			@endif

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