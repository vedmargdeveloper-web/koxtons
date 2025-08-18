@extends( admin_app() )

@section('content')

<?php $complains = App\model\Complain::orderby('id', 'DESC')->get(); ?>

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
							<th>Complain SRN</th>
							<th>Order No.</th>
							<th>Complain Date/Time</th>
							<th>Status</th>
							<th>Action Date/Time</th>
							<th>Action</th>
						</tr>
					</thead>

					@if( $complains && count( $complains ) > 0 )
						<tbody>
							@foreach( $complains as $key => $row )
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										<a href="{{ route('admin.complain.view', $row->id) }}">
											{{ $row->complain_no }}
										</a>
									</td>
									<td>
										<a href="{{ route('order.show', $row->order_id) }}">
	                                    	{{ $row->order_no }}
	                                    </a>
									</td>
									<td>{{ $row->created_at->format('d M, Y H:i:s') }}</td>
									<td>{{ ucwords($row->status) }}</td>
									<td>{{ $row->status ? $row->updated_at->format('d M, Y H:i:s') : '' }}</td>
									<td>
										<a class="btn btn-default btn-update-status" data-id="{{ $row->id }}" data-toggle="modal" href='#'>Update Status</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					@endif
				</table>
			</div>
		</div>
	</div>


@if( $errors && old('update') )

	<script type="text/javascript">
		$(document).ready(function() {
			$('#statusBoxModal').modal({
		      show: true,
		      backdrop: 'static',
		    })
		});
	</script>

@endif


<!-- Modal -->
<div class="modal fade" id="statusBoxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => route('admin.complain.update.status'), 'id' => 'complainStatusActionForm']) }}

        	<input type="hidden" name="complain_id" value="">
    		@if( $errors->has('error') )
    				<span class="text-warning">{{ $errors->get('error') }}</span>
    			@endif

    		<div class="form-group">
    			<select class="form-control" name="status" required>
    				<option value="">Select</option>
    				<option value="Reverse Pickup">Reverse Pickup</option>
    				<option value="Dispatched">Product Dispatched</option>
    				<option value="Delivered">Product Delivered</option>
    				<option value="Refunded">Amount Refunded</option>
    				<option value="Out of return time">Out of return time</option>
    				<option value="Currently out of stock">Currently out of stock</option>
    				<option value="Points refunded">Points refunded</option>
    				<option value="Closed">Close</option>
    			</select>

    			@if( $errors->has('status') )
    				<span class="text-warning">{{ $errors->get('status') }}</span>
    			@endif
    		</div>
    		<div class="form-group">
    			<label>Remark</label>
    			<textarea class="form-control" rows="4" name="message" required></textarea>
    			@if( $errors->has('message') )
    				<span class="text-warning">{{ $errors->get('message') }}</span>
    			@endif
    		</div>
    		<button class="btn btn-primary" name="update" value="1">update</button>
    	{{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@endsection