@extends( 'gift.admin.mlm.app' )


@section('content')


	<?php $epins = App\model\Epin::with('user')->where(['status' => 'pending'])->get(); ?>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Epins</div>
				</div>
				<div class="card-body">
					@if( Session::has('epin_err') )
                        <span class="text-warning">{{ Session::get('epin_err') }}</span>
                    @endif

                    @if( Session::has('epin_msg') )
                        <span class="text-success">{{ Session::get('epin_msg') }}</span>
                    @endif
					<table class="table table-bordered datatables">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Member</th>
								<th>Package</th>
								<th>No. Of Epin</th>
								<th>Amount</th>
								<th>Payment Mode</th>
								<th>Payment Date</th>
								<th>Remark</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if( $epins && count( $epins ) > 0 )
								@foreach( $epins as $key => $row )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											<div>{{ isset($row->user[0]->username) ? strtoupper($row->user[0]->username) : '' }}</div>
										</td>
										<td>{{ $row->package }}</td>
										<td>{{ $row->epins }}</td>
										<td>{{ $row->amount }}</td>
										<td>{{ $row->payment_mode }}</td>
										<td>{{ $row->payment_date }}</td>
										<td>{{ $row->remark }}</td>
										<td>{{ ucfirst($row->status) }}</td>
										<td>
											<select id="table-action" class="form-control">
												<option value="">Select</option>
												@if( $row->status === 'pending' )
													<option data-url="{{ route('mlm.epin.accept', $row->id) }}" value="accept">Accept</option>
												@endif
												<option data-url="{{ route('mlm.epin.view', $row->id) }}" value="view">View</option>
												<option data-url="{{ route('mlm.member.view', isset($row->user[0]->id) ? $row->user[0]->id : 0) }}" value="view-member">View Member</option>
												<option data-url="{{ route('mlm.epin.delete', $row->id) }}" value="delete">Delete</option>
												@if( $row->status !== 'pending' )
													<option data-url="{{ route('mlm.epin.reject', $row->id) }}" value="reject">Reject</option>
												@endif
											</select>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
		

@endsection