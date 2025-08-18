@extends( admin_app() )

@section('content')

<?php $complains = App\model\Contact::orderby('id', 'DESC')->get(); ?>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ isset($title) ? $title : '' }} <sub>({{ $complains->count() }})</sub></h4>
			</div>
			<div class="card-body pt-4" style="overflow: auto;">
				

				@if( Session::has('message') )
					<span class="text-success">{{ Session::get('message') }}</span>
				@endif

				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Subject</th>
							<th>Message</th>
							<th>Date</th>
						</tr>
					</thead>

					@if( $complains && count( $complains ) > 0 )
						<tbody>
							@foreach( $complains as $key => $row )
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										
											{{ $row->name }}
								
									</td>
									<td>
											{{ $row->email }}
									</td>
									<td>
											{{ $row->mobile }}
									</td>
									<td>
											{{ $row->subject }}
									</td>
										<td>
											{{ $row->message }}
									</td>
									<td>{{ $row->created_at->format('d M, Y H:i:s') }}</td>
									
								</tr>
							@endforeach
						</tbody>
					@endif
				</table>
			</div>
		</div>
	</div>




@endsection