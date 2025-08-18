@extends( admin_app() )

@section('content')

	<?php $users = App\User::with(['userdetail', 'products'])->where('role', 'seller')
										->orderby('id', 'DESC')->get(); ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="card">
				<div class="card-header">
					<h4>{{ isset($title) ? $title : '' }} <sub>({{ $users->count() }})</sub></h4>
					<span><a href="{{ route('admin.seller.create') }}">Create</a></span>
				</div>
				<div class="card-body pt-4" style="overflow: auto;">

					@if( Session::has('seller_err') )
                        <span class="text-warning">{{ Session::get('seller_err') }}</span>
                    @endif

                    @if( Session::has('seller_msg') )
                        <span class="text-success">{{ Session::get('seller_msg') }}</span>
                    @endif

                    @if( Session::has('message_msg') )
                        <span class="text-success">{{ Session::get('message_msg') }}</span>
                    @endif

					<table class="table table-bordered table-hover datatables">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Profile</th>
								<th>Document</th>
								<th>Products</th>
								<th>Status</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							@if( $users && count( $users ) )
								@foreach( $users as $key => $row )
								
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										<div><a href="{{ route('admin.seller.show', $row->id) }}">{{ ucwords($row->first_name.' '.$row->last_name) }}</a></div>
										<ul class="action">
											<li><a href="{{ route('admin.seller.show', $row->id) }}">
												<span class="fa fa-eye"></span></a></li>
											<li><a href="{{ route('admin.seller.edit', $row->id) }}">
												<span class="fa fa-edit"></span></a></li>
											<li><a href="{{ route('admin.seller.message', $row->id) }}">
												<span class="fa fa-comment-alt"></span></a></li>
										</ul>
									</td>
									<td>{{ strtoupper($row->username) }}</td>
									<td>{{ $row->email }}</td>
									<td>{{ ucfirst($row->profile) }}</td>
									<td>{{ ucfirst($row->doc_verify) }}</td>
									<td>
										<a href="{{ route('admin.seller.products', $row->id) }}">
											{{ $row->products->count() }}
										</a>
									</td>
									<td>{{ ucfirst($row->status) }}</td>
									<td>{{ $row->created_at }}</td>
									<td>
										@if( $row->status === 'active' )
											{{ Form::open(['url' => route('admin.seller.status', $row->id)]) }}
												{{ method_field('PATCH') }}
												<input type="hidden" name="status" value="inactive">
												<button title="Inactive" class="btn btn-default action-link">
													<span class="fa fa-ban"></span>
												</button>
											{{ Form::close() }}
										@else
											{{ Form::open(['url' => route('admin.seller.status', $row->id)]) }}
												{{ method_field('PATCH') }}
												<input type="hidden" name="status" value="active">
												<button title="Active" class="btn btn-default action-link">
													<span class="fas fa-snowboarding"></span>
												</button>
											{{ Form::close() }}
										@endif

										<a role="button" class="action-link message-popup-box"><i class="fa fa-comment-alt"></i></a>
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


@if( old('send') )
	<script type="text/javascript">
		$(document).ready(function() {
			$('#messageBoxModal').modal({
				show: true,
				backdrop: 'static',
				keyboard: false
		    });
		});	
	</script>
@endif


<!-- Modal -->
<div class="modal fade" id="messageBoxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Send Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => route('admin.message')]) }}
    		
    		<div class="form-group">
    			<select class="form-control multi-selector" name="user_ids[]" multiple>
    				@if( $users && count( $users ) )
						@foreach( $users as $key => $row )
    						<option value="{{ $row->id }}">{{ strtoupper($row->username).' ('. ucwords($row->first_name).')' }}</option>
    					@endforeach
    				@endif
    			</select>

    			@if( $errors->has('user_ids.*') )
    				<span class="text-warning">{{ $errors->get('user_ids.*') }}</span>
    			@endif
    		</div>
    		<div class="form-group">
    			<label>Remark</label>
    			<textarea class="form-control" rows="4" name="message" required></textarea>
    			@if( $errors->has('message') )
    				<span class="text-warning">{{ $errors->get('message') }}</span>
    			@endif
    		</div>
    		<button class="btn btn-primary" name="send">Send</button>
    	{{ Form::close() }}
      </div>
    </div>
  </div>
</div>


@endsection