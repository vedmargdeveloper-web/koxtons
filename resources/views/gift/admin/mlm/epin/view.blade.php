@extends( 'gift.admin.mlm.app' )

@section('content')
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">Epin Details</div>
				</div>
				<div class="card-body">
                    @if( $epin )
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th>Package</th>
									<td>{{ $epin->package }}</td>
								</tr>
								<tr>
									<th>No of Epins</th>
									<td>{{ $epin->epins }}</td>
								</tr>
								<tr>
									<th>Amount</th>
									<td>{{ $epin->amount }}</td>
								</tr>
								<tr>
									<th>Payment mode</th>
									<td>{{ $epin->payment_mode }}</td>
								</tr>
								<tr>
									<th>Payment date</th>
									<td>{{ $epin->payment_date }}</td>
								</tr>
								<tr>
									<th>Remark</th>
									<td>{{ $epin->remark }}</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>{{ ucfirst($epin->status) }}</td>
								</tr>
							</tbody>
						</table>
					@else
						<span>No details found</span>
					@endif
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<div class="card-title">Epin Details</div>
				</div>
				<div class="card-body">
					@if( $epin->user && count( $epin->user ) > 0 )
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th>Username</th>
									<td><a href="{{ route('mlm.member.view', $epin->user[0]->id) }}">{{ strtoupper($epin->user[0]->username) }}</a></td>
								</tr>
								<tr>
									<th>Name</th>
									<td>{{ ucwords($epin->user[0]->first_name.' '.$epin->user[0]->last_name) }}</td>
								</tr>
							</tbody>
						</table>
					@endif
				</div>
			</div>

		</div>
	</div>


@endsection