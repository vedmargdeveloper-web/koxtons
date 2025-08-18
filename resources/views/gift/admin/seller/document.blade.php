@extends( admin_app() )


@section('content')
	
	

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.sellers') }}"><span class="fa fa-angle-left"></span></a></li>
			</ol>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">Documents</div>
				</div>
				<div class="card-body">

					@if( $docs && count( $docs ) > 0 )
						
							<table class="table table-bordered">

								<tbody>
									
									@foreach( $docs as $key => $doc )
										<tr>
											<th>{{ ucfirst($doc->name) }}</th>
	                                        <td>
	                                            @if( $doc->filename )
	                                                <img id="signature" style="width: 100px;" class="img-thumbnail lightbox zoomImage" src="{{ asset('storage/app/public/'.$doc->filename) }}">
	                                            @else
	                                                <img id="avtar" class="img-thumbnail" src="http://placehold.it/150x150">
	                                            @endif
	                                        </td>
	                                        <td>
	                                        	{{ ucfirst($doc->status) }}
	                                        </td>
	                                        <td>
	                                        	{{ $doc->remark }}
	                                        </td>
	                                        <td>
	                                        	<?php if( $doc->status === 'reject' ) : ?>
		                                        	{{ Form::open(['url' => route('admin.seller.document.status')]) }}
		                                        		<input type="hidden" name="status" value="accept">
		                                        		<input type="hidden" name="doc_id" value="{{ $doc->id }}">
		                                        		<input type="hidden" name="user_id" value="{{ $doc->user_id }}">
		                                        		<button class="btn btn-default">Accept</button>
		                                        	{{ Form::close() }}
		                                        <?php elseif( $doc->status === 'accept' ) : ?>
			                                        	<button data-id="{{ $doc->id }}" data-static="1" data-user-id="{{ $doc->user_id }}" class="btn btn-default btn-reject-doc">Reject</button>
		                                        <?php else : ?>
		                                        	{{ Form::open(['url' => route('admin.seller.document.status')]) }}
			                                        		<input type="hidden" name="status" value="accept">
			                                        		<input type="hidden" name="doc_id" value="{{ $doc->id }}">
			                                        		<input type="hidden" name="user_id" value="{{ $doc->user_id }}">
			                                        		<button class="btn btn-default">Accept</button>
			                                        	{{ Form::close() }} | 
			                                        	<button data-id="{{ $doc->id }}" data-static="1" data-user-id="{{ $doc->user_id }}" class="btn btn-default btn-reject-doc">Reject</button>
			                                    <?php endif; ?>
	                                        </td>
										</tr>
									@endforeach
									
								</tbody>
							</table>

					@else
						<span>No details found!</span>
					@endif
				</div>
			</div>
		</div>



	@if( $errors && count($errors) > 0 )
		<script type="text/javascript">
			$('#docRejectModal').modal({
				show: true,
				backdrop: 'static',
				keyboard: false
		    });
		</script>
	@endif

	<!-- Modal -->
	<div class="modal fade" id="docRejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Reject Document</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        {{ Form::open(['url' => route('admin.seller.document.status'), 'id' => 'docRejectForm']) }}
        		<input type="hidden" name="status" value="reject">
        		<input type="hidden" name="doc_id" value="">
        		<input type="hidden" name="user_id" value="">
        		<div class="form-group">
        			<label>Remark</label>
        			<textarea class="form-control" rows="4" name="remark"></textarea>
        		</div>
        		<button class="btn btn-default">Submit</button>
        	{{ Form::close() }}
	      </div>
	      <div class="modal-footer">
	      </div>
	    </div>
	  </div>
	</div>

@endsection