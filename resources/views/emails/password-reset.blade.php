<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
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
		<p>Hi {{ $user->first_name }},</p>
		<p>We have received a request to reset your password:</p><br>
		<div class="thankyou">
			<h3><a style="color: #fff;" target="_blank" href="{{ route('user.password.reset', $token) }}">RESET PASSWORD</a></h3>
		</div>

		<p>If it was not you, ignore this email.</p>

		<div class="signature">
			<?php echo App\model\Meta::where('meta_name', 'signature')->value('meta_value'); ?>
		</div>

	</div>


</body>
</html>