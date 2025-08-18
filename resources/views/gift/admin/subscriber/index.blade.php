@extends( admin_app() )


@section('content')









<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $subscribers->count() }})</sub></h4>
		</div>
		<div class="card-body pt-4" style="overflow: auto;">

			@if( Session::has('mail_success') )
				<span class="text-success">{{ Session::get('mail_success') }}</span>
			@endif

            @if( $errors->has('order_not_found') )
                <span class="text-warning">{{ $errors->first('order_not_found') }}</span>
            @endif

            <div class="table-responsive">
                <table id="user_table" class="table datatables table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subscribed at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( $subscribers && count( $subscribers ) )
                            @foreach( $subscribers as $key => $row )
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->created_at->format('d M, Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

		</div>
	</div>
</div>

@endsection