@extends( admin_app() )


@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row">
		<div class="card">
			<div class="card-header">
				<h4>{{ isset($title) ? $title : '' }} <sub>({{ $products->count() }})</sub></h4>
				<span class=""></span>
				<a href="{{ route('admin.sellers') }}"><i class="fa fa-angle-left"></i></a>
			</div>
			<div class="card-body pt-4" style="overflow: auto;">

				<table class="table table-bordered table-hover datatables">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Image</th>
							<th>Name</th>
							<th>Category</th>
							<th>Status</th>
							<th>Created at</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>

						@if( $products )

							@foreach( $products as $key => $row )

							<?php $category = $row->product_category && count($row->product_category) > 0 ? $row->product_category[0] : false; ?>
							<tr>
								<td>{{ ++$key }} <input type="checkbox" name="product_ids[]" value="{{ $row->id }}"></td>
								<td>
									<img class="img-thumbnail zoomImage" data-src-lg="{{ asset( 'public/'.product_file( $row->feature_image ) ) }}" src="{{ asset( 'public/'.product_file( thumb( $row->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') ) ) ) }}">
								</td>
								<td>
									<div><a href="{{ route('product.edit', $row->id) }}">{{ $row->title }}</a></div>
									<ul class="action">
										@if( $category )
										<li><a href="{{ url('/'.$category->slug.'/'.$row->slug.'/'.$row->product_id) }}">
											<i class="fa fa-eye"></i>
										</a></li>
										@endif
										<li>
											{!! Form::Open([ 'url' => route('product.destroy', $row->id), 'method' => 'DELETE' ]) !!}
												<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-default">
													<i class="fa fa-trash"></i></button>
											{!! Form::close() !!}
										</li>
										<li><a href="{{ route('product.edit', $row->id) }}">
											<i class="fa fa-edit"></i>
											</a></li>
									</ul>
								</td>
								<td>
									@if( $row->product_category && count($row->product_category) > 0 )
										@foreach( $row->product_category as $cat )
											<span>{{ ucfirst($cat->name) }}</span>, 
										@endforeach
									@endif
								</td>
								<td>{{ ucfirst($row->status) }}
									@if( $row->status === 'reject' )
										<div class="data-question-mark">
											<span class="fas fa-question"></span>
										</div>
										<div class="data-popup">
											<span class="close-popup"><i class="fa fa-times"></i></span>
											<span>{{ $row->remark }}</span>

										</div>
									@endif
								</td>
								<td>{{ $row->created_at }}</td>
								<th>
									<select name="actions" class="form-control action-control">
										<option value=""></option>
										@if( $row->status === 'active' )
											<option data-id="{{ $row->id }}" value="inactive">Inactive</option>
										@endif
										@if( $row->status === 'inactive' || $row->status === 'reject' )
											<option data-id="{{ $row->id }}" value="active">Active</option>
										@endif

										<option data-id="{{ $row->id }}" value="reject">Reject</option>
										<option value="select-all">Select All</option>
										<option value="unselect-all">unselect All</option>
										<option value="delete">Delete</option>
									</select>
								</th>
							</tr>

							@endforeach
						
						@endif
					
					</tbody>

				</table>

			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="productRejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Reject Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => route('admin.product.status'), 'id' => 'productRejectForm']) }}
    		<input type="hidden" name="status" value="reject">
    		<input type="hidden" name="product_id" value="">
    		<div class="form-group">
    			<label>Remark</label>
    			<textarea class="form-control" rows="4" name="remark"></textarea>
    		</div>
    		<button class="btn btn-primary">Submit</button>
    	{{ Form::close() }}
      </div>
    </div>
  </div>
</div>


@endsection