@extends( 'gift.admin.mlm.app' )

@section('content')


	<div class="col-md-12">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb">
					<li><a title="Go back" href="{{ route('mlm.wallet') }}"><span class="fas fa-angle-left"></span></a></li>
				</ol>
			</div>
		</div>

	    <div class="row justify-content-center login-card member-card row-container">

	        @if( $payouts && count( $payouts ) > 0 )

	        	<div class="col-md-12">
	        		<div class="card">
	                    <div class="card-header">
	                    	<div class="card-title">{{ __($title) }}</div>
	                    </div>

	                    <div class="card-body">
	                    	<table class="table datatables table-bordered">
	                    		<thead>
	                    			<tr>
	                    				<th>S.No.</th>
	                                    <th>Amount</th>
	                    				<th>Remark</th>
	                    				<th>Status</th>
	                    				<th>Member</th>
	                    				<th>Response</th>
	                    				<th>Sent At</th>
	                    				<th>Action</th>
	                    			</tr>
	                    		</thead>

	                    		<tbody>
	                				@foreach( $payouts as $key => $row )
	                					<?php $member = App\User::where('id', $row->id)->first(); ?>
	                					<tr>
	                						<td>{{ ++$key }}</td>
	                                        <td>{{ $row->amount }}</td>
	                						<td>{{ $row->remark }}</td>
	                						<td>{{ ucfirst($row->status) }}</td>
	                						<td>
	                							@if( $member )
	                								<a href="{{ route('mlm.member.view', $row->id) }}">{{ strtoupper($member->username) }}</a>
	                							@endif
	                						</td>
	                						<td>{{ $row->response }}</td>
	                						<td>{{ $row->created_at->format('d M Y') }}</td>
	                						<td>	                							
	                							<button data-status="accept" data-url="{{ route('mlm.wallet.status', $row->id) }}" data-id="{{ $row->id }}" id="acceptPayoutRequest" class="btn btn-primary">Accept</button>
	                							<button data-url="{{ route('mlm.wallet.status', $row->id) }}" data-id="{{ $row->id }}" id="rejectPayoutBtn" class="btn btn-primary">Reject</button>

	                							
	                						</td>
	                					</tr>
	                				@endforeach
	                    		</tbody>
	                    	</table>
	                  	</div>
	                </div>
	        	</div>
	        @else

	            <p>No details found!</p>
	        
	        @endif

	    </div>

	</div>


	<div class="modal fade" id="rejectPayoutModal" tabindex="-1" role="dialog" aria-labelledby="rejectPayoutModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="rejectPayoutModalLabel">Modal title</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        {{ Form::open(['url' => '', 'id' => 'rejectPayoutRequest']) }}
				<input type="hidden" name="status" value="reject">
				<input type="hidden" name="id" value="">
				<div class="form-group">
					<textarea name="remark" class="form-control"></textarea>
				</div>
				<button class="btn btn-primary">Submit</button>
	        {{ Form::close() }}
	      </div>
	      <div class="modal-footer">
	      </div>
	    </div>
	  </div>
	</div>


@endsection