@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		@if( $type === 'post' )
			<a href="{{ route('post.index') }}">Go back</a>
		@else
			<a href="{{ route('page.index') }}">Go back</a>
		@endif
	</div>
	<div class="card-block pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif

			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif

			@if( $type === 'post' )
				{{ Form::open(['url' => route('post.store'), 'files' => true]) }}
			@else
				{{ Form::open(['url' => route('page.store'), 'files' => true]) }}
			@endif
			<input type="hidden" name="type" value="{{ $type }}">
			<div class="form-container col-lg-12 col-md-12">
				<div class="row mb-2">

					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Title</label>
							<input type="text" placeholder="Title" name="title" value="{{ old('title') }}" class="form-control">
							@if( $errors->has('title') )
								<span class="label-warning">{{ $errors->first('title') }}</span>
							@endif
						</div>

						<div class="form-group">
							<label>Content</label>
							<textarea rows="8" placeholder="Content" name="content" class="form-control texteditor">{{ old('content') }}</textarea>
							@if( $errors->has('content') )
								<span class="label-warning">{{ $errors->first('content') }}</span>
							@endif
						</div>

						<div class="form-group">
							<label>Meta Title</label>
							<textarea rows="5" placeholder="Meta Title" name="metatitle" class="form-control">{{ old('metatitle') ? old('metatitle') : '' }}</textarea>
							@if( $errors->has('metatitle') )
								<span class="label-warning">{{ $errors->first('metatitle') }}</span>
							@endif
						</div>

						<div class="form-group" >
							<label>Meta Key</label>
							<textarea rows="5" placeholder="Meta Keys" name="metakey" class="form-control">{{ old('metakey') ? old('metakey') : '' }}</textarea>
							@if( $errors->has('metakey') )
								<span class="label-warning">{{ $errors->first('metakey') }}</span>
							@endif
						</div>

						<div class="form-group" >
							<label>Meta Description</label>
							<textarea rows="5" placeholder="Meta Description" name="metadescription" class="form-control">{{ old('metadescription') ? old('metadescription') : '' }}</textarea>
							@if( $errors->has('metadescription') )
								<span class="label-warning">{{ $errors->first('metadescription') }}</span>
							@endif
						</div>


					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<button name="publish" value="publish" class="btn btn-primary mr-2">Publish</button>
							<button name="draft" value="draft" class="btn btn-primary">Draft</button>
						</div>

						<div class="form-group mb-3" >
							<label>Category</label>
							<select name="category" class="form-control">
								<option value="">Select</option>
								@if( $categories && count($categories) )
									@foreach( $categories as $row )
										<option {{ old('category') === $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ ucfirst($row->name) }}</option>
									@endforeach
								@endif
							</select>
							@if( $errors->has('category') )
								<span class="label-warning">{{ $errors->first('category') }}</span>
							@endif
						</div>

						<div class="form-group">
							<label>Feature image</label>
							<input type="file" name="feature_image">
							@if( $errors->has('feature_image') )
								<span class="label-warning">{{ $errors->first('feature_image') }}</span>
							@endif
						</div>
						<div class="form-group">
							<label>Feature Image Alt</label>
							<input type="text" name="feature_image_alt" class="form-control">
							@if( $errors->has('feature_image_alt') )
								<span class="label-warning">{{ $errors->first('feature_image_alt') }}</span>
							@endif
						</div>
					</div>
				</div>
			</div>

			{{ Form::close() }}

		</div>
	</div>
</div>


@endsection