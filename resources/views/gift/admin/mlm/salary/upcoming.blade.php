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

                <?php $date = new Carbon\Carbon; ?>

                <?php $wallet = App\model\Wallet::where('salary_amount', '!=', null)
                						->where('created_at', '>', $date->subDays(7))->orderby('id', 'DESC')->get(); ?>


                <form class="">
                	<select name="" class="">
                		<option value="">Select</option>
                		<option value="11-15">11 to 15</option>
                		<option value="12-25">12 to 25</option>
                		<option value="01-05">01 to 05</option>
                	</select>
                </form>

				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Username</th>
							<th>Salary/month</th>
							<th>Started At</th>
							<th>Action</th>
							
						</tr>
					</thead>
					<tbody>

						@if( $wallet && count( $wallet ) > 0 )
							@foreach( $wallet as $key => $w )
								<?php $user = App\User::where('id', $w->user_id)->first(); ?>
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										@if( $user )
											<a href="{{ route('mlm.member.view', $user->id) }}" class="text-success mr-2">
											{{ strtoupper($user->username) }}</a>
										@endif
									</td>
									<td>{{ $w->salary_amount }}</td>
									<td>{{ App\model\Salary::where('member_id', $w->user_id)->value('created_at') }}</td>
									<td>
										<button class="btn btn-default">Pay</button>
										<button class="btn btn-default">Cancel</button>
									</td>
								</tr>
							@endforeach
						@endif
						
					</tbody>
				</table>

			</div>
		</div>
	</div>

@endsection