	@extends('trippoo/admin/header', ['request' => $request])

	@section('title', 'Update')

	@section('content')

	<?php
		if( !isset( $post_model, $id, $media_model ) ) {
		}
		elseif( !valid_id( $id ) ) {
			echo '<span class="error-block">Package not found</span>';
		}
		else {
			$data = $post_model->post_by_id( $id );
			if( $data === false ) {
				echo '<span class="error-block">Package not found</span>';
			}
			else {
				$post = $data[0];
				$category = $post_model->get_category( $post['id'] );
				$feature = $media_model->get_image( $post['featured_image'], 'featured_image' );
				$post_id = (isset($_GET['id']) ? $_GET['id'] : '');
	?>

	<div class="td-right-head">
		<h2>Update</h2>
		@if( $request->session()->has('message') )
			<span class="error-block">
				{{ $message = $request->session()->get('message') }}
			</span>
		@endif
		<p><a href="{{ url()->previous() }}">Go Back</a></p>
	</div>
	{{ Form::open(['url' => url('/0/admin_/update?id='.$post_id.'&action=edit'), 'class'=>'form', 'role'=>'form', 'enctype'=>'multipart/form-data']) }}
	<div class="col-lg-9">
		<div class="td-container">
			<div class="td-right-body">
					<input type="hidden" name="prev_url" value="{{ current_url() }}">
					<input type="hidden" name="post_id" value="{{ $post_id }}">

					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" id="title" name="title" value="{{ urldecode( $post['title'] ) }}" class="form-control input-field" placeholder="Title" required="required">
						@if( $errors->has('title') )
							<span class="error-block">
								{{ $message = $errors->first('title') }}
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="content">content</label>
						<textarea name="content" id="content" class="form-control input-field content" required="required">{{ urldecode( $post['content'] ) }}</textarea>
						@if( $errors->has('content') )
							<span class="error-block">
								{{ $message = $errors->first('content') }}
							</span>
						@endif
					</div>
					<div class="form-group">
						<label for="content">Itinerary</label>
						<textarea name="itinerary" id="itinerary" class="form-control input-field itinerary" required="required">{{ urldecode( $post['itinerary'] ) }}</textarea>
						@if( $errors->has('itinerary') )
							<span class="error-block">
								{{ $message = $errors->first('itinerary') }}
							</span>
						@endif
					</div>
					<div class="col-lg-12 td-images">
						<h3>Add Photos</h3>						
						<hr>
						<div class="col-lg-3 td-file-upload">
							<div class="td-img-btn">
								<input type="file" name="files[]" id="imgupload" style="display:none"/>
								<span class="fa fa-picture-o"></span>
								<div class="td-img-overlay gallery">
									<span>Upload</span>
								</div>
							</div>
						</div>
						<?php
							$imageId = $post['photos'];
							$array = explode(' ', $imageId);
							for( $i = 0; $i < count($array); $i++ ) {
								$data = $media_model->get_image( $array[$i], 'attachment');
								if( $data!==false ) {?>
									<div class="col-lg-3">
										<div class="td-img-btn">
			                        		<div data-value="{{ $array[$i] }}" class="td-close-btn">
			                        			<span class="fa fa-close"></span>
			                        		</div>
			                        		<img id="image_upload_preview" src="{{ url('/public/'.$data[0]['filename'] ) }}">
			                        	</div>
			                        </div>
						<?php	}
							}
						?>
					</div>
					<input type="hidden" name="attachmentId" id="attachmentId" value="{{ $imageId }}">
			</div>
			<div class="td-right-bottom">

			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="td-right-section">
			<div class="td-btn-container">
				<button class="btn btn-primary pull-right">Update</button>
			</div>
			<div class="td-categories">
				<label>Categories</label>
				<select name="categories" class="form-control input-field" required="required">
					<option value=""></option>
				<?php 
						if( !isset( $post_model ) ){}
						else {
							$data = $post_model->categories();
							if( $data!==false ) {
								foreach( $data as $row ) {
									if( $row['id'] === (($category[0]['cat_id'] !== false) ? $category[0]['cat_id'] : '' ) ) {?>
										<option selected="selected" value="{{ strtolower( $row['id'] ) }}">{{ $row['name'] }}</option>
							<?php	} else{
									?>						
									<option value="{{ strtolower( $row['id'] ) }}">{{ $row['name'] }}</option>
					<?php			}
								}
							}
						}
					?>
				</select>
				@if( $errors->has('categories') )
					<span class="error-block">
						{{ $message = $errors->first('categories') }}
					</span>
				@endif
			</div>
			
			<div class="td-days">
				<div class="form-group">
					<label for="days">Days:</label>
					<input type="number" name="days" id="days" value="{{ $post['days'] }}" class="form-control input-field" min="0" required="required">
					@if( $errors->has('days') )
						<span class="error-block">
							{{ $message = $errors->first('days') }}
						</span>
					@endif
				</div>
			</div>
			<div class="td-price">
				<div class="form-group">
					<label for="price">Price:</label>
					<input type="number" name="price" id="price" value="{{ $post['price'] }}" class="form-control input-field" min="0" required="required">
					@if( $errors->has('price') )
						<span class="error-block">
							{{ $message = $errors->first('price') }}
						</span>
					@endif
				</div>
			</div>

			<div class="td-featured-image">
				<label>Featured Image</label>
				<div class="td-img-btn feature">
					<input type="file" name="files[]" id="featureimage" style="display:none"/>
					<input type="hidden" name="feature_image_id" id="feature_image_id" value="{{ $post['featured_image'] }}">
					<?php $file = (($feature!==false) ? url('/public/'.$feature[0]['filename']) : '' ); ?>
					<img id="td-show-feature-image" src="{{ $file }}">
					<div class="td-upload-icon <?php if( $file !== '' ) echo 'hide'; ?>">
						<span class="fa fa-picture-o"></span>
					</div>
					<div class="td-img-overlay feature">
						<?php if( $file !== '' )
								echo '<span>Change</span>';
							  else
								echo '<span>Upload</span>';
						?>
					</div>
				</div>
				@if( $errors->has('feature_image_id') )
					<span class="error-block">
						{{ $message = $errors->first('feature_image_id') }}
					</span>
				@endif
			</div>
		</div>
	</div>
	{{ Form::close() }}


<?php			}
			}
?>

	@endsection