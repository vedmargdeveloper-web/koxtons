<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name') }} - {{ (isset($title)) ? $title : '' }} @yield('title')</title>
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
	<link rel="stylesheet" type="text/css" href="{{ url('/public/assets/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/assets/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.theme.default.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('public/assets/css/style.css') }}" rel="stylesheet">
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="{{ url('/public/assets/css/responsive.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<!--BANNER AND SERACH BOX-->
	<div class="td-overlay-home">
		
	</div>
	<section class="top-header @yield('main-class')">
		<div class="@yield('overlay-class')">
			<div class="container-fluid">
				<div class="row navbar-fixed-top">
					<div class="main-hero">
						<div class="left-hero">
							<ul>
								<li><a href="#">My Account</a></li>
							</ul>
							<ul class="pull-right top-social-icon">
								<li><a href="#"><span class="fa fa-shopping-cart"></span> Cart</a></li>
								<li><a href="#"><span></span>Sign In</a></li>
								<li><a href="#"><span></span>Sign Up</a></li>
							</ul>

						</div>
					</div>
					<nav class="navbar navbar-default">
				        <div class="navbar-header">
				            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				              <span class="sr-only">Toggle navigation</span>
				              <span class="icon-bar"></span>
				              <span class="icon-bar"></span>
				              <span class="icon-bar"></span>
				            </button>
				            <div class="navbar-brand">
				            	<a href="{{ url('/') }}"><img alt="Tripoo" src="{{ url('/public/assets/img/trippoo-logo.png') }}"></a>
				            </div>
				            <div class="td-search-container">
										{{ Form::open(['url', '/', 'method' => 'get', 'class' => 'form', 'role' => 'form']) }}
											<div class="td-sr td-select-location text-center">
												<a class="dropdown-toggle" id="nav-menu" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><span class="fa fa-location-arrow"></span> <span class="fa fa-chevron-down"></span></a>
												<ul class="dropdown-menu">
													<li><a href="#">Mumbai</a></li>
													<li><a href="#">Chennai</a></li>
													<li><a href="#">Delhi</a></li>
													<li><a href="#">Noida</a></li>
													<li><a href="#">Goa</a></li>
												</ul>
											</div>
											<div class="td-sr td-input-box">
												<input type="text" placeholder="Search local" name="search" class="form-control input-field search-field" id="search">
											</div>
											<div class="td-sr td-search-btn-holder">
												<button class="td-btn td-btn-search"><i class="fa fa-search"></i></button>
											</div>
										{{ Form::close() }}
										</div>
				        </div>
				        <div id="navbar" class="navbar-collapse collapse">
				            <ul class="nav navbar-nav">
				            	<li>
										
				            	</li>
				            	<li><a href="#">Become a Professional</a></li>
				            	<li><a href="#">Log In</a></li>
				            	<li><a href="#">Sign Up</a></li>
				            	<!-- <li><a href="#"></a></li> -->
								<!-- <li>
									<a class="dropdown-toggle" id="nav-menu" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">My Account <span class="fa fa-caret-down"></span></a>
									<ul class="dropdown-menu"> -->
									
									<?php /*if( !isset( $request ) ) {?>
											<li><a class="@yield('nav-login-class')" href="{{ url('/login#signin') }}">Sign In</a></li>
											<li><a class="@yield('nav-signup-class')" href="{{ url('/login#signup') }}">Sign Up</a></li>
									<?php }
										  else if( !$request->session()->has('logged_in') && !$request->session()->has('userData') && !$request->session()->has('type') && !$request->session()->get('logged_in') ) {?>
										  	<li><a class="@yield('nav-login-class')" href="{{ url('/login#signin') }}">Sign In</a></li>
											<li><a class="@yi\eld('nav-signup-class')" href="{{ url('/login#signup') }}">Sign Up</a></li>
									<?php }
										  else { ?>
										  	<li>
										  		<a href="{{ url('/user') }}">
										  		<div class="td-user">
										  			<div class="td-user-img">
										  				<img class="img-circle" src="{{ url('/public/trippoo/img/icons/user1.png') }}">
										  			</div>
										  			<div class="td-user-name">
										  				<span class="name"><?php 
										  					$data = $request->session()->get('userData');
										  					echo ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
										  				?></span>
										  			</div>
										  		</div>
										  		</a>
										  	</li>
										  	<li><a href="{{ url('/user') }}">Profile</a></li>
										  	<li><a href="{{ url('/logout') }}">Log Out</a></li>

									<?php }*/ ?>
										
									<!-- </ul>
								</li>
								<li><a href="{{ url('/contact') }}">Contact Us</a></li>
								<li><a href="{{ url('/refer') }}">Refer &amp; Earn</a></li> -->
				            </ul>
				        </div><!--/.nav-collapse -->
				    </nav>
				</div>
				
				@yield('search')

			</div>
		</div>
	</section>


	@yield('content')


	<!--FOOTER SECTION-->
	<!-- <section class="td-footer td-padd">
		<footer id="colophon" class="site-footer clearfix">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="td-extras">
							<li>
								<a href="#!">
									<span class="fa fa-inr"></span>
									<span class="fa-text">Best price gaurantee</span>
								</a>
							</li>
							<li>
								<a href="#!">
									<span class="fa fa-eye-slash"></span>
									<span class="fa-text">No hidden charges</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="one-columns quick-links">
							<li> <a href="#">About us</a> </li>
							<li> <a href="#">Connect with</a> </li>
							<li> <a href="#">Quick Access</a> </li>
						</ul>
					</div>
				</div>
				 <div class="row">
			        <div class="td-social text-center">
						<h4>Follow us on</h4>
						<ul>
							<li><a href="#!"><i class="fa fa-facebook"></i></a> </li>
							<li><a href="#!"><i class="fa fa-google-plus"></i></a> </li>
							<li><a href="#!"><i class="fa fa-instagram"></i></a> </li>
							<li><a href="#!"><i class="fa fa-twitter"></i></a> </li>
						</ul>
					</div>
				 </div>
			</div>

		</footer>
	</section>
	<section class="td-copy">
		<div class="container-fluid text-center">
			<p><span>copyright © 2017 Techdost &nbsp;&nbsp;All rights reserved.</span> <span class="pull-right">Designed by <a href="https://www.techdost.com">Techdost</a></span></p>
		</div>
	</section> -->

	<!--SCRIPT FILES-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="{{ url('/public/assets/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.min.js') }}"></script>
	<!-- <script src="js/materialize.min.js" type="text/javascript"></script> -->
	<script src="{{ url('/public/assets/js/custom.js') }}"></script>
</body>
</html>