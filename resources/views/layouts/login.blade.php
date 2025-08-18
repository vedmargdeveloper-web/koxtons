	
	@extends('trippoo/header', ['request' => $request])

	@section('title', 'Login')

	@section('main-class', 'td-log no-bg')

	@section('overlay-class', 'no-overlay')

	@section('nav-login-class', 'tosignin')
	@section('nav-signup-class', 'tosignup')

	@section('content')

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
							<div class="panel-heading td-login-heading">
								<div class="row">
									<div class="col-xs-12">
										<a class="td-login-btn active" href="#login" class="active" id="login-form-link">Sign In</a>
										<a class="td-signup-btn" href="#register" id="register-form-link">Sign Up</a>
									</div>
								</div>
								<hr>
							</div>
							<div class="panel-body td-login-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="login-container" id="login-form" style="display: block;">
											@if ( $request->session()->has('error') )
												<span class="error-block">
													{{ $error = $request->session()->get('error') }}
												</span>
											@endif
											{{ Form::open(['url' => url('/0/auth/validate'), 'action' => url('/0/auth/validate'), 'method' => 'post', 'class' => 'form', 'role' => 'form']) }}
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

										<div class="register-form" id="register-form" style="display: none;">
											{{ Form::open(['url'=>url('/register/0/auth/validate'), 'action'=>url('/register/0/auth/validate'), 'method' => 'post', 'class' => 'form', 'role' => 'form']) }}
												<div class="form-group">
													{{ Form::text('first_name', old('first_name'), array_merge(['placeholder'=>'First name', 'class'=> 'form-control input-field', 'id'=>'first-name'])) }}

													@if ($errors->has('first_name'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('first_name') }}
									                    </span>
									                @endif
												</div>
												<div class="form-group">
													{{ Form::text('last_name', old('last_name'), array_merge(['placeholder'=>'Last name', 'class'=> 'form-control input-field', 'id'=>'last-name', 'required'=>'required'])) }}

													@if ($errors->has('last_name'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('last_name') }}
									                    </span>
									                @endif
												</div>
												<div class="form-group">
													{{ Form::email('email', old('email'), array_merge(['placeholder'=>'Email address', 'class'=> 'form-control input-field', 'id'=>'email', 'required'=>'required']) ) }}

													@if ($errors->has('email'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('email') }}
									                    </span>
									                @endif
												</div>
												<div class="form-group">
													{{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control input-field', 'id'=>'password', 'required'=>'required'] ) }}

													@if ($errors->has('password'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('password') }}
									                    </span>
									                @endif
												</div>
												<div class="form-group">
													{{ Form::password('password_confirmation', ['placeholder'=>'Confirm password', 'class'=> 'form-control input-field', 'id'=>'password', 'required'=>'required']) }}

													@if ($errors->has('password_confirmation'))
									                    <span class="error-block">
									                        {{ $error = $errors->first('password_confirmation') }}
									                    </span>
									                @endif
												</div>
												<div class="form-group">
													<input type="submit" name="signup_submit" id="login-submit" tabindex="4" class="btn btn-primary" value="Sign Up">
												</div>
											{{ Form::close() }}
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

	@endsection