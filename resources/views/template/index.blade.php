<!DOCTYPE html>
<html>
<head>
	<title>Laravel</title>
	<meta content="width=device-width,initial-scale=1" name=viewport>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ url('/public/css/style.css') }}">
</head>
<body>

	<section class="home top-header header">
		<div class="container-fluid">
			<nav class="navbar navbar-default navbar-fixed-top">
		      <div class="container">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="navbar-brand" href="#">Brand name</a>
		        </div>
		        <div id="navbar" class="navbar-collapse collapse">
		          <ul class="nav navbar-nav">
		            <li class="active"><a href="#">Home</a></li>
		            <li><a href="#about">About</a></li>
		            <li><a href="#contact">Contact</a></li>
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
		              <ul class="dropdown-menu">
		                <li><a href="#">Action</a></li>
		                <li><a href="#">Another action</a></li>
		                <li><a href="#">Something else here</a></li>
		                <li role="separator" class="divider"></li>
		                <li class="dropdown-header">Nav header</li>
		                <li><a href="#">Separated link</a></li>
		                <li><a href="#">One more separated link</a></li>
		              </ul>
		            </li>
		          </ul>
		          <ul class="nav navbar-nav navbar-right">
		            <li><a href="../navbar/">Default</a></li>
		            <li><a href="../navbar-static-top/">Static top</a></li>
		            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
		          </ul>
		        </div><!--/.nav-collapse -->
		      </div>
		    </nav>
	    </div>
	    <div class="container form-container">
			<div class="row">
				{!! Form::open(['url' => '', 'role' => 'form']) !!}
					<input type="" name="">
				{!! Form::close() !!}
			</div>
		</div>
	</section>
	<section>
		
	</section>


	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>