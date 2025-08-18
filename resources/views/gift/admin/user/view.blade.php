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

							
					<div class="col-lg-8 col-md-8">
								<?php $user = App\User::with('userdetail')->where('id',$id)->first(); ?>

										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Name</th><td>{{$user->first_name}}</td>
												</tr>
												<tr>
													<th>Email</th><td>{{$user->email}}</td>
												</tr>
												<tr>
													<th>Role</th><td>{{$user->role}}</td>
												</tr>
												<tr>
													<th>Created at</th><td>{{$user->created_at}}</td>
												</tr>
											</thead>
										</table>
							</div>
							
						</div>
						<h3>History</h3>
						<?php $logs = App\model\LogsModel::with('users')->where('user_id', $id)->orderby('id', 'DESC')->get(); ?>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover datatables">
										<thead>
												<tr>
													<th>#</th>
													<th>User Name</th>
													<th>Remark</th>
													<th>Edit Type</th>
													<th>Worked on</th>
													<th>Created at</th>
												</tr>
											</thead>
											<tbody>
												
												@if( $logs && count( $logs ) )
													@foreach( $logs as $key => $row )
													<tr>
														<td>{{ ++$key }}</td>
														<td><div>{{ $row->users->first_name }}</div></td>
														<td>{{ $row->remark}}</td>
														<td>{{ ucfirst($row->status) }}</td>
														<?php if($row->status == 'post'): ?>
															<td><a href="{{ route('post.edit', $row->working_id) }}">View Post</a></td>
														<?php elseif($row->status == 'mainslider'): ?>
															<td><a href="{{ route('slide.edit', $row->working_id) }}">View Slider</a></td>

														<?php elseif($row->status == 'collection'): ?>
															<td><a href="{{ route('slide.edit', $row->working_id) }}">View Collection</a></td>

														<?php elseif($row->status == 'top-promo-banner'): ?>
															<td><a href="{{ route('slide.edit', $row->working_id) }}">View Promo Banner</a></td>

														<?php elseif($row->status == 'bottom-promo-banner'): ?>
															<td><a href="{{ route('slide.edit', $row->working_id) }}">View Promo Banner</a></td>

														<?php elseif($row->status == 'bottomslider'): ?>
															<td><a href="{{ route('slide.edit', $row->working_id) }}">View Bottom Slider</a></td>

														<?php elseif($row->status == 'OurClient'): ?>
															<td><a href="{{ route('ourclient.edit', $row->working_id) }}">view Client</a></td>

														<?php elseif($row->status == 'Catetory'): ?>
															<td><a href="{{ route('category.edit', $row->working_id) }}">view Category</a></td>

														<?php elseif($row->status == 'page'): ?>
															<td><a href="{{ route('page.edit', $row->working_id) }}">view Page</a></td>

														<?php elseif($row->status == 'post'): ?>
															<td><a href="{{ route('post.edit', $row->working_id) }}">view Post</a></td>

														<?php elseif($row->status == 'product'): ?>
															<td><a href="{{ route('product.edit', $row->working_id) }}">view Product</a></td>

														<?php else:?>
															<td>{{ ucfirst($row->working_id) }}</td>																
														<?php endif;?>


														<td>{{ $row->created_at }}</td>
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


@endsection