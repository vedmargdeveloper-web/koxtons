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
			overflow: auto;
		}
		table.table th {
			border-width: 1px;
			padding: 8px 10px;
			border-style: solid;
			border-color: #ccc;
			
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
		<p>Hi {{ config('app.name') }},</p>
		<div class="thankyou">
			<h3>Complain for order, Order no: {{ $request->order_no }}</h3>
		</div>
		<table class="table">
			<tbody>
				<tr>
					<th>Complain SRN:</th>
					<td>{{ $complain_no }}</td>
				</tr>
				<tr>
					<th>Order No</th>
					<td>{{ $request->order_no }}</td>
				</tr>
				<tr>
					<th>Return Type</th>
					<td>{{ ucfirst($request->return_type) }}</td>
				</tr>
				<tr>
					<th>Reason</th>
					<td>{{ ucfirst($request->reason) }}</td>
				</tr>
				<tr>
					<th>Remark</th>
					<td>{{ $request->remark }}</td>
				</tr>
			</tbody>
		</table>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>