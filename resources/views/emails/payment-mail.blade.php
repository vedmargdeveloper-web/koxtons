<!DOCTYPE html>
<html>
<head>
	<title>Payment success</title>
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
		table.table tbody th {
			background: #f8f7f6;
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
			font-size: 1em;
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
		<p>Hi {{ $order->first_name }},</p>
		<div class="thankyou">
			<h3>Thank you for shopping with us. Your transaction is successful. We will be shipping your order to you soon.</h3>
		</div>
		<p>Here are the following details of your payment:</p>
		<h3>Payment details:</h3>

		@if( $order && $payment )

			<table class="table">
				<tbody>
					<tr>
						<th>Order No.</th>
						<td>{{ $order->order_id }}</td>
					</tr>
					<tr>
						<th>Tracking ID</th>
						<td>{{ $payment->tid }}</td>
					</tr>
					<tr>
						<th>Payment Status</th>
						<td>{{ $payment->status_message }}</td>
					</tr>
					<tr>
						<th>Amount</th>
						<td>&#8377; {{ $payment->amount }}</td>
					</tr>
				</tbody>
			</table>

		@endif

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>