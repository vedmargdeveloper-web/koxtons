@extends( admin_app() )

@section('content')

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			<div class="card">
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


          <div class="row">

							<div class="col-lg-4 col-md-4">

								@if( Session::has('slide_msg') )
									<span class="label-success">{{ Session::get('slide_msg') }}</span>
								@endif

								@if( Session::has('slide_err') )
									<span class="label-warning">{{ Session::get('slide_err') }}</span>
								@endif

								{!! Form::open( ['url' => route('admin.user.store'), 'files' => true] ) !!}

								<div class="form-group">
									<label>Name</label>
									<input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
									@endif
								</div>


								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" value="{{ old('email') }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group">
									<label>Password</label>
									<input type="text" name="password" value="{{ old('password') }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
								</div>

								<div class="form-group" style="display: none;">
									<label>Role</label>
									<select class="form-control" name="role">
										<option value="editor">Editor</option>
										<option value="accountant">Accounts</option>
									</select>
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('role') }}</span>
									@endif
								</div>


								<?php
									$array = array(
										'post.index' => 'Post',
										'post.create' => 'Post Create',
										'page.index' => 'Page',
										'page.create' => 'Page Create',
										'product.index' => 'Product',
										'product.create' => 'Product Create',
										'slide.index' => 'Slide',
										'admin.reviews' => 'Reviews',
										'admin.complains' => 'Complains',
										'category.index' => 'Category',
										'category.create' => 'Category Create',
										'orders' => 'Orders',
										'admin.invoice' => 'Invoice',
										'ourclient.index' => 'Ourclient',
									);
								?>

								<div class="form-group">
									<label>Role Permission</label>
									<select class="form-control multi-selector" multiple name="permission[]">
										<option value="">--select--</option>
										@foreach($array as $key => $value)
											<option value="<?=$key?>">{{$value}}</option>
										@endforeach


									</select>
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('role') }}</span>
									@endif
								</div>
								

								

								<button class="btn btn-primary" value="active" name="submit">Submit</button>

								{!! Form::close() !!}

							</div>


							<div class="col-lg-8 col-md-8">
								<?php $users = App\User::with('userdetail')->where('role', 'accountant')->Orwhere('role','editor')->orderby('id', 'DESC')->get(); ?>

										<table class="table table-bordered table-hover datatables">
											<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Email</th>
										
													<th>Created at</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												
												@if( $users && count( $users ) )
													@foreach( $users as $key => $row )
													<tr>
														<td>{{ ++$key }}</td>
														<td><div>{{ ucwords($row->first_name.' '.$row->last_name) }}</div></td>
														<td>{{ $row->email }}</td>
													
														<td>{{ $row->created_at }}</td>
														<td>
															<a href="{{route('admin.user.edit',[$row->id])}}" class="action-link"><i class="fa fa-user-edit"></i></a>|
															<a href="{{route('admin.user.view',$row->id)}}" class="action-link"><i class="fa fa-eye"></i></a>

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




@endsection