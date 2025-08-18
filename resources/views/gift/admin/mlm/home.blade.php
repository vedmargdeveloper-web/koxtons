@extends( 'gift.admin.mlm.app' )


@section('content')

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4">
			<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon">
								<span class="fas fa-credit-card"></span>
							</div>
							<div class="box-content">
								<div class="box-text"><a href="{{ route('mlm.epins') }}"> EPINs</a></div>
								<div class="box-number">{{ App\model\Epin::count() }}</div>
								<div class="small">Amount: {{ App\model\Epin::sum('amount') }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon">
								<span class="fas fa-users"></span>
							</div>
							<div class="box-content">
								<div class="box-text"><a href="{{ route('mlm.members') }}">Members</a></div>
								<div class="box-number">{{ App\User::where('role', 'member')->count() }}</div>
								<div class="direct-member small">Direct: {{ App\User::where(['ref_id' => null, 'role' => 'member'])->count() }}</div>

								<div class="reference-member small">Reference: {{ App\User::where('role', 'member')->where('ref_id', '!=', null)->count() }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon"></div>
							<div class="box-content">
								<div class="box-text"><a href="{{ route('mlm.wallet') }}">Wallet</a></div>
								<div class="small">Amount: {{ App\model\Wallet::sum('amount') }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon"></div>
							<div class="box-content">
								<div class="box-text"><a href="{{ route('mlm.cashbacks') }}">Cashback</a></div>
								<div class="box-number">
									{{ App\model\Membership::sum('amount') }}
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 mt-2">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon">
								<span class="fas fa-credit-card"></span>
							</div>
							<div class="box-content">
								<div class="box-text"><a href=""> Commission</a></div>
								<div class="box-number">Amount: {{ $am = App\model\Wallet::sum('joining_cashback') }}</div>
								<div class="small">Discount (15.95%): {{ $am * 15.95 / 100 }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 mt-2">
					<div class="box">
						<div class="box-inner">
							<div class="box-icon">
								<span class="fas fa-credit-card"></span>
							</div>
							<div class="box-content">
								<div class="box-text"><a href="{{ route('mlm.coupons') }}">Member Coupons</a></div>
								<div class="box-number">Amount: {{ App\model\MemberCoupon::sum('amount') }}</div>
								<div class="small">Member: {{ App\model\MemberCoupon::count() }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">

				<div class="col-md-6">
                    <div class="card o-hidden mb-4">

                        <?php 
                            $today = Carbon\Carbon::today();
                            $users = App\User::with('avtar')->where('role', 'member')->where('created_at', '>', $today->subDays(7))->get();
                        ?>
                        <div class="card-header d-flex align-items-center border-0">
                            <h5 class="w-40 float-left card-title m-0">New Members (Last Week)</h5>
                            <div class="dropdown dropleft text-right w-50 float-right">
                                <button class="btn bg-gray-100" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon i-Gear-2"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="#">Add new user</a>
                                    <a class="dropdown-item" href="#">View All users</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="user_table" class="table datatables">
                                    <thead>
                                        <tr>
                                            
                                            <th scope="col">Username</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Avatar</th>
                                            <th scope="col">Joined At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if( $users && count( $users ) )
                                            @foreach( $users as $key => $row )
                                                <tr>
                                                    
                                                    <td>{{ strtoupper($row->username) }}</td>
                                                    <td>{{ ucwords( $row->first_name.' '.$row->last_name ) }}</td>
                                                    <td>
                                                        <img class="rounded-circle m-0 avatar-sm-table lightbox zoomImage" src="{{ isset($row->avtar[0]->filename) ? asset('public/images/avtars/'.thumb($row->avtar[0]->filename,40,40)) : '' }}" data-src-lg="{{ isset($row->avtar[0]->filename) ? asset('public/images/avtars/'.$row->avtar[0]->filename) : '' }}" alt="">
                                                    </td>
                                                    <td>{{ $row->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        <a title="View" class="action-link" href="{{ route('mlm.member.view', $row->id) }}">
															<i class="nav-icon fas fa-eye"></i>
														</a> 
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


                <div class="col-lg-6">

                	<?php $epins = App\model\Epin::with('user')->where('status', 'pending')->where('created_at', '>', $today->subDays(7))->get(); ?>

                	<div class="card">
						<div class="card-header">
							<div class="card-title">Requested Epins (Last Week)</div>
						</div>
						<div class="card-body" style="overflow: auto;">
							@if( Session::has('epin_err') )
		                        <span class="text-warning">{{ Session::get('epin_err') }}</span>
		                    @endif
		                    @if( Session::has('epin_msg') )
		                        <span class="text-success">{{ Session::get('epin_msg') }}</span>
		                    @endif
							<table class="table table-bordered datatables">
								<thead>
									<tr>
										<th>Member</th>
										<th>Epin ID</th>
										<th>No. Of Epin</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if( $epins && count( $epins ) > 0 )
										@foreach( $epins as $key => $row )
											<tr>
												<td>
													<div>{{ isset($row->user[0]->username) ? strtoupper($row->user[0]->username) : '' }}</div>
													<ul class="action">
														<li><a href="{{ route('mlm.epin.edit', $row->id) }}">
															<span class="fa fa-edit"></span>
														</a></li>
													</ul>
												</td>
												<td>{{ strtoupper($row->epin_id) }}</td>
												<td>{{ $row->epins }}</td>
												<td>
													<select id="table-action" class="form-control">
														<option value="">Select</option>
														@if( $row->status === 'pending' )
															<option data-url="{{ route('mlm.epin.accept', $row->id) }}" value="accept">Accept</option>
														@endif
														<option data-url="{{ route('mlm.epin.view', $row->id) }}" value="view">View</option>
														<option data-url="{{ route('mlm.member.view', isset($row->user[0]->id) ? $row->user[0]->id : 0) }}" value="view-member">View Member</option>
														<option data-url="{{ route('mlm.epin.delete', $row->id) }}" value="delete">Delete</option>
														@if( $row->status !== 'pending' )
															<option data-url="{{ route('mlm.epin.reject', $row->id) }}" value="reject">Reject</option>
														@endif
													</select>
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


@endsection