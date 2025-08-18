<div id="orderDetails" style="margin-top:2em; text-align:left;">

	{{ Form::open(['url' => route('order.return.store'), 'id' => 'orderComplainForm']) }}

		<?php $variation = json_decode( $order->order_products[0]->variations ); ?>
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<a href="{{ $variation->url }}">
					<img style="width:100%" src="{{ $variation->feature_image }}">
				</a>
			</div>
			<div class="col-lg-9 col-md-9">
				<h3><a href="{{ $variation->url }}">{{ $variation->title }}</a></h3>
				<p><i class="fa fa-inr"></i> {{ $order->total_amount }}</p>
				<p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
			</div>
			<input type="hidden" name="order_id" value="{{ $order->id }}">
			<input type="hidden" name="order_no" value="{{ $order->order_id }}">
		</div>


		<div class="row mt-3">
			<div class="col-lg-12 col-md-12 complain-type">
				<label>What do you want? *</label>

				<div class="simple-radio">
                    <p>
                        <input type="radio" id="change" value="change" name="return_type">
                        <label class="radio" for="change">Change</label>
                    <p>
               	</div>

				<div class="simple-radio">
                    <p>
                        <input type="radio" id="return" value="return" name="return_type">
                        <label class="radio" for="return">Return</label>
                    <p>
               	</div>
           
               	<div class="simple-radio">
                    <p>
                        <input type="radio" id="refund" value="refund" name="return_type">
                        <label class="radio" for="refund">Refund</label>
                    <p>
               	</div>
			</div>
		</div>

		<div class="customer-account-details" style="display:none;">
			<div class="row mt-3">
				<div class="col-lg-6 col-md-6">
					<label>Account holder Name *</label>
					<input type="text" name="acc_holder_name" value="" class="form-control">
				</div>
				<div class="col-lg-6 col-md-6">
					<label>Bank Name *</label>
					<input type="text" name="bank_name" value="" class="form-control">
				</div>

				<div class="col-lg-6 col-md-6">
					<label>Account No. *</label>
					<input type="text" name="account_no" value="" class="form-control">
				</div>
				<div class="col-lg-6 col-md-6">
					<label>IFSC code *</label>
					<input type="text" name="ifsc_code" value="" class="form-control">
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12 col-md-12">
				<label>What is the reason? *</label>
				<select name="reason" class="form-control">
					<option value="">Select option</option>
					<option value="damaged">It is damaged</option>
					<option value="defective">It is defective</option>
					<option value="broken">It is broken</option>
					<option value="unfit">It is not fit</option>
					<option value="unexpected">It is not as expected</option>
					<option value="less-goods">The goods is less</option>
					<option value="other">Other</option>
				</select>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12 col-md-12">
				<label>Please explain the reason *</label>
				<textarea class="form-control" rows="4" name="remark" placeholder=""></textarea>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12 col-md-12">
				<button class="btn btn-primary">Send</button>
				<span class="response-text"></span>
			</div>
		</div>


	{{ Form::close() }}

</div>