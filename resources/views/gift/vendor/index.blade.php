<!DOCTYPE html>
<html>
<head>
	
    <meta charset="utf-8">
    <title>{{ isset( $title ) ? $title : '' }}</title>
    <meta name="description" content="Philos Template" />
    <meta name="keywords" content="philos, WooCommerce, bootstrap, html template, philos template">
    <meta name="author" content="philos" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- Favicone Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="icon" type="img/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- CSS -->
    <link href="{{ asset('assets/css/plugins/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap css -->
    <link href="{{ asset('assets/css/plugins/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- fontawesome css -->
	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css') }}">

</head>
<body>

	<section class="mt-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-3 col-md-12 col-sm-12-col-xs-12 pt-5">
					<div class="form-container bg-shadow mt-5">
						<h3 class="mb-5">Login</h3>

						@if( Session::has('vendor_log_err') )
							<span class="warning"><i class="fa fa-warning"></i> {{ Session::get('vendor_log_err') }}</span>
						@endif

						{{ Form::open(['url' => route('vendor.login')]) }}

						<div class="form-group">
							<input type="text" value="{{ old('email') }}" placeholder="email" name="email" class="form-control">
							@if( $errors->has('email') )
								<span class="label-warning">{{ $errors->first('email') }}</span>
							@endif
						</div>

						<div class="form-group">
							<input type="password" placeholder="Password" name="password" class="form-control">
							@if( $errors->has('password') )
								<span class="label-warning">{{ $errors->first('password') }}</span>
							@endif
						</div>
						<span class="pull-left">
							<a href="#" class="forgot">Forgot password?</a>
						</span>


						<button class="btn btn-primary pull-right" name="submit">Login</button>

						{{ Form::close() }}

					</div>
				</div>
			</div>
		</div>
	</section>


	<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

</body>
</html>