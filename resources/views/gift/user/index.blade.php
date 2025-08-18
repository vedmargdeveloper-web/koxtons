@extends('gift.user.app.app')

@section('title', $title)

@section('content')

            <div class="row mb-2">
                <div class="col-md-12 col-lg-12 col-xs-12">

                    <?php $docs = App\model\Document::where('user_id', Auth::id())->get(); ?>

                    @if( $docs && count( $docs ) > 0 )

                        <?php $status = $docs->where('status', 'reject')->first(); ?>
                        @if( $status )
                            <?php $error = false; ?>
                            <span class="text-warning">Your document verification failed, click here to <a href="{{ route('user.documents') }}">see</a></span>
                        @endif

                        <?php $signature = $docs->where('name', 'signature')->first(); ?>
                        <?php $aadhar = $docs->where('name', 'aadhar')->first(); ?>
                        <?php $pancard = $docs->where('name', 'pancard')->first(); ?>
                        <?php $passbook = $docs->where('name', 'passbook')->first(); ?>

                        @if( !$signature || !$aadhar || !$pancard || !$passbook )
                            <span class="text-warning">You have not uploaded all documents, click here to <a href="{{ route('user.documents') }}">upload</a></span>
                        @endif
                    @else
                        <span class="text-warning">You have not uploaded documents, click here to <a href="{{ route('user.documents') }}">upload</a></span>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0 text-24">
                                    <a href="{{ route('epins') }}">Epins Amount</a>
                                </p>
                                <p class="text-primary text-24 line-height-1 mb-2">
                                    <i class="fas fa-credit-card"></i>  {{ App\model\Epin::where('reference_id', Auth::id())->where('used_epins', '!=', 1)->sum('amount') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0 text-24">
                                    <a href="{{ route('member.network') }}">Members</a>
                                </p>
                                <p class="text-primary text-24 line-height-1 mb-2">
                                    <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); $walletHistory = false; ?>
                                    @if( $wallet )

                                        <i class="fas fa-users"></i> {{ App\model\WalletRelation::where('wallet_id', $wallet->id)->count() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); ?>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Checkout-Basket"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0 text-24">
                                    <a href="{{ route('user.point') }}">Points</a>
                                </p>
                                <p class="text-primary line-height-1 mb-2">Wallet: {{ $wallet ? $wallet->amount : 0 }}</p>
                                <p class="text-primary line-height-1 mb-2">Membership: {{ $wallet ? $wallet->membership_amount : 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Money-2"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0 text-24">
                                    <a href="{{ route('user.my.orders') }}">Orders</a>
                                </p>
                                <p class="text-primary text-24 line-height-1 mb-2">
                                    <i class="fab fa-first-order-alt"></i> 
                                    {{ App\model\Order::where('user_id', Auth::id())->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $coup = App\model\MemberCoupon::where('user_id', Auth::id())->first(); ?>
                @if( $coup )
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Money-2"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0 text-24">
                                    <a href="{{ route('user.coupon.history') }}">Coupon</a>
                                </p>
                                <p class="text-primary line-height-1 mb-2">
                                    Amount: 
                                    {{ $coup->amount }}
                                </p>
                                <p class="text-primary line-height-1 mb-2">
                                    Used: 
                                    {{ $coup->used_amount }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <div class="row mb-4" style="display: none;">
                <div style="width:75%;">
                    <canvas id="canvas"></canvas>
                </div>
    
    <script>
    var randomScalingFactor = function() {
        return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
    };

    var config = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.blue,
                fill: false,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Chart.js Line Chart - Logarithmic'
            },
            scales: {
                xAxes: [{
                    display: true,
                }],
                yAxes: [{
                    display: true,
                    type: 'logarithmic',
                }]
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
    };

    </script>
            </div>

            <!-- <div style="" class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">This Year Sales</div>
                            <div id="echartBar" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Sales by Countries</div>
                            <div id="echartPie" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-lg-8 col-md-12">

                    <!-- <div style="" class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card card-chart-bottom o-hidden mb-4">
                                <div class="card-body">
                                    <div class="text-muted">Last Month Sales</div>
                                    <p class="mb-4 text-primary text-24">$40250</p>
                                </div>
                                <div id="echart1" style="height: 260px;"></div>
                            </div>
                        </div>
                    
                        <div class="col-lg-6 col-md-12">
                            <div class="card card-chart-bottom o-hidden mb-4">
                                <div class="card-body">
                                    <div class="text-muted">Last Week Sales</div>
                                    <p class="mb-4 text-warning text-24">$10250</p>
                                </div>
                                <div id="echart2" style="height: 260px;"></div>
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card o-hidden mb-4">

                                <?php 

                                    $today = Carbon\Carbon::today();
                                    $users = App\User::with('avtar')->where('ref_id', Auth::user()->username)->where('created_at', '>', $today->subDays(7))->get();
                                ?>
                                <div class="card-header d-flex align-items-center border-0">
                                    <h3 class="w-40 float-left card-title m-0">New Members</h3>
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
                    </div>

                </div>


                <div class="col-lg-4 col-md-12">

                    <?php
                        $topProducts = App\model\OrderProduct::groupBy('product_id')->select('product_id')->limit(4)->get();
                    ?>

                    <div class="card mb-4">
                        <div style="" class="card-body">
                            <div class="card-title">Top Selling Products</div>
                            @if( $topProducts && count( $topProducts ) > 0 )
                                @foreach( $topProducts as $pro )
                                    <?php $product = App\model\Product::with('product_category')->where(['id' => $pro->product_id, 'status' => 'active'])->first(); ?>
                                    @if( $product && isset($product->product_category[0]->slug) )
                                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                            <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="{{ asset( 'public/'. product_file( thumb( $product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') ) ) ) }}" alt="">
                                            <div class="flex-grow-1">
                                                <?php $url = route('product.view',  [$product->product_category[0]->slug, $product->slug, $product->product_id]);
                                                ?>
                                                <h5><a target="_blank" href="{{ $url }}">{{ $product->title }}</a></h5>
                                                <p class="text-small text-danger m-0">
                                                    @if( $product->discount )
                                                        <span class="fas fa-rupee-sign"></span> 
                                                            {{ $product->price - ( $product->price * $product->discount / 100 ) }}
                                                    @else
                                                        <span class="fas fa-rupee-sign"></span> 
                                                            {{ $product->price - ( $product->price * $product->discount / 100 ) }}
                                                        <del class="text-muted">
                                                            <span class="fas fa-rupee-sign"></span> 
                                                            {{ $product->price }}
                                                        </del>
                                                    @endif
                                                 
                                                </p>
                                                    
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4" style="display: none;">
                        <div class="card-body p-0">
                            <div class="card-title border-bottom d-flex align-items-center m-0 p-3">
                                <span>User activity</span>
                                <span class="flex-grow-1"></span>
                                <span class="badge badge-pill badge-warning">Updated daily</span>
                            </div>
                            <div class="d-flex border-bottom justify-content-between p-3">
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Pages / Visit</span>
                                    <h5 class="m-0">2065</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">New user</span>
                                    <h5 class="m-0">465</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Last week</span>
                                    <h5 class="m-0">23456</h5>
                                </div>
                            </div>
                            <div class="d-flex border-bottom justify-content-between p-3">
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Pages / Visit</span>
                                    <h5 class="m-0">1829</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">New user</span>
                                    <h5 class="m-0">735</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Last week</span>
                                    <h5 class="m-0">92565</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3">
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Pages / Visit</span>
                                    <h5 class="m-0">3165</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">New user</span>
                                    <h5 class="m-0">165</h5>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-small text-muted">Last week</span>
                                    <h5 class="m-0">32165</h5>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-12" style="display: none;">
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <h5 class="card-title m-0 p-3">Last 20 Day Leads</h5>
                            <div id="echart3" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>

            </div>

            
        
@endsection
