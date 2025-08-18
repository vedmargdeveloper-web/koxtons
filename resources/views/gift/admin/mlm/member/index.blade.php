@extends( 'gift.admin.mlm.app' )

@section('content')


		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('mlm.member.create', 'create') }}"><span class="fas fa-user-plus"></span></a></li>
			</ol>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">{{ $title }}</div>
				</div>
				<div class="card-body">
					@if( Session::has('member_err') )
                        <span class="text-warning">{{ Session::get('member_err') }}</span>
                    @endif

                    @if( Session::has('member_msg') )
                        <span class="text-success">{{ Session::get('member_msg') }}</span>
                    @endif

                    @if( Session::has('message_msg') )
                        <span class="text-success">{{ Session::get('message_msg') }}</span>
                    @endif

					<table class="table table-bordered datatables">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Username</th>
								<th>Email</th>
								<th>Ref User</th>
								<th>Mobile No.</th>
								<th>Profile</th>
								<th>Document Verify</th>
								<th>Joined At</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if( $users && count( $users ) > 0 )
								@foreach( $users as $key => $row )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											<div>{{ strtoupper($row->username) }}</div>
											<ul class="action">
												
												<li>
													<a title="View" class="action-link" href="{{ route('mlm.member.view', $row->id) }}">
														<span class="fa fa-eye"></span>
													</a> 
												</li>
												<li>
													<a title="Edit" class="action-link" href="{{ route('mlm.member.edit', $row->id) }}">
														<span class="fa fa-edit"></span>
													</a> 
												</li>
												<li><a class="action-link" title="View messages" href="{{ route('admin.mlm.message', $row->id) }}">
												<span class="fa fa-comment-alt"></span></a></li>

												<li>
													{{ Form::open(['url' => route('mlm.member.delete', $row->id)]) }}
														{{ method_field('DELETE') }}
														<button onclick="return confirm('Are you sure?');" class="btn btn-default"><span class="fa fa-trash"></span></button>
													{{ Form::close() }}
												</li>
											</ul>
										</td>
										<td>{{ $row->email }}</td>
										<td>{{ strtoupper($row->ref_id) }}</td>
										<td>{{ isset($row->user_mobile[0]->mobile) ? $row->user_mobile[0]->mobile : '' }}</td>
										<td>{{ $row->profile }}</td>
										<td>
											<?php if( $row->profile === 'completed' && $row->doc_verify !== 'verified' ) : ?>
												<a href="{{ route('mlm.member.view.document', $row->id) }}">
												Verify Document</a>
											<?php elseif( $row->doc_verify === 'verified' ) : ?>
													Verified
											<?php endif; ?>
										</td>
										<td>{{ $row->created_at->format('d M, Y') }}</td>
										<td>
											@if( $row->status === 'active' )
												{{ Form::open(['url' => route('mlm.member.status', $row->id)]) }}
													{{ method_field('PATCH') }}
													<input type="hidden" name="status" value="inactive">
													<button title="Inactive" class="btn btn-default action-link">
														<span class="fa fa-ban"></span>
													</button>
												{{ Form::close() }}
											@else
												{{ Form::open(['url' => route('mlm.member.status', $row->id)]) }}
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
    			<input type="checkbox" id="all" name="all" value="1"> 
    			<label for="all">Send to All</label>
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