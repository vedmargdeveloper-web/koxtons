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
		<p>Hi Admin,</p>
		<div class="thankyou">
			<h3>Order No {{ $request->orderno }}</h3>
		</div>
		<p>A customer uploaded file for customization in the order:</p>
		<h3>Customer details:</h3>
		<table class="table">
			<tbody>
				<tr>
					<td><strong>Name</strong></td>
					<td>{{ $order->first_name.' '.$order->last_name }}</td>
				</tr>
				<tr>
					<td><strong>Email</strong></td>
					<td>{{ $order->email }}</td>
				</tr>
				<tr>
					<td><strong>Mobile</strong></td>
					<td>{{ $order->mobile }}</td>
				</tr>
			</tbody>
		</table>



		@if( $files && count( $files ) > 0 )

			@foreach( $files as $file )
				<a style="padding:10px;" target="_blank" href="{{ asset('public/images/'. $file) }}">
					<img width="200" src="{{ asset('public/images/'. $file) }}">
				</a>
			@endforeach

		@endif


		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>
</body>
