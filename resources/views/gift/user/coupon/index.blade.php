@extends('gift.user.app.app')

@section('title', $title)

@section('content')


    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="row">

                <?php $coupon = App\model\MemberCoupon::where('user_id', Auth::id())->first(); ?>

                

                <div class="col-md-12">
                    <div class="card o-hidden mb-4">

                        <div class="card-header d-flex align-items-center border-0">
                            <h3 class="w-40 float-left card-title m-0">{{ _('Coupon Detail') }}</h3>
                        </div>

                        <div class="card-body">

                            @if( $coupon )

                                <p>You can use this coupon while shopping with us. It will be used 10 times, 10% each time.</p>

                                <div class="table-responsive">
                                    <table id="user_table" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Coupon</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Used Amount</th>
                                                <th scope="col">Left Amount</th>
                                                <th scope="col">Received At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $coupon->coupon }}</td>
                                                <td>{{ $coupon->amount }}</td>
                                                <td>{{ $coupon->used_amount }}</td>
                                                <td>{{ $coupon->left_amount }}</td>
                                                <td>{{ $coupon->created_at }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            @else

                                <p>Coupon detail not found!</p>

                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card o-hidden mb-4">

                        <div class="card-header d-flex align-items-center border-0">
                            <h3 class="w-40 float-left card-title m-0">{{ $title }}</h3>
                        </div>

                        <?php $history = App\model\MemberCouponHistory::where('user_id', Auth::id())->get(); ?>

                        <div class="card-body">

                            @if( $history && count( $history ) )

                                <div class="table-responsive">
                                    <table id="user_table" class="table datatables">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Used At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach( $history as $key => $row )
                                                <tr>
                                                    <th scope="row">{{ ++$key }}</th>
                                                    <td>{{ $row->amount }}</td>
                                                    <td>{{ $row->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No coupon usage history found!</p>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection