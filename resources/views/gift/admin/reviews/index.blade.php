@extends( admin_app() )


@section('content')


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $reviews->count() }})</sub></h4>
		</div>
		<div class="card-body pt-4" style="overflow: auto;">

			@if( Session::has('review_success') )
				<span class="label-warning">{{ Session::get('review_success') }}</span>
			@endif

			<table class="table table-bordered table-hover datatables">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Product ID</th>
						<th>Email</th>
						<th>Name</th>
						<th>Review</th>
						<th>Rating</th>
						<th>Created at</th>
						<th>Updated at</th>
					</tr>
				</thead>
				<tbody>
					
					@if( $reviews && count( $reviews ) > 0 )
						@foreach( $reviews as $key => $row )
							@if( $row->Product && count($row->Product) > 0 )
								<?php $category_slug =  isset($row->product[0]->product_category[0]->slug) ? $row->product[0]->product_category[0]->slug : ''; ?>
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										<div>{{ $row->product_id }}</div>
										<ul class="action">
											@if( $row->product->count() > 0 )
												<li><a href="{{ route('admin.product.review', $row->product[0]->id) }}">Review</a></li>
											@endif
											<li><a href="{{ url('/'.$category_slug.'/'.$row->product[0]->slug.'/'.$row->product[0]->product_id).'#comment-'.$row->id }}">View</a></li>
											<li>
												{{ Form::open(['url' => route('admin.review.delete', $row->id), 'method' => 'DELETE']) }}
													<button class="btn btn-default">Delete</button>
												{{ Form::close() }}
											</li>
										</ul>
									</td>
									<td>{{ $row->email }}</td>
									<td>{{ $row->name }}</td>
									<td>
										
										{{ $row->review }}
									</td>
									<td>{{ $row->rating }}</td>
									<td>{{ $row->created_at }}</td>
									<td>{{ $row->updated_at }}</td>
								</tr>
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection