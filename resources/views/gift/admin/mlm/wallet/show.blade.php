@extends( 'gift.admin.mlm.app' )

@section('content')


	<div class="col-md-12">


		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb">
					<li><a title="Go back" href="{{ route('mlm.wallet') }}"><span class="fas fa-angle-left"></span></a></li>
				</ol>
			</div>
		</div>

	@if( $user )

	<?php $wallet =  count( $user->wallet ) > 0 ? $user->wallet : false; ?>

		<div class="row row-container">
	        <!-- ICON BG -->
	        <div class="col-lg-3 col-md-6 col-sm-6">
	            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
	                <div class="card-body text-center">
	                    <i class="i-Add-User"></i>
	                    <div class="content">
	                        <p class="text-muted mt-2 mb-0">Reference Points</p>
	                        <p class="text-primary text-24 line-height-1 mb-2">{{ $wallet ? $wallet[0]->amount : 0 }}</p>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-3 col-md-6 col-sm-6">
	            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
	                <div class="card-body text-center">
	                    <i class="i-Financial"></i>
	                    <div class="content">
	                        <p class="text-muted mt-2 mb-0">Membership Points</p>
	                        <p class="text-primary text-24 line-height-1 mb-2">
	                            <i class="fas fa-rupee-sign"></i> {{ $wallet ? $wallet[0]->membership_amount : 0 }}
	                        </p>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-3 col-md-6 col-sm-6">
	            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
	                <div class="card-body text-center">
	                    <i class="i-Checkout-Basket"></i>
	                    <div class="content">
	                        <p class="text-muted mt-2 mb-0">Members</p>
	                        <p class="text-primary text-24 line-height-1 mb-2">
	                            <i class="fas fa-users"></i> {{ App\User::where('parent_id', $user->id)->count() }}
	                        </p>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-3 col-md-6 col-sm-6">
	            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
	                <div class="card-body text-center">
	                    <i class="i-Money-2"></i>
	                    <div class="content">
	                        <p class="text-muted mt-2 mb-0">Salary</p>
	                        <p class="text-primary text-24 line-height-1 mb-2"></p>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>


	    <div class="row justify-content-center login-card member-card mb-4 row-container">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header">
	                	<div class="card-title">{{ __('Level Wise Earning') }}</div>
	                </div>

	                <div class="card-body text-center">

	               

	                @if( $wallet )
	        
	                <?php $level[0] = $wallet[0]->relation()->where('level', 'l1')->sum('amount'); ?>
	                <?php $level[1] = $wallet[0]->relation()->where('level', 'l2')->sum('amount'); ?>
	                <?php $level[2] = $wallet[0]->relation()->where('level', 'l3')->sum('amount'); ?>
	                <?php $level[3] = $wallet[0]->relation()->where('level', 'l4')->sum('amount'); ?>
	                <?php $level[4] = $wallet[0]->relation()->where('level', 'l5')->sum('amount'); ?>
	                <?php $level[5] = $wallet[0]->relation()->where('level', 'l6')->sum('amount'); ?>
	                <?php $level[6] = $wallet[0]->relation()->where('level', 'l7')->sum('amount'); ?>
	                <?php $level[7] = $wallet[0]->relation()->where('level', 'l8')->sum('amount'); ?>

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

	                @endif

	                </div>
	            </div>
	        </div>
	    </div>
	    

	    <?php $users = $user ? App\User::where('ref_id', $user->username)->get() : false; ?>

	    <div class="row justify-content-center login-card member-card row-container">

	        @if( $users && count( $users ) > 0 )

	        	<div class="col-md-12">
	        		<div class="card">
	                    <div class="card-header">
	                    	<div class="card-title">{{ __('Level Earning') }}</div>
	                    </div>

	                    <div class="card-body">
	                    	<table class="table datatable table-bordered">
	                    		<thead>
	                    			<tr>
	                    				<th>S.No.</th>
	                                    <th>Reference</th>
	                    				<th>Level</th>
	                    				<th>Username</th>
	                    				<th>Name</th>
	                    				<th>Amount</th>
	                    				<th>Joined At</th>
	                    			</tr>
	                    		</thead>

	                    		<tbody>
	                    			<?php $c = 0; ?>
	                				@foreach( $users as $key => $user )
	                                <?php $wall = App\model\WalletRelation::where('user_id', $user->id)->first(); ?>
	                					<tr>
	                						<td>{{ ++$c }}</td>
	                                        <td>{{ strtoupper($user->ref_id) }}</td>
	                						<td>{{ ucfirst( $wall ? $wall->level : '' ) }}</td>
	                						<td>{{ strtoupper($user->username) }}</td>
	                						<td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
	                						<td>{{ $wall ? $wall->amount : 0 }}</td>
	                						<td>{{ $user->created_at->format('d M Y') }}</td>
	                					</tr>

	                                    <?php $us = App\User::where('ref_id', $user->username)->get(); ?>
	                                    @if( $us && count( $us ) > 0 )
	                                        <?php $c = list_wallet_amount( $us, $c ); ?>
	                                    @endif

	                				@endforeach
	                    		</tbody>
	                    	</table>
	                  	</div>
	                </div>
	        	</div>
	        @else

	            <p>No details found!</p>
	        
	        @endif

	    </div>

	@endif

	</div>

@endsection