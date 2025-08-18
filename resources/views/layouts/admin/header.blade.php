<?php
	if( !isset( $request ) ) {}
	elseif( $request->session()->has('userData') ) {
		$data = $request->session()->get('userData');
		$adminName = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Trippoo - @yield('title')</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/GetWork-Logo-tiny-50-50.png" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Risque" rel="stylesheet">
	<base href="{{ url('/0/admin_/') }}">
	<!-- ALL CSS FILES -->
	<!-- <link href="css/materialize.css" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/assets/owl.theme.default.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('public/trippoo/css/bootstrap.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ url('public/trippoo/css/font-awesome.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ url('public/trippoo/css/style.css') }}" rel="stylesheet">

	<link href="{{ url('public/trippoo/froala/css/froala_editor.pkgd.min.css') }}" rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
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

	<section class="top-header td-admin">
			<div class="container-fluid">
				<div class="row navbar-fixed-top">
					<nav class="navbar navbar-default no-padding td-bg-blue">
				        <div class="navbar-header">
				            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				              <span class="sr-only">Toggle navigation</span>
				              <span class="icon-bar"></span>
				              <span class="icon-bar"></span>
				              <span class="icon-bar"></span>
				            </button>
				            <a class="navbar-brand" href="{{ url('/') }}"><img alt="Tripoo" src="{{ url('/public/trippoo/img/trippoo-logo.png') }}"></a>
				        </div>
				        <div id="navbar" class="navbar-collapse collapse td-admin-nav">
				            <ul class="nav navbar-nav">
								<li>
									<a class="dropdown-toggle" id="nav-menu" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><div class="td-user-img"><img class="img-circle" src="{{ url('/public/trippoo/img/icons/user1.png') }}"></div> <span class="fa fa-caret-down"></span></a>
									<ul class="dropdown-menu">
									  	<li>
									  		<a href="{{ url('/user') }}">
										  		<div class="td-user">
										  			<div class="td-user-img">
										  				<img class="img-circle" src="{{ url('/public/trippoo/img/icons/user1.png') }}">
										  			</div>
										  			<div class="td-user-name">
										  				<span class="name">{{ $adminName }}</span>
										  			</div>
										  		</div>
									  		</a>
									  	</li>
									  	<li><a href="{{ url('/user') }}">Profile</a></li>
									  	<li><a href="{{ url('/logout') }}">Log Out</a></li>
									</ul>
								</li>
				            </ul>
				        </div><!--/.nav-collapse -->
				    </nav>
				</div>
			</div>
		</section>

		<section class="td-admin-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-2 td-left-col">
					<div class="td-left-menu">
						<div class="td-left-menu-head text-center">
							<ul>
								<li><a href="#"><img class="img-circle" src="{{ url('/public/trippoo/img/icons/avatar.jpg') }}"></a></li>
								<li><a href="#"><span>{{ $adminName }}</span></a></li>
							</ul>
						</div>

						<div class="td-left-menu-body">
							<ul>
								<li><a href="#">Dashboard</a></li>
								<li  data-toggle="collapse" data-target="#menu" class="collapsed active">
				                  <a role="button">Packages <span class="pull-right fa fa-caret-down"></span></a>
				                </li>
				                 <ul class="sub-menu collapse" id="menu">
				                    <li class="active"><a href="{{ url('/0/admin_/packages') }}">All Package</a></li>
				                    <li><a href="{{ url('/0/admin_/add-package') }}">Add Packages</a></li>
				                </ul>
				                <li><a href="{{ url('/0/admin_/categories') }}">Categories</a></li>
								<li><a href="#">USers</a></li>
								<li><a href="#">Setting</a></li>
								<li><a href="#">Profile</a></li>
							</ul>
						</div>
					<ul>
						
					</ul>
					</div>
				</div>

				<div class="col-lg-10 td-right-col">
					
					@yield('content')

				</div>
			</div>
		</div>
	</section>

	


	
	<section class="td-copy">
		<div class="container-fluid text-center">
			<p><span>copyright © 2017 Techdost &nbsp;&nbsp;All rights reserved.</span> <span class="pull-right">Designed by <a href="https://www.techdost.com">Techdost</a></span></p>
		</div>
	</section>

	{{ Form::token() }}
	<!--SCRIPT FILES-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="{{ url('/public/trippoo/js/bootstrap.js') }}"></script>
	<script src="{{ url('/public/trippoo/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="{{ url('/public/trippoo/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.min.js') }}"></script>
	<!-- <script src="js/materialize.min.js" type="text/javascript"></script> -->
	<script src="{{ url('/public/trippoo/js/custom.js') }}"></script>
	 
	<!-- Include JS file. -->
	<script type='text/javascript' src="{{url('/public/trippoo/froala/js/froala_editor.pkgd.min.js') }}"></script>
	<script type='text/javascript' src="{{url('/public/trippoo/froala/js/plugins/image.min.js') }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
 
	<script type="text/javascript">
							  $(function() {
							    $('.content').froalaEditor({
							      toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', '|', 'fontSize', 'color', 'paragraphFormat', 'align', '|', 'formatOL', 'formatUL', 'insertLink', 'insertHR'],
							      pluginsEnabled: null,
							      height: 100
							    });
							    $('.itinerary').froalaEditor({
							      toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', '|', 'fontSize', 'color', 'paragraphFormat', 'align', '|', 'formatOL', 'formatUL', 'insertLink', 'insertHR'],
							      pluginsEnabled: null,
							      height: 100
							    });
							    /*$('.img-files')
							      .froalaeditor({
							        // Set the image upload parameter.
							        imageUploadParam: 'image_param',
							 
							        // Set the image upload URL.
							        imageUploadURL: '/img',
							 
							        // Additional upload params.
							        imageUploadParams: {id: 'my_editor'},
							 
							        // Set request type.
							        imageUploadMethod: 'POST',
							 
							        // Set max image size to 5MB.
							        imageMaxSize: 5 * 1024 * 1024,
							 
							        // Allow to upload PNG and JPG.
							        imageAllowedTypes: ['jpeg', 'jpg', 'png']
							      })
							      .on('froalaEditor.image.beforeUpload', function (e, editor, images) {
							        // Return false if you want to stop the image upload.
							      })
							      .on('froalaEditor.image.uploaded', function (e, editor, response) {
							        // Image was uploaded to the server.
							      })
							      .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
							        // Image was inserted in the editor.
							      })
							      .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
							        // Image was replaced in the editor.
							      })
							      .on('froalaEditor.image.error', function (e, editor, error, response) {
							        // Bad link.
							        if (error.code == 1) { ... }
							 
							        // No link in upload response.
							        else if (error.code == 2) { ... }
							 
							        // Error during image upload.
							        else if (error.code == 3) { ... }
							 
							        // Parsing response failed.
							        else if (error.code == 4) { ... }
							 
							        // Image too text-large.
							        else if (error.code == 5) { ... }
							 
							        // Invalid image type.
							        else if (error.code == 6) { ... }
							 
							        // Image can be uploaded only to same domain in IE 8 and IE 9.
							        else if (error.code == 7) { ... }
							 
							        // Response contains the original server response to the request if available.
							      }); */
							  });
						</script>
	
</body>
</html>