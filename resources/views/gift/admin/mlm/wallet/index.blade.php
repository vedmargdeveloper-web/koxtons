@extends( 'gift.admin.mlm.app' )

@section('content')


		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('mlm.member.create', 'create') }}"><span class="fas fa-user-plus"></span></a></li>
			</ol>
		</div>


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
								<div class="box-text"></div>
								<div class="box-number"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">{{ __('Level Wise Earning') }}</div>

                <div class="card-body text-center">
	        
	                <?php $level[0] = App\model\WalletRelation::where('level', 'l1')->sum('amount'); ?>
	                <?php $level[1] = App\model\WalletRelation::where('level', 'l2')->sum('amount'); ?>
	                <?php $level[2] = App\model\WalletRelation::where('level', 'l3')->sum('amount'); ?>
	                <?php $level[3] = App\model\WalletRelation::where('level', 'l4')->sum('amount'); ?>
	                <?php $level[4] = App\model\WalletRelation::where('level', 'l5')->sum('amount'); ?>
	                <?php $level[5] = App\model\WalletRelation::where('level', 'l6')->sum('amount'); ?>
	                <?php $level[6] = App\model\WalletRelation::where('level', 'l7')->sum('amount'); ?>
	                <?php $level[7] = App\model\WalletRelation::where('level', 'l8')->sum('amount'); ?>

	                <?php $levels = json_encode($level); ?>

	                <div id="canvas-holder" style="width:40%;display:inline-block;">
	                    <canvas id="chart-area"></canvas>
	                </div>
	                <script>

	                    var level = JSON.parse( '<?php echo $levels; ?>' );
	                    
	                    var randomScalingFactor = function() {
	                        return Math.round(Math.random() * 100);
	                    };

	                    var config = {
	                        type: 'pie',
	                        data: {
	                            datasets: [{
	                                data: level,
	                                backgroundColor: [
	                                    window.chartColors.red,
	                                    window.chartColors.purple,
	                                    window.chartColors.orange,
	                                    window.chartColors.yellow,
	                                    window.chartColors.green,
	                                    window.chartColors.blue,
	                                    
	                                    window.chartColors.maroon,
	                                    window.chartColors.violet,
	                                ],
	                                label: 'Dataset 1'
	                            }],
	                            labels: [
	                                'L1',
	                                'L2',
	                                'L3',
	                                'L4',
	                                'L5',
	                                'L6',
	                                'L7',
	                                'L8'
	                            ]
	                        },
	                        options: {
	                            responsive: true
	                        }
	                    };

	                    window.onload = function() {
	                        var ctx = document.getElementById('chart-area').getContext('2d');
	                        window.myPie = new Chart(ctx, config);
	                    };
	                </script>

                </div>
            </div>
        </div>


		<?php $users = App\User::with('wallet.relation')->where('role', 'member')->orderby('id', 'DESC')->get(); ?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Members</div>
				</div>
				<div class="card-body">
					@if( Session::has('member_err') )
                        <span class="text-warning">{{ Session::get('member_err') }}</span>
                    @endif

                    @if( Session::has('member_msg') )
                        <span class="text-success">{{ Session::get('member_msg') }}</span>
                    @endif

					<table class="table table-bordered datatables">
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Ref User</th>
								<th>Level</th>
								<th>Wallet Points</th>
								<th>Membership Points</th>
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
											<a href="{{ route('mlm.member.view', $row->id) }}" class="text-success mr-2">
												{{ strtoupper($row->username) }}</a>
										</td>
										<td>{{ strtoupper($row->ref_id) }}</td>
										<td>
											@if( isset($row->wallet[0]->relation[0]->level) )
												{{ ucfirst($row->wallet[0]->relation[0]->level) }}
											@endif
										</td>
										<td>
											@if( count( $row->wallet ) > 0 )
												 {{ $row->wallet[0]->amount }}
											@endif
										</td>
										<td>
											@if( count( $row->wallet ) > 0 )
												 {{ $row->wallet[0]->membership_amount }}
											@endif
										</td>
										<td>{{ $row->created_at->format('d M, Y') }}</td>
										<td>
											<a title="View" class="action-link" href="{{ route('mlm.wallet.view', $row->id) }}">
												<span class="fa fa-eye"></span>
											</a> 
											<a title="Edit" class="action-link" href="{{ route('mlm.member.edit', $row->id) }}">
												<span class="fa fa-edit"></span>
											</a> 
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