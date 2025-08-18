@extends( _app() )

@section('title', $title)

@section('forsticky', 'forsticky gradient')

@section('content')

<?php  $order = $payment ? App\model\Order::find( $payment->order_id ) : false; ?>



      <div id="plans" class="standard-section section-white section-padding pb-5">
            <div class="container">
                  <div class="row">
                        <div class="col-md-3"></div>
                  	<div class="col-md-6 text-center">
                  		<div class="payment-box">
                  			<div class="payment-title text-center">
                  				@if( $payment )
                  					@if( $payment->status === 'success' )
                  						<h4>Payment successfully done!</h4>
                  						<p>Thank you for the purchasing.</p>
                  					@elseif( $payment->status === 'failed' )
                  						<h4>Payment was not successfully done!</h4>
                                                      <p>Your order could not be placed!</p>
                  					@elseif( $payment->status === 'cancelled' )
                  						<h4>Payment was cancelled!</h4>
                                                      <p>Your order could not be placed!</p>
                                                @elseif( $payment->payment_mode == 'cod' )
                                                      <h4>Order successfully placed!</h4>
                  					@endif
                  				@else
                  					<h4>Payment deails not found!</h4>
                  				@endif
                  			</div>
                  			
                  			<div class="payment-detail">
                  				<table class="table table-bordered">
                  					<tbody>

                                                      <tr>
                                                            <th>Order ID</th>
                                                            <td>{{ $order->order_id ?? ''}}</td>
                                                      </tr>
                  						<tr>
                  							<th>Amount</th>
                  							<td>Rs. {{ $payment->amount ??'' }}</td>
                  						</tr>
                                                      @if( $payment->payment_mode == 'cod' )
                                                            <tr>
                                                                  <th>Payment Mode</th>
                                                                  <td>Cash on Delivery</td>
                                                            </tr>
                                                            <tr>
                                                                  <th>Status</th>
                                                                  <td>
                                                                        <span class="badge badge-success">SUCCESS</span>
                                                                  </td>
                                                            </tr>
                                                      @else
                        						<tr>
                        							<th>Status</th>
                        							<td>
                        								@if( $payment->status === 'success' )
                        									<span class="badge badge-success">SUCCESS</span>
                        								@elseif( $payment->status === 'failed' )
                        									<span class="badge badge-warning">FAILED</span>
                        								@elseif( $payment->status === 'cancelled' )
                        									<span class="badge badge-danger">CANCELLED</span>
                        								@endif
                        							</td>
                        						</tr>
                        						<tr>
                        							<th>TXN no.</th>
                        							<td>{{ $payment->razorpay_payment_id }}</td>
                        						</tr>
                                                      @endif
                  					</tbody>
                  				</table>
                  			</div>

                  			
                  		</div>
                  	</div>
                  </div>
            </div>
   	</div>

@endsection