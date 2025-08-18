@extends( admin_app() )


@section('content')
	
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.sellers') }}"><span class="fa fa-angle-left"></span></a></li>
			</ol>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">User Details</div>
				</div>
				<div class="card-body">
					
					<table class="table table-bordered">
						
						<tbody>
							@if( $user )

								<tr>
									<th>Name</th>
									<td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
								</tr>

								<tr>
									<th>Email</th>
									<td>{{ $user->email }}</td>
								</tr>
								
								<tr>
                                    <th>Profile Pic</th>
                                    <td>
                                        @if( isset($user->avtar[0]->filename) )
	                                        
	                                            <img id="avtar" style="width: 100px;" class="img-thumbnail lightbox zoomImage" src="{{ asset('public/images/avtars/'.$user->avtar[0]->filename) }}">
	                                        
                                        @else
                                            <img id="avtar" class="img-thumbnail" src="http://placehold.it/150x150">
                                        @endif
                                    </td>
                                </tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>


			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">Contact Details</div>
				</div>
				<div class="card-body">

					@if( $user && $user->userdetail && count( $user->userdetail ) > 0 )
					
						<table class="table table-bordered">
							
							<tbody>

								<?php $userdetail = $user->userdetail[0]; ?>

								<tr>
									<th>Country</th>
									<td>{{ App\model\Country::where('id', $userdetail->country)->value('name') }}</td>
								</tr>
								<tr>
									<th>State</th>
									<td>{{ App\model\State::where('id', $userdetail->state)->value('name') }}</td>
								</tr>
								<tr>
									<th>City</th>
									<td>{{ App\model\City::where('id', $userdetail->city)->value('name') }}</td>
								</tr>
								<tr>
									<th>Address</th>
									<td>{{ $userdetail->address }}</td>
								</tr>
								<tr>
									<th>Landmark</th>
									<td>{{ $userdetail->landmark }}</td>
								</tr>
								<tr>
									<th>Mobile No.</th>
									<td>{{ $userdetail->phonecode.' '.$userdetail->mobile }}</td>
								</tr>
							
							</tbody>

						</table>

					@else

						<span>No Details</span>

					@endif
				</div>
			</div>

		</div>


		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">Bank Details</div>
				</div>
				<div class="card-body">

					@if( $user && $user->userdetail && count( $user->userdetail ) > 0 )
					
						<table class="table table-bordered">
							
							<tbody>

								<?php $userdetail = $user->userdetail[0]; ?>

								<tr>
									<th>Account Holder Name</th>
									<td>{{ $userdetail->account_holder_name }}</td>
								</tr>
								<tr>
									<th>Bank Name</th>
									<td>{{ $userdetail->bank_name }}</td>
								</tr>
								<tr>
									<th>Account No.</th>
									<td>{{ $userdetail->account_no }}</td>
								</tr>
								<tr>
									<th>IFSC Code</th>
									<td>{{ $userdetail->bank_ifsc }}</td>
								</tr>
								<tr>
									<th>Bank Address</th>
									<td>{{ $userdetail->bank_address }}</td>
								</tr>
								
							</tbody>

						</table>

					@else

						<p>No Details</p>

					@endif

				</div>
			</div>


			<div class="card mb-3">
				<div class="card-header">
					<div class="card-title">Documents</div>
					@if( $user )
					<a href="{{ route('admin.seller.view.document', $user->id) }}">
						<span class="fa fa-eye"></span>
					</a>
					@endif
				</div>
				<div class="card-body">

					@if( $user && $user->document && count( $user->document ) > 0 )
						
							<table class="table table-bordered">

								<tbody>
									
									@foreach( $user->document as $key => $doc )
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
	                                        	{{ $doc->status }}
	                                        </td>
	                                        <td>
	                                        	{{ $doc->remark }}
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


	</div>		

@endsection