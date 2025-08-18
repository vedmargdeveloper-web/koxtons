@extends( admin_app() )


@section('content')

<?php $coupons = App\model\Coupon::orderby('id', 'DESC')->get(); ?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $coupons->count() }})</sub></h4>
			<a href="{{ route('coupon.create') }}">Create</a>
		</div>

		<div class="card-body">
		
			@if( Session::has('coupon_err') )
				<span class="label-warning">{{ Session::get('coupon_err') }}</span>
			@endif

			@if( Session::has('coupon_msg') )
				<span class="label-success">{{ Session::get('coupon_msg') }}</span>
			@endif

			<table class="table table-bordered table-hover datatables">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Code</th>
						<th>Start time</th>
						<th>End time</th>
						<th>Status</th>
						<th>Created time</th>
						<th>Updated time</th>
					</tr>
				</thead>

				<tbody>

				



				@if( $coupons )

					@foreach( $coupons as $key => $row )

						<tr>
							<td>{{ ++$key }}</td>
							<td style="width: 300px;">
								<div>{{ $row->code }}</div>
								<ul class="action">
									<li><a href="{{ route('coupon.show', $row->id) }}">View</a></li>
									<li><a href="{{ route('coupon.edit', $row->id) }}">Edit</a></li>
									<li>
										{!! Form::Open([ 'url' => route('coupon.destroy', $row->id), 'method' => 'DELETE' ]) !!}
											<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-primary">Delete</button>
										{!! Form::close() !!}
									</li>
									<li>
										{!! Form::Open([ 'url' => route('coupon.status', $row->id), 'method' => 'POST' ]) !!}
											<input type="hidden" name="status" value="{{ $row->status === 'active' ? 'inactive' : 'active' }}">
											<input type="hidden" name="id" value="{{ $row->id }}">
											<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-primary">{{ $row->status === 'active' ? 'Inactive' : 'Active' }}</button>
										{!! Form::close() !!}

									</li>
								</ul>
							</td>
							<td>{{ date('d M, Y H:i:s', strtotime($row->start) ) }}</td>
							<td>{{ date('d M, Y H:i:s', strtotime($row->end) ) }}</td>
							<td>{{ $row->status }}</td>
							<td>{{ date('d M, Y H:i:s', strtotime($row->created_at) ) }}</td>
							<td>{{ date('d M, Y H:i:s', strtotime($row->updated_at) ) }}</td>
						</tr>

					@endforeach

				@endif
					
				</tbody>

				<tfoot>
					<tr>
						<th>S.No.</th>
						<th>Code</th>
						<th>Start time</th>
						<th>End time</th>
						<th>Status</th>
						<th>Created time</th>
						<th>Updated time</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

@endsection