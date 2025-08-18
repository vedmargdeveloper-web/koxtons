@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>

    </div>


    <div class="separator-breadcrumb border-top"></div>

    <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); ?>

    <div class="row">
        <!-- ICON BG -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Add-User"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Amount</p>
                        <p class="text-primary text-24 line-height-1 mb-2"> {{ $wallet ? $wallet->amount : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Financial"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Reference Earn</p>
                        <p class="text-primary text-24 line-height-1 mb-2">
                             {{ $wallet ? $wallet->relation()->sum('amount') : 0 }}
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
                            <i class="fas fa-users"></i> {{ App\User::where('ref_id', Auth::user()->username)->count() }}
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
                        <p class="text-muted mt-2 mb-0">Cashback</p>
                        <p class="text-primary text-24 line-height-1 mb-2">
                            {{ $wallet ? $wallet->salary_amount : 0 }}/m
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center login-card member-card mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Level Wise Earning') }}</div>

                <div class="card-body text-center">

               

                @if( $wallet )
        
                <?php $level[0] = $wallet->relation()->where('level', 'l1')->sum('amount'); ?>
                <?php $level[1] = $wallet->relation()->where('level', 'l2')->sum('amount'); ?>
                <?php $level[2] = $wallet->relation()->where('level', 'l3')->sum('amount'); ?>
                <?php $level[3] = $wallet->relation()->where('level', 'l4')->sum('amount'); ?>
                <?php $level[4] = $wallet->relation()->where('level', 'l5')->sum('amount'); ?>
                <?php $level[5] = $wallet->relation()->where('level', 'l6')->sum('amount'); ?>
                <?php $level[6] = $wallet->relation()->where('level', 'l7')->sum('amount'); ?>
                <?php $level[7] = $wallet->relation()->where('level', 'l8')->sum('amount'); ?>

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
    

    <?php $users = App\User::where('ref_id', Auth::user()->username)->get(); ?>

    <div class="row justify-content-center login-card member-card">

        @if( $users && count( $users ) > 0 && $wallet )

        	<div class="col-md-12">
        		<div class="card">
                    <div class="card-header">{{ __('Level Earning') }}</div>

                    <div class="card-body">
                    	<table class="table datatables table-bordered">
                    		<thead>
                    			<tr>
                    				<th>S.No.</th>
                    				<th>Username</th>
                    				<th>Level</th>
                    				<th>Name</th>
                    				<th>Amount</th>
                                    <th>Reference</th>
                    				<th>Joined At</th>
                    			</tr>
                    		</thead>

                    		<tbody>
                    			<?php $c = 0; ?>
                				@foreach( $wallet->relation()->get() as $rel )
                                
                                    <?php $user = App\User::where(['id' => $rel->user_id])->first(); ?>

                                    @if( $user )
                    					<tr>
                    						<td>{{ ++$c }}</td>
                    						<td>{{ strtoupper($user->username) }}</td>
                    						<td>{{ ucfirst( $rel->level ) }}</td>
                    						<td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
                    						<td>{{ $rel->amount }}</td>
                                            <td>{{ strtoupper($user->ref_id) }}</td>
                    						<td>{{ $user->created_at->format('d M Y') }}</td>
                    					</tr>
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

@endsection