@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>

    </div>


    <div class="separator-breadcrumb border-top"></div>


    <div class="row justify-content-center login-card member-card">

        @if( $users && count( $users ) > 0 )

            <div class="col-md-12 text-center" style="display: none;">
        
                <?php $level[0] = $users->where('member_level', 'l1')->count(); ?>
                <?php $level[1] = $users->where('member_level', 'l2')->count(); ?>
                <?php $level[2] = $users->where('member_level', 'l3')->count(); ?>
                <?php $level[3] = $users->where('member_level', 'l4')->count(); ?>
                <?php $level[4] = $users->where('member_level', 'l5')->count(); ?>
                <?php $level[5] = $users->where('member_level', 'l6')->count(); ?>
                <?php $level[6] = $users->where('member_level', 'l7')->count(); ?>
                <?php $level[7] = $users->where('member_level', 'l8')->count(); ?>

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


        	<div class="col-md-12">
                <a title="Add Member" href="{{ route('member.create', 'create') }}"><span class="fas fa-user-plus"></span></a>
        		<div class="card">
                    <div class="card-header">{{ __('Members') }}</div>

                    <div class="card-body">
                    	<table class="table datatables table-bordered">
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
                    			<?php $c = 0; ?>
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
                                        </td>
                					</tr>
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