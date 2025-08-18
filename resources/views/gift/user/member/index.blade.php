@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">

        <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); $walletHistory = false; ?>
        @if( $wallet )

            <?php $walletHistory = App\model\WalletRelation::where('wallet_id', $wallet->id)->get(); ?>
        <?php $labels = ['l1', 'l2', 'l3', 'l4', 'l5', 'l6', 'l7', 'l8']; ?>

        <div class="col-md-12 mb-4">
            <a title="Add Member" href="{{ route('member.create', 'create') }}"><span class="fas fa-user-plus"></span></a>
            <div class="card">
                <div class="card-header">{{ __('Level Cards') }}</div>

                <div class="card-body">
                    @if( $walletHistory && count( $walletHistory ) > 0 )
                        <div class="row">
                            @foreach( $labels as $key => $label )
                                <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                        <div class="card-body text-center">
                                            <i class="i-Add-User"></i>
                                            <div class="content">
                                                <p class="text-muted mt-2 mb-0">
                                                    <a href="{{ route('user.member.level', $label) }}">Level {{ ++$key }}</a>
                                                </p>
                                                <p class="text-primary text-24 line-height-1 mb-2">
                                                    <i class="fas fa-users"></i> {{ $walletHistory->where('level', $label)->count() }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @endif


        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Level Wise Members') }}</div>

                <div class="card-body text-center">
                    
                    
                    @if( $walletHistory && count( $walletHistory ) > 0 )

                    
                    <?php $level[0] = $walletHistory->where('level', 'l1')->count(); ?>
                    <?php $level[1] = $walletHistory->where('level', 'l2')->count(); ?>
                    <?php $level[2] = $walletHistory->where('level', 'l3')->count(); ?>
                    <?php $level[3] = $walletHistory->where('level', 'l4')->count(); ?>
                    <?php $level[4] = $walletHistory->where('level', 'l5')->count(); ?>
                    <?php $level[5] = $walletHistory->where('level', 'l6')->count(); ?>
                    <?php $level[6] = $walletHistory->where('level', 'l7')->count(); ?>
                    <?php $level[7] = $walletHistory->where('level', 'l8')->count(); ?>
                    

                    <?php $level = json_encode($level); ?>
                    <?php $labels = json_encode($labels); ?>

                    <div id="canvas-holder" style="width:40%;display:inline-block;">
                        <canvas id="chart-area"></canvas>
                    </div>
                    <script>

                        var levels = JSON.parse( '<?php echo $level; ?>' );
                        var labels = JSON.parse( '<?php echo $labels; ?>' );
                        var blkstr = [];
                        $.each(levels, function(idx2,val) { 
                          blkstr.push(val);
                        });

                        var randomScalingFactor = function() {
                            return Math.round(Math.random() * 100);
                        };

                        var config = {
                            type: 'pie',
                            data: {
                                datasets: [{
                                    data: blkstr,
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


    	<div class="col-md-12">
    		<div class="card">
                <div class="card-header">{{ __('Members') }}</div>

                <div class="card-body">
                	<table class="table table-bordered datatables">
                		<thead>
                			<tr>
                				<th>S.No.</th>
                                <th>Reference</th>
                				<th>Level</th>
                				<th>Username</th>
                				<th>Name</th>
                				<th>Email</th>
                				<th>Joined At</th>
                                <th>Action</th>
                			</tr>
                		</thead>

                		<tbody>
                            <?php $users = App\User::where('ref_id', Auth::user()->username)->get(); ?>
                			<?php $c = 0; ?>
                            @if( $users && count( $users ) > 0 )
                				@foreach( $users as $key => $user )
                					<tr>
                						<td>{{ ++$c }}</td>
                                        <td>{{ strtoupper($user->ref_id) }}</td>
                						<td>{{ ucfirst( App\model\Level::where('user_id', $user->id)->value('level') ) }}</td>
                						<td>{{ strtoupper($user->username) }}</td>
                						<td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
                						<td>{{ $user->email }}</td>
                						<td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a class="action" href="{{ route('member.view', $user->id) }}"><span class="fas fa-eye"></span></a>
                                            
                                            <a class="action" href="{{ route('member.users', $user->username) }}"><span class="fas fa-users"></span></a>
                                        </td>
                					</tr>

                                    <?php $us = App\User::where('ref_id', $user->username)->get(); ?>
                                    @if( $us && count( $us ) > 0 )
                                        <?php $c = list_users( $us, $c ); ?>
                                    @endif

                				@endforeach
                            @else

                                <p>No details found!</p>
                            
                            @endif

                		</tbody>
                	</table>
              	</div>
            </div>
    	</div>
        

    </div>

@endsection