@extends( admin_app() )


@section('content')

<?php $slide = App\model\OurClient::orderby('id', 'DESC')->get(); ?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $slide->count() }})</sub></h4>
		</div>
		<div class="card-body pt-4">
			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif
			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif
			
			

			<div class="row">

			<div class="col-lg-4 col-md-4">

				@if( Session::has('slide_msg') )
					<span class="label-success">{{ Session::get('slide_msg') }}</span>
				@endif

				@if( Session::has('slide_err') )
					<span class="label-warning">{{ Session::get('slide_err') }}</span>
				@endif

				{!! Form::open( ['url' => route('ourclient.store'), 'files' => true] ) !!}

				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" value="{{ old('title') }}" class="form-control">
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
				</div>

				<button class="btn btn-primary" value="active" name="submit">Submit</button>
				<button class="btn btn-primary" value="inactive" name="draft">Draft</button>

				{!! Form::close() !!}

			</div>
			<div class="col-lg-8 col-md-8" style="overflow: auto;">
				<table class="table table-bordered table-hover datatables">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Title</th>
							<th>Image</th>
							<th>Status</th>
							<th>Created at</th>
						</tr>
					</thead>
					<tbody>
					@if( $slide && count( $slide ) )
						@foreach( $slide as $key => $row )
							<tr>
								<td>{{ ++$key }}</td>
								<td>
									<div>{{ ucfirst($row->title) }}</div>
									<ul class="action">
										<li><a href="{{ route('ourclient.edit', $row->id) }}">Edit</a></li>
										<li><span class="pipe"></span></li>
										<li>
										{!! Form::open(['method' => 'DELETE', 'route' => ['ourclient.destroy', $row->id] ]) !!}

		                            		{!! Form::submit('Delete', [
		                            					'onclick'=>"return confirm('Are you sure?')",
		                            					'class' => 'btn btn-danger'
		                            					]) 
		                            				!!}

		                            	{!! Form::close() !!}
										</li>
									</ul>
								</td>
								<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
								<td>{{ ucfirst($row->status) }}</td>
								<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>

			</div>

		</div>
	</div>
</div>

@endsection