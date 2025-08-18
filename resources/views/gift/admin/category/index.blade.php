@extends( admin_app() )


@section('content')

<?php $categories = App\model\Category::all(); $c = 0; ?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $categories->count() }})</sub></h4>
			<a title="Add" href="{{ route('category.create') }}">
			<i class="material-icons">add_box</i></a>
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
						<th>Status</th>
						<th>Description</th>
						<th>Created at</th>
					</tr>
				</thead>

				<tbody>

					@if( $categories )

						@foreach( $categories as $key => $row )

							@if( !$row->parent )
								<tr>
									<td>{{ ++$c }}</td>
									<td>
										<div>{{ ucfirst($row->name) }}</div>
										<ul class="action mt-2">
											<li>
												<a href="{{ route('category.edit', $row->id) }}">
													<span class="material-icons">edit</span>
												</a>
											</li>
											<li>
											{{ Form::open(['url' => route('category.destroy', $row->id)]) }}
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
									<td>{{ ucwords($row->status) }}</td>
									<td>{{ get_excerpt( $row->description, 10 ) }}</td>
									<td>{{ date('d M, Y', strtotime($row->created_at)) }}</td>
								</tr>

								@foreach( $categories as $child )
									@if( $row->id == $child->parent )
										<tr>
											<td>{{ ++$c }}</td>
											<td>
												<div class="child-cat">{{ ucfirst($child->name) }}</div>
												<ul class="action mt-2">
													<li>
														<a href="{{ route('category.edit', $child->id) }}">
															<span class="material-icons">edit</span>
														</a>
													</li>
													<li>
													{{ Form::open(['url' => route('category.destroy', $child->id)]) }}
														{{ method_field('DELETE') }}
														<button class="btn btn-default"><i class="material-icons">delete_forever</i></button>
													{{ Form::close() }}
													</li>
													<li>
														<a href=""><i class="material-icons">visibility</i></a>
													</li>
												</ul>
											</td>
											<td>{{ $child->slug }}</td>
											<td>{{ ucwords($child->status) }}</td>
											<td>{{ get_excerpt( $child->description, 10 ) }}</td>
											<td>{{ date('d M, Y', strtotime($child->created_at)) }}</td>
										</tr>

									@endif
								@endforeach
							@endif

						@endforeach

					@endif

				</tbody>

				<tfoot>
					<tr>
						<th>S.No.</th>
						<th>Name</th>
						<th>Slug</th>
						<th>Status</th>
						<th>Description</th>
						<th>Created at</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

@endsection