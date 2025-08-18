<?php
	$title = '';
	$catData = '';
	if( !isset($post_model, $media_model, $param) ) {}
	else {
		$catData = $post_model->category_id_by_slug( $param );
		$title = ( $catData!==false ) ? $catData[0]['name'] : 'Not found';
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
	<section class="td-ds-weekend td-padding td-section td-post-section">
		<div class="container">
			<div id="book-now" class="row">
				
				<div class="col-lg-12">
				<?php
					$i=0;
					$postData = array();
					$cat_id = ( $catData !== false ) ? $catData[0]['id'] : '';
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
					
					if( $postData === '' || $postData === false ){}
					else {
						foreach( $postData as $row ) {
							$post_url = strtolower( url((($catData) ? clean($catData[0]['slug']) : '').'/'.clean($row['slug'])) ).'?type='.strtolower(clean($catData[0]['slug'])).'&id='.$row['id'].'&destination='.strtolower(clean($row['slug']));
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
			<?php 		}
					} ?>
					
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection

<?php } ?>