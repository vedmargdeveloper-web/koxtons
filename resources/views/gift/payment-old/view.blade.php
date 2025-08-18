@extends( _app() )

@section('content')

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    
    <!-- Page Content -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center">
                    <article class="post-8" style="display:inline-block;">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="display:inline-block;">

                            <div class="table-content" style="background:#f7f7f7;display:block;padding:20px;">

                                <div class="text-center">
                                    <h3>Order & Payment Info</h3>
                                </div>

                                @if( $payment )

                                    <?php if( $payment->order_status === 'Success' ) : ?>

                                        <p>Thank you for shopping with us. Your transaction is successful. We will be shipping your order to you soon.</p>

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <td>{{ $payment->order_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Order Status</th>
                                                    <td>Order has been placed successfully</td>
                                                </tr>
                                                <tr>
                                                    <th>TXN ID</th>
                                                    <td>{{ $payment->tid }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <td><span class="fa fa-inr"></span> {{ $payment->amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Status</th>
                                                    <td>{{ $payment->order_status }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status Message</th>
                                                    <td>{{ $payment->status_message }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    <?php else : ?>

                                        <p class="text-center">Your order did not place due to unsuccessful of the payment.</p>

                                    <?php endif; ?>

                                @else

                                    <p class="text-center">Your order did not place due to cancellation of the payment.</p>
                                    
                                @endif
                            </div>

                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection