<!DOCTYPE html>
<html>
<head>
	<title>New Query</title>
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
			background: #e31f23;
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
		<div class="thankyou">
			<h3>A New Query Arrived</h3>
		</div>
		<p>Here are the following details of the query:</p>

		@if( $request )

			<table class="table">
				<tbody>
					<tr>
						<th><strong>Name</strong></th>
						<td>{{ ucwords($request->name) }}</td>
					</tr>
					<tr>
						<th><strong>Email</strong></th>
						<td>{{ $request->email }}</td>
					</tr>

					<tr>
						<th><strong>Mobile</strong></th>
						<td>{{ $request->mobile }}</td>
					</tr>

					<tr>
						<th><strong>Subject</strong></th>
						<td>{{ $request->subject }}</td>
					</tr>
					<tr>
						<th><strong>Message</strong></th>
						<td>{{ $request->message }}</td>
					</tr>
				</tbody>
			</table>

		@endif

		<span>This mail sent from contact us form.</span>

	</div>


</body>
</html>