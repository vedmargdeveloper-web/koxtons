@extends( 'gift.admin.mlm.app' )

@section('content')

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

                    <?php $wallet = App\model\Wallet::where('salary_amount', '!=', null)->orderby('id', 'DESC')->get(); ?>

					<table class="table table-bordered datatables">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Username</th>
								<th>Coupon Amount</th>
								<th>Used Amount</th>
								<th>Left Amount</th>
								<th>Received At</th>
								
							</tr>
						</thead>
						<tbody>
							<?php $cuopons = App\model\MemberCoupon::orderby('created_at', 'DESC')->get(); ?>

							@if( $cuopons && count( $cuopons ) > 0 )
								@foreach( $cuopons as $key => $cuopon )
									<?php $user = App\User::where('id', $cuopon->user_id)->first(); ?>
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											@if( $user )
												<a href="{{ route('mlm.member.view', $user->id) }}" class="text-success mr-2">
												{{ strtoupper($user->username) }}</a>
											@endif
										</td>
										<td>{{ $cuopon->amount }}</td>
										<td>{{ $cuopon->used_amount }}</td>
										<td>{{ $cuopon->left_amount }}</td>
										<td>{{ $cuopon->created_at }}</td>
									</tr>
								@endforeach
							@endif
							
						</tbody>
					</table>

				</div>
			</div>
		</div>

@endsection