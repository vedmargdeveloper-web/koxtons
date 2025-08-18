	
	@extends('trippoo/header', ['request' => $request])

	@section('title', 'Forgot Password')

	@section('main-class', 'td-log no-bg')

	@section('overlay-class', 'no-overlay')

	@section('nav-login-class', '')
	@section('nav-signup-class', '')

	@section('content')

	<section class="td-bg-login">
		<div class="td-overlay">
			<div class="container">
				<div class="row td-padding">
					<div class="col-lg-12 text-center td-margin-bot">
						<div class="td-title td-no-padd login-title">
							<!-- <span class="fa fa-map-marker"></span> -->
							<h2>Forgot Password</h2>
						</div>
					</div>
					<div class=" col-lg-offset-4 col-lg-4 panel-login">
						<h4 class="text-center">Reset password</h4>
						<p>Enter your email address, we will send you a password reset link.</p>
						<div class="login-container td-login-body" id="login-form" style="display: block;">
							@if ( $request->session()->has('error') )
								<span class="error-block">
									{{ $error = $request->session()->get('error') }}
								</span>
							@endif
							{{ Form::open(['url' => url('/0/reset-password'), 'action' => url('/0/reset-password'), 'method' => 'post', 'class' => 'form', 'role' => 'form']) }}
								<div class="form-group">
									{{ Form::email('user_email', old('user_email'), array_merge(['placeholder'=>'Email address', 'class'=> 'form-control input-field', 'id'=>'email', 'required'=>'required'])) }}

									@if ($errors->has('user_email'))
					                    <span class="error-block">
					                        {{ $error = $errors->first('user_email') }}
					                    </span>
					                @endif

								</div>
								<div class="form-group">
									<input type="submit" name="submit" id="submit" tabindex="4" class="btn btn-primary" value="Submit">
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	@endsection