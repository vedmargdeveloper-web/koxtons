@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<span><a href="{{ route('slide.index') }}">Go back</a></span>
	</div>
	<div class="card-body pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif
			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif
		
				<div class="col-lg-6 col-md-6">

				@if( $slide )

					@if( Session::has('slide_msg') )
						<span class="label-success">{{ Session::get('slide_msg') }}</span>
					@endif

					@if( Session::has('slide_err') )
						<span class="label-warning">{{ Session::get('slide_err') }}</span>
					@endif

					{!! Form::open( ['url' => route('slide.update', $slide->id), 'files' => true] ) !!}
					{!! method_field('PATCH') !!}

					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" value="{{ old('title') ? old('title') : $slide->title }}" class="form-control">
						@if( $errors->has('title') )
							<span class="text-danger">{{ $errors->first('title') }}</span>
						@endif
					</div>

					<div class="form-group">
					<label>Type</label>
					<select name="type-1" class="form-control" style="display:none">
						<option value="mainslider" <?php if($slide->type =='mainslider')echo "selected"; ?> >Main Slider</option>
						<option value="collection" <?php if($slide->type =='collection')echo "selected"; ?> >Collection</option>
						<option value="top-promo-banner" <?php if($slide->type =='top-promo-banner')echo "selected"; ?> >Top Promo Banner</option>
						<option value="bottom-promo-banner" <?php if($slide->type =='bottom-promo-banner')echo "selected"; ?> >Bottom Promo Banner</option>
						<option value="bottomslider" <?php if($slide->type =='bottomslider')echo "selected"; ?> >Bottom Slider</option>
					</select>
					<input type="text" name="type" value="<?=$slide->type?>" readonly class="form-control">
					@if( $errors->has('title') )
						<span class="text-danger">{{ $errors->first('title') }}</span>
					@endif
				</div>

					<div class="form-group">
						<label>Button</label>
						<input type="text" placeholder="Text" value="{{ old('see_more') ? old('see_more') : $slide->see_more }}" name="see_more" class="form-control">
						@if( $errors->has('see_more') )
							<span class="text-danger">{{ $errors->first('see_more') }}</span>
						@endif
						<br>
						<input type="text" placeholder="Link" value="{{ old('see_more_more') ? old('see_more_link') : $slide->see_more_link }}" name="see_more_link" class="form-control">
						@if( $errors->has('see_more_link') )
							<span class="text-danger">{{ $errors->first('see_more_link') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" name="description" rows="3">{{ old('description') ? old('description') : $slide->description }}</textarea>
						@if( $errors->has('description') )
							<span class="text-danger">{{ $errors->first('description') }}</span>
						@endif
					</div>


					<div class="form-group">
						<label>Content Position</label><br>
						<?php $position = old('position') ? old('position') : $slide->position; ?>
						<input type="radio" {{ $position === 'left' ? 'checked' : '' }} value="left" name="position"> Left 
						<input type="radio" {{ $position === 'right' ? 'checked' : '' }} value="right" name="position"> Right 
						<input type="radio" {{ $position === 'center' ? 'checked' : '' }} value="center" name="position"> Center 
						@if( $errors->has('position') )<br>
							<span class="text-danger">{{ $errors->first('position') }}</span>
						@endif
					</div>

					@if($slide->type =='video')

						<div class="form-group">
							<label>Upload video( size must be under 6mb )</label>
							<input type="file" name="file">
							@if( $errors->has('file') )
								<span class="text-danger">{{ $errors->first('file') }}</span>
							@endif
							@if( $slide->image )
								<input type="hidden" name="filename" value="{{ $slide->image }}"><br>
								<a href="{{ asset( 'public/' . public_file( 'video/'.$slide->image ) ) }}">Uploaded Video Link</a>
							@endif
						</div>

					@else
						<div class="form-group">
							<input type="file" name="file">
							@if( $errors->has('file') )
								<span class="text-danger">{{ $errors->first('file') }}</span>
							@endif
							@if( $slide->image )
								<input type="hidden" name="filename" value="{{ $slide->image }}">
								<img src="{{ asset( 'public/' . public_file( thumb( $slide->image, 130, 140 ) ) ) }}" alt="{{ $slide->image_alt ??  $slide->title }}">
							@endif
						</div>
					@endif

					<div class="form-group">
						<label>Image Alt</label>
						<input class="form-control" name="image_alt" rows="3" value="{{ $slide->image_alt }}">
						@if( $errors->has('image_alt') )
							<span class="text-danger">{{ $errors->first('image_alt') }}</span>
						@endif
				   </div>
				   
					<button class="btn btn-primary" value="active" name="submit">Active</button>
					<button class="btn btn-primary" value="inactive" name="draft">Inactive</button>

					{!! Form::close() !!}

				@endif

			</div>

		</div>

	</div>

</div>


@endsection