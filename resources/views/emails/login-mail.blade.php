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
		<p>Hi {{ $request->first_name }},</p>
		<p>Your account created successfully!</p>
		<p>Here is the following login details:</p>
		<h3>Login details:</h3>

		@if( $request )
			<div class="billing">
			    <p><strong>Email: </strong> <span>{{ $request->email }}</span></p>
			    <p><strong>Password: </strong> <span>{{ $password }}</span></p>
		    </div>
		@endif
		<p>We highly recommened the customers to change their password.</p>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>