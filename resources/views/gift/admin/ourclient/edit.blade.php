@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<span><a href="{{ route('ourclient.index') }}">Go back</a></span>
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

					{!! Form::open( ['url' => route('ourclient.update', $slide->id), 'files' => true] ) !!}
					{!! method_field('PATCH') !!}

					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" value="{{ old('title') ? old('title') : $slide->title }}" class="form-control">
						@if( $errors->has('title') )
							<span class="text-danger">{{ $errors->first('title') }}</span>
						@endif
					</div>


					<div class="form-group">
						<label>Image (File size must be less than 1MB & Image dimensions 1000x1000)</label>
						<input type="file" name="file">
						@if( $errors->has('file') )
							<span class="text-danger">{{ $errors->first('file') }}</span>
						@endif
						@if( $slide->image )
							<input type="hidden" name="filename" value="{{ $slide->image }}">
							<img src="{{ asset( 'public/' . public_file( thumb( $slide->image, 130, 140 ) ) ) }}"  alt="{{ $slide->title ?? 'Slide Image' }}">
						@endif
					</div>

					<button class="btn btn-primary" value="active" name="submit">Submit</button>
					<button class="btn btn-primary" value="inactive" name="draft">Draft</button>

					{!! Form::close() !!}

				@endif

			</div>

		</div>

	</div>

</div>


@endsection