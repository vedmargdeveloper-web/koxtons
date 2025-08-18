<!DOCTYPE html>
<html lang="en">
<head>
	<title>Trippoo - Admin Login</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/GetWork-Logo-tiny-50-50.png" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Risque" rel="stylesheet">
	<!-- ALL CSS FILES -->
	<!-- <link href="css/materialize.css" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.theme.default.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('public/trippoo/css/style.css') }}" rel="stylesheet">
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="{{ url('/public/trippoo/css/responsive.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>

<body>

	<section class="td-bg-login">
		<div class="td-overlay">
			<div class="container">
				<div class="row td-padding">
					<div class="col-lg-12 text-center td-margin-bot">
						<div class="td-title td-no-padd login-title">
							<!-- <span class="fa fa-map-marker"></span> -->
							<h2>Sign In</h2>
						</div>
					</div>
					<div class=" col-lg-offset-4 col-lg-4">
						<div class="panel panel-login">
							
							<div class="panel-body td-login-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="login-container" id="login-form" style="display: block;">
											@if ( $request->session()->has('error') )
												<span class="error-block">
													{{ $error = $request->session()->get('error') }}
												</span>
											@endif
											{{ Form::open(['url' => url('/0/admin_/auth/validate'), 'action' => url('/0/auth/validate'), 'method' => 'post', 'class' => 'form', 'role' => 'form']) }}
												<div class="form-group">
													{{ Form::email('user_email', old('user_email'), array_merge(['placeholder'=>'Email address', 'class'=> 'form-control input-field', 'id'=>'email', 'required'=>'required'])) }}

													@if ($errors->has('user_email'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('user_email') }}
									                    </span>
									                @endif

												</div>
												<div class="form-group">
													{{ Form::password('user_password', ['placeholder'=>'Password', 'class'=> 'form-control input-field', 'id'=>'password', 'required'=>'required']) }}
													@if ($errors->has('user_password'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('user_password') }}
									                    </span>
									                @endif
													<span class="forget-password pull-right"><a href="{{ url('/forgot-password') }}" tabindex="5" class="forgot-password">Forgot Password?</a></span>
												</div>
												<div class="form-group">
													<input type="submit" name="login_submit" id="login-submit" tabindex="4" class="btn btn-primary" value="Sign In">
												</div>
											{{ Form::close() }}

											<!-- <div class="td-social-login text-center">
												<p>OR Login with</p>
												<a href="#"><span class="fa fa-facebook"></span></a>
												<a href="#"><span class="fa fa-google-plus"></span></a>
											</div> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

		<section class="td-copy">
		<div class="container-fluid text-center">
			<p><span>copyright © 2017 Techdost &nbsp;&nbsp;All rights reserved.</span> <span class="pull-right">Designed by <a href="https://www.techdost.com">Techdost</a></span></p>
		</div>
	</section>

	<!--SCRIPT FILES-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.min.js') }}"></script>
	<!-- <script src="js/materialize.min.js" type="text/javascript"></script> -->
	<script src="{{ url('/public/trippoo/js/custom.js') }}"></script>
</body>
</html>