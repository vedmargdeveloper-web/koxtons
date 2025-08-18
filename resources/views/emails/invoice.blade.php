<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<style type="text/css">
		html,body {
			padding: 0;
			margin: 0;
		}
		.container {
			padding: 1.5em 2em;
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
			padding: 5px 10px;
			border-style: solid;
			border-color: #ccc;
			background-color: #c2c1b2;
			font-size: 15px;
		}
		table.table td {
			border-width: 1px;
			padding: 6px 10px;
			border-style: solid;
			border-color: #ccc;
			background-color: #ffffff;
			font-size: 14px;
		}
		table.table thead th{
			padding: 5px 10px;			
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
			display: block;
			text-align: center;
			width: 100%;
		}
		p {
			display: block;
			float: left;
			width: 100%;
		}
	</style>
</head>


<body>

	<div class="container">
		<p>Hi {{ $first_name }},</p>
		<p>Thank you for shopping with us.</p>
		<p>PFA...</p>
	

	    @if( $invoice )


			<div class="signature">
				<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
			</div>

		@endif

	</div>


</body>
</html>