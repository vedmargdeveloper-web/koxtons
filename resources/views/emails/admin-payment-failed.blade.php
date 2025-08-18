<!DOCTYPE html>
<html>
<head>
	<title>Payment Request</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		<p>Hi Admin,</p>
		<div class="thankyou">
			<h3>Order No: {{ $order->order_id }}</h3>
		</div>
		<p>Customer "{{ $order->first_name.' '.$order->last_name }}" have placed an order but aborted the payment.</p>

		<div class="signature">
			<?php $signature = App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>

			<?php echo $signature; ?>
		</div>

	</div>


</body>
</html>