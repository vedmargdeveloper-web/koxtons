@extends( admin_app() )


@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $orders->count() }})</sub></h4>
		</div>
		<div class="card-body pt-4" style="overflow: auto;">

			

			@if( Session::has('mail_success') )
				<span class="text-success">{{ Session::get('mail_success') }}</span>
			@endif

            @if( $errors->has('order_not_found') )
                <span class="text-warning">{{ $errors->first('order_not_found') }}</span>
            @endif

            <div class="table-responsive">
                <table id="user_table" class="table datatables text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order no.</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment mode</th>
                            <th scope="col">TXN ID</th>
                            <th scope="col">Payment status</th>
                            <th scope="col">Phone no.</th>
                            <th scope="col">GST no.</th>
                            <th scope="col">Order at</th>
                            <th>Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( $orders && count( $orders ) )
                            @foreach( $orders as $key => $row )
                            {{-- {{dd($row->payment->razorpay_order_id)}} --}}
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
                                        {{ $row->payment->razorpay_order_id ?? '' }}
                                    </td>
                                    <td>
                                        @if($row->payment_status==1)
                                        Sucess
                                        @else
                                        
                                        @endif
                                        {{-- {{ $row->payment_status }} --}}
                                    </td>
                                    <td>{{ $row->mobile }}</td>
                                    <td>{{ $row->gst_no }}</td>
                                    <td>{{ $row->created_at->format('d M, Y H:i:s') }}

                                                
                                                    
                                                </td>
                                    <td class="status-{{ $row->id }}">{{ ucfirst($row->order_status) }}</td>
                                    <td>
                                        <select name="actions" class="form-control order-action-control">
                                            <option value=""></option>
                                            <option data-id="{{ $row->id }}" value="delivered">Delivered</option>
                                            <option data-id="{{ $row->id }}" value="shipped">Shipped</option>
                                            <option data-id="{{ $row->id }}" value="pending">Pending</option>
                                            <option data-id="{{ $row->id }}" value="cancel">Cancel</option>
                                            @if( $row->invoice && count( $row->invoice ) > 0 )
                                                <option value="view-invoice" data-url="{{ route('admin.invoice.view', $row->invoice[0]->id) }}">View Invoice</option>
                                            @else
                                                <option value="generate-invoice" data-url="{{ route('admin.invoice.create', $row->id) }}">Generate Invoice</option>
                                            @endif
                                            <option data-id="{{ $row->id }}" value="delete">Delete</option>
                                        </select>
                                        
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


<!-- Modal -->
<div class="modal fade" id="orderRejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => route('admin.order.status'), 'id' => 'orderRejectForm']) }}
            <input type="hidden" name="status" value="cancelled">
            <input type="hidden" name="order_id" value="">
            <div class="form-group">
                <label>Remark</label>
                <textarea class="form-control" rows="4" name="remark"></textarea>
            </div>
            <button class="btn btn-primary">Submit</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="orderShippedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['url' => route('admin.order.status'), 'id' => 'orderShippedForm']) }}
            <input type="hidden" name="status" class="input-value-status" value="">
            <input type="hidden" name="order_id" value="">
            <div class="form-group">
                <label>Remark</label>
                <textarea class="form-control" rows="4" name="remark"></textarea>
            </div>
            <button class="btn btn-primary">Submit</button>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>


@endsection