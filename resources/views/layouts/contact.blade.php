	@extends('trippoo/header')

	@section('title', 'Contact Us')

	@section('main-class', 'td-pg-shadow td-package package top-head')

	@section('overlay-class', 'no-overlay')

	@section('content')

	<section class="td-contact-us td-contact td-content td-padding td-bg-gray">
		<div class="container">
			<div id="contact-us" class="row td-margin-bot">				
				<div class="td-title td-no-padd text-center">
					<h2>Contact Us</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3488.2696540683087!2d77.70430321464788!3d29.038604472337774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390c6f87218cb001%3A0x25027c84aee6098!2sTechDost!5e0!3m2!1sen!2sin!4v1514374570177" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="col-lg-12 td-padding">
					<div class="col-lg-8">
						<div class="form-container td-bg-white">
							{{ Form::open(['url' => url('/'), 'action' => url('/'), 'method' => 'post', 'class' => 'form', 'role' => 'form']) }}
								<div class="form-group col-md-6">
									{{ Form::text('name', '', array_merge(['placeholder'=>'Your name', 'class'=> 'form-control input-field name', 'id'=>'name']) ) }}
								</div>
								<div class="form-group col-md-6">
									<input type="tel" name="phone" class="phone form-control input-field" placeholder="Contact no.">
								</div>
								<div class="form-group">
									{{ Form::email('email', '', array_merge(['placeholder'=>'Email address', 'class'=> 'form-control input-field', 'id'=>'email']) ) }}
								</div>
								<div class="form-group">
									<textarea class="form-control message" rows="4" placeholder="Your message"></textarea>
								</div>
								<input type="submit" name="submit" class="btn btn-primary" value="Send">
							{{ Form::close() }}
						</div>
					</div>
					<div class="col-lg-4">
						<div class="td-left td-bg-white">
							<div class="td-address">
								<div><span class="fa fa-home"></span></div>
								<div><p>1st Floor, 6-PAC, Opp- Isha Apartment, Roorkee Road, Golden Avenue, Daurli, Meerut, Uttar Pradesh 250001</p></div>
							</div>
							<div class="td-phone">
								<div><span class="fa fa-phone"></span></div>
								<div><p>1-800-123-HELLO</p></div>
							</div>
							<div class="td-email">
								<div><span class="fa fa-envelope"></span></div>
								<div><p><a href="mail@help@trippoo.com">help@trippoo.com</a></p></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	@endsection