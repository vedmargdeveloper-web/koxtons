	@extends('layouts.header', ['request' => $request])

	@section('title', 'Explore the World')

	@section('main-class', 'td-home top-banner')

	@section('overlay-class', '')

	@section('search')

	<!-- <div class="td-search-container">
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
												<input type="text" placeholder="Search local" name="search" class="form-control input-field" id="search">
											</div>
											<div class="td-sr td-search-btn-holder">
												<button class="td-btn td-btn-search"><i class="fa fa-search"></i></button>
											</div>
										{{ Form::close() }}
										</div> -->
		
	@endsection

	@section('content')

	<section class="td-padding td-bg-gray td-section td-post-section">
			<div class="container">
				<div class="row">
				<?php
					$cat_id = 1;
					$category = $post_model->category_by_id( $cat_id );
					$catData = ( $category !== false ) ? $category[0] : '';
				?>
					<div class="col-lg-12">
					<?php
					/* Weekend package id */
						$postData = array();
						$i = 0;
						if( !isset( $post_model, $media_model ) ) {}
						else{							
							$post_ids = $post_model->get_post_ids_by_category( $cat_id );
							if( $post_ids === false ) {}
							else {
								foreach( $post_ids as $row ) {
									$post = $post_model->post_by_id( $row['post_id'] );
									$data = ($post !== false) ? $post[0] : '';
									$feature = $media_model->get_image( $data['featured_image'], 'featured_image' );
									$featured_image = ($feature !== false) ? $feature[0] : '';
									$postData[$i] = array_merge($data, $featured_image);
									$i++;
								}
							}
						}

						if( $postData === '' || $postData === false ){}
						else { 
							foreach( $postData as $row ) {
								$post_url = strtolower( url((($catData) ? clean($catData['slug']) : '').'/'.clean($row['slug'])) ).'?type='.strtolower(clean($catData['slug'])).'&id='.$row['id'].'&destination='.strtolower(clean($row['slug']));
							?>
							<div class="col-lg-3 td-col-3">
								<div class="td-ds-container">
									<div class="td-img">
										<a href="{{ $post_url }}">
											<img src="{{ url('public/'.$row['filename']) }}"   alt="{{ $row['title'] ?? 'Post image' }}">
										</a>
									</div>
									<div class="td-wrap">
										<div class="td-ds-name text-center">
											<h3><a href="{{ $post_url }}">{{ $row['title'] }}</a></h3>
										</div>
										<div class="td-ds-stay"><span class="fa fa-clock-o"></span> <span>{{ $row['days'] }} Days</span></div>
										<div class="td-ds-rate"><span>Rs. {{ $row['price'] }}</span></div>
										<div class="td-button text-center">
											<a class="td-btn td-btn-sm" href="{{ $post_url }}">View</a>
										</div>
									</div>
								</div>
							</div>
					<?php 	}
						} ?>
					</div>
				</div>
			</div>
	</section>
	@endsection