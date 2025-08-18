@extends( admin_app() )


@section('content')

@if( Auth::user()->isAdmin() || Auth::user()->isEditor() )
		<div class="row mb-4">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
                     @if( Auth::user()->isAdmin() )
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<div class="box">
                            <a href="{{ route('product.index') }}">
    							<div class="box-inner">
    								<div class="box-icon">
    									<span class="fas fa-credit-card"></span>
    								</div>
    								<div class="box-content">
    									<div class="box-text">Products</div>
    									<div class="box-number">{{ App\model\Product::count() }}</div>
    								</div>
    							</div>
                            </a>
						</div>
					</div>

					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<div class="box">
                            <a href="{{ route('orders') }}">
    							<div class="box-inner">
    								<div class="box-icon">
    									<span class="fas fa-box"></span>
    								</div>
    								<div class="box-content">
    									<div class="box-text">Orders</div>
    									<div class="box-number">{{ App\model\Order::count() }}</div>
    								</div>
    							</div>
                            </a>
						</div>
					</div>
                    @endif
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="display: none;">
						<div class="box">
                            <a href="{{ route('admin.sellers') }}">
    							<div class="box-inner">
    								<div class="box-icon">
    									<span class="fas fa-users"></span>
    								</div>
    								<div class="box-content">
    									<div class="box-text">Sellers</div>
    									<div class="box-number">{{ App\User::where('role', 'seller')->count() }}</div>
    								</div>
    							</div>
                            </a>
						</div>
					</div>
                    @if( Auth::user()->isAdmin() )
    					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
    						<div class="box">
                                <a href="{{ route('admin.users') }}">
        							<div class="box-inner">
        								<div class="box-icon">
        									<span class="fas fa-users"></span>
        								</div>
        								<div class="box-content">
        									<div class="box-text">Customers</div>
        									<div class="box-number">{{ App\User::where('role', 'customer')->count() }}</div>
        								</div>
        							</div>
                                </a>
    						</div>
    					</div>
                    @endif

				</div>
			</div>
		</div>
@endif
@if( Auth::user()->isAdmin() || Auth::user()->isAccountant() )
		<div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card o-hidden mb-4">
                            <?php 
                                $today = Carbon\Carbon::today();
                                $orders = App\model\Order::with('invoice')->where('created_at', '>', $today->subDays(7))->orderBy('id','desc')->get();
                            ?>
                            <div class="card-header d-flex align-items-center border-0">
                                <div class="card-title" style="margin:0">Last week orders</div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="user_table" class="table datatables text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order no.</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Payment mode</th>
                                                <th scope="col">Payment status</th>
                                                <th scope="col">Phone no.</th>
                                                <th scope="col">Order at</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( $orders && count( $orders ) )
                                                @foreach( $orders as $key => $row )
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>
                                                        	<a href="{{ route('order.show', $row->id) }}">
                                                        		{{ $row->order_id }}
                                                        	</a>
                                                        </td>
                                                        <td><span class="fas fa-rupee-sign"></span> {{ $row->total_amount }}</td>
                                                        <td>
                                                            {{ strtoupper($row->payment_mode) }}
                                                        </td>
                                                        <td>
                                                            @if($row->payment_status==1)
                                                            Success
                                                            @endif
                                                            {{-- {{ ucfirst($row->payment_status) }} --}}
                                                        </td>
                                                        <td>{{ $row->mobile }}</td>
                                                        <td>{{ $row->created_at->format('d M, Y') }}</td>
                                                        <td>
                                                            @if( $row->invoice && count( $row->invoice ) > 0 )
                                                                <a href="{{ route('admin.invoice.view', $row->invoice[0]->id) }}">View Invoice</a>
                                                            @else
                                                                <a href="{{ route('admin.invoice.create', $row->id) }}">Generate Invoice</a>
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
                    </div>
                </div>

                <div class="row" style="display: none;">
                    <div class="col-md-12">
                        <div class="card o-hidden mb-4">
                            
                            <?php $orders = App\model\Order::with('invoice')->where('membership_amount', '!=', null)
                            							->where('membership_amount', '!=', 0)->get(); ?>

                            <div class="card-header d-flex align-items-center border-0">
                                <div class="card-title" style="margin:0">Orders with Membership Plan</div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="user_table" class="table datatables text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Order No.</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Membership Amount</th>
                                                <th scope="col">Phone no.</th>
                                                <th scope="col">Order At</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( $orders && count( $orders ) )
                                                @foreach( $orders as $key => $row )
                                                    <tr>
                                                        <th scope="row">{{ ++$key }}</th>
                                                        <td>
                                                        	<a href="{{ route('order.show', $row->id) }}">
                                                        		{{ $row->order_id }}
                                                        	</a>
                                                        </td>
                                                        <td><span class="fas fa-rupee-sign"></span> {{ $row->total_amount }}</td>
                                                        <td><span class="fas fa-rupee-sign"></span> {{ $row->membership_amount }}</td>
                                                        <td>{{ $row->mobile }}</td>
                                                        <td>{{ $row->created_at->format('d M, Y') }}</td>
                                                        <td>
                                                            @if( $row->invoice && count( $row->invoice ) > 0 )
                                                                <a href="{{ route('admin.invoice.view', $row->invoice[0]->id) }}">View Invoice</a>
                                                            @else
                                                                <a href="{{ route('admin.invoice.create', $row->id) }}">Generate Invoice</a>
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
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-12">
            	<?php $topProducts = App\model\OrderProduct::groupBy('product_id')->select('product_id')->limit(10)->get(); ?>

                <div class="card mb-4">
                    <div style="" class="card-body">
                        <div class="card-title">Top Selling Products</div>
                        @if( $topProducts && count( $topProducts ) > 0 )
                            @foreach( $topProducts as $pro )
                                <?php $product = App\model\Product::with('product_category')->where(['id' => $pro->product_id, 'status' => 'active'])->first(); ?>
                                @if( $product && isset($product->product_category[0]->slug) )
                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                        <img style="width:60px;" class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="{{ asset( 'public/'. product_file( thumb( $product->feature_image, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') ) ) ) }}" alt="">
                                        <div class="flex-grow-1">
                                            <?php $url = route('product.view',  [$product->product_category[0]->slug, $product->slug, $product->product_id]);
                                            ?>
                                            <h5 style="font-size:14px;"><a target="_blank" href="{{ $url }}">{{ $product->title }}</a></h5>
                                            <p class="text-small text-danger m-0" style="font-size:13px;">
                                                @if( $product->discount )
                                                    <span class="fas fa-rupee-sign"></span> 
                                                        {{ $product->price - ( $product->price * $product->discount / 100 ) }}
                                                @else
                                                    <span class="fas fa-rupee-sign"></span> 
                                                        {{ $product->price - ( $product->price * $product->discount / 100 ) }}
                                                    <del class="text-muted">
                                                        <span class="fas fa-rupee-sign"></span> 
                                                        {{ $product->mrp }}
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
           	</div>
        </div>
@endif


@endsection