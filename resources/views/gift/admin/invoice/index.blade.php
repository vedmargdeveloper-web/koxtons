@extends( admin_app() )

@section('content')

<?php $invoices = App\model\Invoice::with('orders')->orderby('id', 'DESC')->get(); ?>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ isset($title) ? $title : '' }} <sub>({{ $invoices->count() }})</sub></h4>
			</div>
			<div class="card-body pt-4" style="overflow: auto;">
				

				@if( $errors->has('invoice_not_found') )
					<span class="text-warning">{{ $errors->first('invoice_not_found') }}</span>
				@endif
				@if( $errors->has('invoice_msg') )
					<span class="text-success">{{ $errors->first('invoice_msg') }}</span>
				@endif

				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th>#</th>
							<th>Invoice No.</th>
							<th>Order No.</th>
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>

					@if( $invoices && count( $invoices ) > 0 )
						<tbody>
							@foreach( $invoices as $key => $row )
								<tr>
									<td>{{ ++$key }}</td>
									<td>
										<a href="{{ route('admin.invoice.view', $row->id) }}">
											{{ $row->invoice_no }}
										</a>
									</td>
									<td>
										@if( $row->orders && count( $row->orders ) > 0 )
											<a href="{{ route('order.show', $row->orders[0]->id) }}">
	                                    		{{ $row->orders[0]->order_id }}
	                                    	</a>
										@endif
									</td>
									<td>{{ $row->created_at->format('d M, Y H:i:s') }}</td>
									<td>
										<a href="{{ route('admin.invoice.download', $row->id) }}" target="_blank">Download</a> | 
										{{ Form::open(['url' => route('admin.invoice.send')]) }}
											<input type="hidden" name="invoice_id" value="{{ $row->id }}">
											<button class="btn btn-default">Send</button>
										{{ Form::close() }} | 
										<a href="{{ route('admin.invoice.print', $row->id) }}"></a>
										<a href="{{ route('admin.invoice.download', $row->id) }}" target="_blank">Print</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					@endif
				</table>
			</div>
		</div>
	</div>

@endsection