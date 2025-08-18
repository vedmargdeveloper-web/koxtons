	
	@extends('trippoo/header', ['request' => $request])

	<?php
	$title = '';
		if( $request->session()->has('logged_in') && $request->session()->has('type') && $request->session()->has('userData') && $request->session()->get('logged_in') ) {
			$data = $request->session()->get('userData');
			$title = ucfirst( $data['first_name'] ). ' '. $data['last_name'];
		}
	?>

	@section('title', $title)

	@section('main-class', 'td-log no-bg')

	@section('overlay-class', 'no-overlay')

	@section('nav-login-class', '')
	@section('nav-signup-class', '')

	@section('content')

	<section class="td-bg-user">
		<div class="container">
			<div class="row td-padding">
				<div class="col-lg-offset-3 col-lg-6 text-center">
					<div class="td-profile-img">
						<img class="img-circle" src="{{ url('/public/trippoo/img/icons/user1.png') }}">
					</div>
					<div class="td-profile-name">
						<span>{{ $title }}</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	@endsection