@extends( admin_app() )

@section('content')

<div class="row">

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

		<div class="card">
			<div class="card-header">
				<h4>Edit Brand</h4>
				<a href="{{ route('brand.index') }}">Go back</a>
			</div>
			<div class="card-body pt-4">
				@if( $errors->has('brand_err') )
					<span class="text-warning">{{ $errors->first('brand_err') }}</span>
				@endif

				@if( session()->has('brand_msg') )
					<span class="text-success">{{ session()->get('brand_msg') }}</span>
				@endif

				@if( $brand )

				{{ Form::open(['url' => route('brand.update', $brand->id)]) }}
					{{ method_field('PATCH') }}

					<div class="form-group">
						<input type="text" name="name" placeholder="Brand name" class="form-control" value="{{ old('name') ? old('name') : $brand->name }}" autofocus>
						@if( $errors->has('name') )
							<span class="text-warning">{{ $errors->first('name') }}</span>
						@endif
					</div>

					<div class="form-group">
						<input type="text" name="slug" placeholder="Brand slug" class="form-control" value="{{ old('slug') ? old('slug') : $brand->slug }}" autofocus>
						@if( $errors->has('slug') )
							<span class="text-warning">{{ $errors->first('slug') }}</span>
						@endif
					</div>

					<div class="form-group">
						<textarea class="form-control" name="description" rows="5" placeholder="Description">{{ old('description') ? old('description') : $brand->description }}</textarea>
						@if( $errors->has('description') )
							<span class="text-warning">{{ $errors->first('description') }}</span>
						@endif
					</div>

					<div class="form-group">
						<input type="text" name="icon" placeholder="Icon" class="form-control" value="{{ old('icon') ? old('icon') : $brand->icon }}">
						@if( $errors->has('icon') )
							<span class="text-warning">{{ $errors->first('icon') }}</span>
						@endif
					</div>

					<div class="form-group">
						<input type="file" name="file">
						@if( $errors->has('file') )
							<span class="text-warning">{{ $errors->first('file') }}</span>
						@endif
					</div>

					<div class="form-group">
						<button class="btn btn-primary">Submit</button>
					</div>

				{{ Form::close() }}

			@endif

			</div>
		</div>
	</div>
</div>



@endsection