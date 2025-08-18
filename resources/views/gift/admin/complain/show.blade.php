@extends( admin_app() )

@section('content')

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ isset($title) ? $title : '' }}</h4>
				<a href="{{ route('admin.complains') }}">Go Back</a>
			</div>
			<div class="card-body pt-4" style="overflow: auto;">
				

				@if( $errors->has('invoice_not_found') )
					<span class="text-warning">{{ $errors->first('invoice_not_found') }}</span>
				@endif
				@if( $errors->has('invoice_msg') )
					<span class="text-success">{{ $errors->first('invoice_msg') }}</span>
				@endif

				<div class="row">

					@if( $complain )

						<div class="col-lg-6 col-md-6">

							<table class="table table-bordered">
								<tbody>
									<tr>
										<th>Complain No.</th>
										<td>{{ $complain->complain_no }}</td>
									</tr>

									<tr>
										<th>Order No.</th>
										<td>
											<a href="{{ route('order.show', $complain->order_id) }}">{{ $complain->order_no }}</a>
										</td>
									</tr>

									<tr>
										<th>Complain Type</th>
										<td>{{ ucfirst($complain->return_type) }}</td>
									</tr>

									<tr>
										<th>Reason</th>
										<td>{{ ucfirst($complain->reason) }}</td>
									</tr>

									<tr>
										<th>Message</th>
										<td>{{ $complain->message }}</td>
									</tr>

									<tr>
										<th>Complain Date</th>
										<td>{{ $complain->created_at->format('d M, Y H:i:s') }}</td>
									</tr>
								</tbody>
							</table>

						</div>

						<div class="col-lg-6 col-md-6">

							<h5>Complain Status</h5>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Message</th>
										<th>Status</th>
										<th>Updated At</th>
									</tr>
								</thead>

								<?php $statuses = App\model\ComplainStatus::where('complain_id', $complain->id)->orderby('id', 'DESC')->get(); ?>

								@if( $statuses && count( $statuses ) > 0 )

									@foreach( $statuses as $key => $status )

										<tr>
											<td>{{ ++$key }}</td>
											<td>{{ $status->message }}</td>
											<td>{{ ucwords($status->status) }}</td>
											<td>{{ $status->updated_at->format('d M, Y H:i:s') }}</td>
										</tr>

									@endforeach

								@endif

							</table>

						</div>

					@endif

				</div>

			</div>
		</div>
	</div>



@endsection