@extends( admin_app() )


@section('content')



<div class="row">

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

		<div class="card">
			<div class="card-header">
				<h4>Add Brand</h4>
			</div>
			<div class="card-body pt-4">
				@if( $errors->has('brand_err') )
					<span class="text-warning">{{ $errors->first('brand_err') }}</span>
				@endif

				@if( session()->has('brand_msg') )
					<span class="text-success">{{ session()->get('brand_msg') }}</span>
				@endif

				{{ Form::open(['url' => route('brand.store')]) }}

					<div class="form-group">
						<input type="text" name="name" placeholder="Brand name" class="form-control" value="{{ old('name') }}" autofocus>
						@if( $errors->has('name') )
							<span class="text-warning">{{ $errors->first('name') }}</span>
						@endif
					</div>

					<div class="form-group">
						<textarea class="form-control" name="description" rows="3" placeholder="Description">{{ old('description') }}</textarea>
						@if( $errors->has('description') )
							<span class="text-warning">{{ $errors->first('description') }}</span>
						@endif
					</div>

					<div class="form-group">
						<input type="text" name="icon" placeholder="Icon" class="form-control" value="{{ old('icon') }}">
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
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

		<?php $brands = App\model\Brand::orderby('name', 'ASC')->get(); $c = 0; ?>

		<div class="card">
			<div class="card-header">
				<h4>{{ isset($title) ? $title : '' }} <sub>({{ $brands->count() }})</sub></h4>
			</div>
			<div class="card-body pt-4">
			
				@if( Session::has('cat_err') )
					<span class="label-warning">{{ Session::get('cat_err') }}</span>
				@endif
				@if( Session::has('cat_msg') )
					<span class="label-success">{{ Session::get('cat_msg') }}</span>
				@endif

				<table class="table table-hover table-bordered datatables">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Slug</th>
							<th>Description</th>
							<th>Created at</th>
						</tr>
					</thead>

					<tbody>
						
						

						@if( $brands )

							@foreach( $brands as $key => $row )
									<tr>
										<td>{{ ++$c }}</td>
										<td>
											<div>{{ ucfirst($row->name) }}</div>
											<ul class="action mt-2">
												<li>
													<a href="{{ route('brand.edit', $row->id) }}">
														<span class="material-icons">edit</span>
													</a>
												</li>
												<li>
												{{ Form::open(['url' => route('brand.destroy', $row->id)]) }}
													{{ method_field('DELETE') }}
													<button class="btn btn-default"><i class="material-icons">delete_forever</i></button>
												{{ Form::close() }}
												</li>
												<li>
													<a href=""><i class="material-icons">visibility</i></a>
												</li>
											</ul>
										</td>
										<td>{{ $row->slug }}</td>
										<td>{{ get_excerpt( $row->description, 10 ) }}</td>
										<td>{{ date('d M, Y', strtotime($row->created_at)) }}</td>
									</tr>

							@endforeach

						@endif

					</tbody>

					<tfoot>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Slug</th>
							<th>Description</th>
							<th>Created at</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>



@endsection