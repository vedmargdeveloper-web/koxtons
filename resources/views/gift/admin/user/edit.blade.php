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

								<a href="{{route('admin.user.create')}}"> <i class="fa fa-arrow-circle-left"></i> Add User</a>

								{!! Form::open( ['url' => route('admin.user.update',$user->id), 'files' => true] ) !!}

								<div class="form-group">
									<label>Name</label>
									<input type="text" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
									@endif
								</div>


								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" value="{{ old('email') ? old('email') : $user->email }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group">
									<label>Password</label>
									<input type="text" name="password" value="{{ old('password') ? old('password') : '' }}" class="form-control">
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
								</div>

								<div class="form-group" style="display: none;">
									<label>Role</label>
									<select class="form-control" name="role">
										<option value="editor" <?php if($user->role  =='editor'){echo 'selected';} ?> >Editor</option>
										<option value="accountant" <?php if($user->role  =='accounts'){echo 'selected';} ?> >Accounts</option>
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

									$array_key = array(
										'post.index',
										'post.create',
										'page.index',
										'page.create',
										'product.index',
										'product.create',
										'slide.index',
										'admin.reviews',
										'admin.complains',
										'category.index',
										'category.create',
										'orders',
										'admin.invoice',
										'ourclient.index'
									);


									$dd = json_decode($user->permission);
									$flag = 0;
								?>

								<div class="form-group">
									<label>Role Permission</label>
									<select class="form-control multi-selector" multiple name="permission[]">
										<option value="">--select--</option>
										@foreach($array as $key => $value)
											@if(isset($dd[$flag]))
												<option value="<?=$key?>" <?php if( $dd[$flag] == $key)echo "selected"; ?>  >{{$value}}</option>
											@else
													<option value="<?=$key?>" >{{$value}}</option>
											@endif
											<?php ++$flag; ?>
										@endforeach


									</select>
									@if( $errors->has('title') )
										<span class="text-danger">{{ $errors->first('role') }}</span>
									@endif
								</div>
								

								

								<button class="btn btn-primary" value="active" name="submit">Update</button>

								{!! Form::close() !!}

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