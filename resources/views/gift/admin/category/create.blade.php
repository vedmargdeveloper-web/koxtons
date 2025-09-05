@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<a href="{{ route('category.index') }}"><i class="material-icons">arrow_back_ios</i></a>
	</div>
	<div class="card-block pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{{ Form::open(['url' => route('category.store'), 'files' => true]) }}
			<div class="form-horizontal">
				<div class="col-lg-6 col-md-6 float-left">
					@if( Session::has('cat_err') )
						<span class="label-warning">{{ Session::get('cat_err') }}</span>
					@endif

					@if( Session::has('cat_msg') )
						<span class="label-success">{{ Session::get('cat_msg') }}</span>
					@endif
			
					<div class="form-group">
						<label>Category name</label>
						<input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="">
						@if( $errors->has('name') )
							<span class="label-warning">{{ $errors->first('name') }}</span>
						@endif
					</div>
					<div class="form-group">
						<label>Parent</label>
						<select class="form-control search-select2" name="parent">
						<option value="">Select</option>

							<?php $category = App\model\Category::all(); ?>

							@if( $category )
								@foreach( $category as $row )
									<option value="{{ $row->id }}">{{ ucfirst($row->name) }}</option>
								@endforeach
							@endif
						</select>
						
						@if( $errors->has('parent') )
							<span class="label-warning">{{ $errors->first('parent') }}</span>
						@endif
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control tinyeditor" name="description" rows="5" placeholder="">{{ old('description') }}</textarea>
						@if( $errors->has('description') )
							<span class="label-warning">{{ $errors->first('description') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Meta Title</label>
						<textarea rows="5" placeholder="Meta Title" name="metatitle" class="form-control">{{ old('metatitle') ? old('metatitle') : '' }}</textarea>
						@if( $errors->has('metatitle') )
							<span class="label-warning">{{ $errors->first('metatitle') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Meta Key</label>
						<textarea rows="5" placeholder="Meta Keys" name="metakey" class="form-control">{{ old('metakey') ? old('metakey') : '' }}</textarea>
						@if( $errors->has('metakey') )
							<span class="label-warning">{{ $errors->first('metakey') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Meta Description</label>
						<textarea rows="5" placeholder="Meta Description" name="metadescription" class="form-control">{{ old('metadescription') ? old('metadescription') : '' }}</textarea>
						@if( $errors->has('metadescription') )
							<span class="label-warning">{{ $errors->first('metadescription') }}</span>
						@endif
					</div>


					
					
				</div>

				<div class="col-lg-6 col-md-6 float-left">
				
					<div class="form-group">
						<button class="btn btn-primary mr-4" name="save" value="active">Submit</button>
						<button class="btn btn-primary" name="draft" value="inactive">Draft</button>
					</div>

					<div class="form-group">
						<label>Feature image</label>
						<input type="file" name="image" class="form-control">
						@if( $errors->has('image') )
							<span class="label-warning">{{ $errors->first('image') }}</span>
						@endif
					</div>
					<div class="form-group">
						<label>Feature Image Alt</label>
						<input type="text" name="feature_image_alt" class="form-control">
						@if( $errors->has('feature_image_alt') )
							<span class="label-warning">{{ $errors->first('feature_image_alt') }}</span>
						@endif
					</div>
					

					<div class="form-group">
						<label>Select Order</label>
						<select class="form-control" name="order_by" data-placeholder="Select">
							<option value="latest">Latest</option>
							<option value="low_to_high">Low to High</option>
							<option value="high_to_low">High to Low</option>
						</select>
					</div>

					


				</div>
				
			</div>
			<input type="hidden" name="postmeta" value="">

			{{ Form::close() }}
		</div>
	</div>
</div>


@endsection