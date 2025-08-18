<!DOCTYPE html>
<html>
<head>
	<title>Order placed successfully</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
			width: 60%;
		}
		.thankyou {
			/*background: #484581;*/
			background: #383085;
			padding: 20px;
			text-align: center;
		}
		.red-color {
			/*background: #484581;*/
			background: #e31f23;
			color: #fff !important;
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
		<p>Hi {{ config('app.name') }},</p>
		<div class="thankyou">
			<h3>Order cancel request, Order No-{{ $request->order_id }}</h3>
		</div>

		<table class="table">
			<tbody>
				<tr>
					<th class="red-color">Name</th>
					<td>{{ ucwords(Auth::user()->first_name.' '.Auth::user()->last_name) }}</td>
				</tr>
				<tr>
					<th class="red-color">Email</th>
					<td>{{ Auth::user()->email }}</td>
				</tr>
				<tr>
					<th class="red-color">Order No</th>
					<td>{{ $request->order_id }}</td>
				</tr>
			</tbody>
		</table>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>