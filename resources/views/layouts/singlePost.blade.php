<?php
	$title = '';
	$catData = '';
	if( !isset($post_model, $media_model, $param1, $param2, $_GET['type'], $_GET['id'], $_GET['destination']) ) {}
	else {
		$post = $post_model->post_by_id( $_GET['id'] );
		$catData = $post_model->category_id_by_slug( $param1 );
		$title = ( $post!==false ) ? $post[0]['title'] : 'Not found';
?>

	@extends('trippoo/header', ['request' => $request, 'title'=>$title])
	
	@section('title', '')

	@section('main-class', 'top-head top-banner td-cat')

	@section('overlay-class', 'td-overlay')

	@section('search')
		<div class="row td-top-title">
			<div class="col-lg-12 text-center">
				<div class="td-title">
					<h2>{{ $title }}</h2>
				</div>
			</div>
		</div>
	@endsection

	@section('content')
		<section class="td-ds-package td-package td-content td-padding td-bg-gray">
		<div class="container">
			<div id="book-now" class="row">				
				<div class="col-lg-12 td-container">

					<!-- Package Nav -->
					<div class="col-lg-9 td-bg-white">
						<div class="td-pg-top-nav">
							<div class="td-pg-title">
								<div class="td-title">
									<h2>{{ $title }}</h2>
								</div>
								<div class="td-price pull-right">
									<span class="td-pg-price-label">Starting From</span>
									<span class="td-pg-price">Rs. {{ ( $post!==false ) ? $post[0]['price'] : '' }}</span>
								</div>
							</div>
							<div class="td-pg-details">
								<div class="td-pg-seller"><p><strong>Seller: </strong>Trippoo</p></div>
								<div class="td-pg-stay"><p><strong><span class="fa fa-clock-o"></span> </strong><?php $day = ( $post!==false ) ? $post[0]['days'] : '';
											echo ($day >= 1) ? $day.' day' : $day.' days'; ?></p></div>
							</div>
							<div class="td-tab td-tab-container">
								<ul>
									<li><a class="active" href="#">Photos</a></li>
									<li><a href="#detailed-itinerary">Detailed Itinerary</a></li>
									<li><a href="#overview">Overview</a></li>
									<li><a class="td-btn td-btn-log" href="booking.html?packageId=7883874">Book Now</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-3 td-book">
						<div class="td-button text-center td-left td-bg-white">
							<a class="td-btn td-btn-log" href="#">Book Now</a>
							<!-- <a class="td-btn td-btn-log" href="#"><span class="fa fa-heart-o"></span> Favourite</a> -->
						</div>
					</div>

					<div class="col-lg-9 td-bg-white td-pg-content">
						<!-- Package Nav -->
						<?php
							$imageData = array();
							$image_ids = ( $post!==false ) ? $post[0]['photos'] : '';
							$array = explode(' ', $image_ids);
							if( $array !== '' ) {
								for( $i =0; $i < count($array); $i++ ) {
									$imgdata = $media_model->get_image($array[$i], 'attachment');
									$imageData[$i] = ( $imgdata !== false ) ? $imgdata[0] : '' ;
								}
							}

							if( $imageData === '' ) {}
							else {?>
						<!-- Carousel -->
							<div class="td-pg-img-carousel">
								<div class="owl-carousel td-big-hm-carousel owl-theme">
						<?php	foreach( $imageData as $image ) {?>								
									<div class="item">
											<div class="td-img">
												<img src="{{ url('/public/'.$image['filename']) }}"  alt="{{ $image['title'] ?? $image['alt'] ?? 'Carousel image' }}">
											</div>
									</div>
						<?php 	} ?>
								</div>
							</div>
						<?php } ?>
						<!-- Carousel -->

						<!-- Itinerary -->
						<div id="detailed-itinerary">
							<div class="td-pg-dt-itinerary">							
								  <div class="page-header">
								    <h3>Detailed Day Wise Itinerary</h3>
								  </div>
								  <div class="timeline">
								  <?php echo ( $post!==false ) ? $post[0]['itinerary'] : 'Not found'; ?>
								  </div>
							</div>
						</div>
						<!-- Itinerary -->

						<!-- About -->
						<div id="overview">
							<div class="td-pg-about">
								<div class="page-header">
								    <h3>Overview</h3>
								</div>
								<?php echo ( $post!==false ) ? $post[0]['content'] : 'Not found'; ?>
							</div>
						</div>
					</div>
					<!-- About -->
					<div class="col-lg-3 td-book">
						<!-- <div class="td-left td-bg-white">
							<div class="td-ratings">
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="pull-right">5 Ratings</span>
							</div>
						</div> -->

						<div class="td-left td-bg-white">
							<div class="td-help">
								<div class="td-left-title text-center"><p>Need Help <span class="fa fa-question-circle"></span></p></div>
								<div class="td-text"><p>We would be more than happy to help you. Our team advisor are 24/7 at your service to help you.</p></div>
								<div class="td-phone"><p><span class="fa fa-phone"></span> 1-800-123-HELLO</p></div>
								<div class="td-email"><p><span class="fa fa-envelope"></span><a href="mail@help@trippoo.com">help@trippoo.com</a></p></div>
							</div>
						</div>

						<div class="td-left td-bg-white">
							<div class="td-why">
								<div class="td-left-title text-center"><p>Why Book with Us <span class="fa fa-question-circle"></span></p></div>
								<div class="td-text">
									<p><strong>Low Rates & Savings</strong></p>
									<p>Nunc cursus libero pur congue arut nimspnty.</p>
								</div>
								<div class="td-text">
									<p><strong>Excellent Support</strong></p>
									<p>Nunc cursus libero pur congue arut nimspnty.</p>
								</div>
								<div class="td-text">
									<p><strong>Low Rates & Savings</strong></p>
									<p>Nunc cursus libero pur congue arut nimspnty.</p>
								</div>
							</div>
						</div>

						<div class="td-left td-bg-white">
							<div class="td-similar">
								<div class="td-left-title text-center"><p>Similar Listings</p></div>
								<ul>
									<li>
										<span class="td-img"><img src=""></span>
										<span class="td-text"><p><a href="#">Shimla Package</a></p></span>
									</li>
									<li>
										<span class="td-img"><img src=""></span>
										<span class="td-text"><p><a href="#">Gangtok Beauty</a></p></span>
									</li>
									<li>
										<span class="td-img"><img src=""></span>
										<span class="td-text"><p><a href="#">Darjeeling Package</a></p></span>
									</li>
									<li>
										<span class="td-img"><img src=""></span>
										<span class="td-text"><p><a href="#">Ooty Tea Gardens</a></p></span>
									</li>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	@endsection

<?php } ?>