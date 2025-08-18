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
		<p>Hi {{ $request->first_name.' '.$request->last_name }},</p>
		<div class="thankyou">
			<h3>Thankyou for joining our membership.</h3>
		</div>

		<table class="table">
			<tbody>
				<tr>
					<th>Username</th>
					<td>{{ $username }}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{ $request->email }}</td>
				</tr>
				<tr>
					<th>Password</th>
					<td>{{ $request->password }}</td>
				</tr>
			</tbody>
		</table>
		
		<p>Click here to <a href="{{ route('login') }}">Login</a></p>
		<p>We highly recommened the members to change their password.</p>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>