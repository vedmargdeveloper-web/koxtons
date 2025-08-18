@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">

    	<div class="col-md-12">
            <a title="Add Epin" href="{{ route('epin.create') }}"><span class="fas fa-credit-card"></span>+</a>
    		<div class="card">
                <div class="card-header">{{ __('Epins') }}</div>

                <div class="card-body">
                	<table class="table table-bordered datatables">
                		<thead>
                			<tr>
                				<th>S.No.</th>
                                <th>Epin ID</th>
                                <th>Package</th>
                				<th>No. of Epin</th>
                				<th>Amount</th>
                				<th>Payment Mode</th>
                				<th>Payment Date</th>
                				<th>Remark</th>
                                <th>Status</th>
                                <th>Sent At</th>
                			</tr>
                		</thead>

                		<tbody>
                            <?php $epins = App\model\Epin::where('user_id', Auth::id())->orderby('id', 'DESC')->get(); ?>

                            @if( $epins && count( $epins ) > 0 )
                                @foreach( $epins as $key => $epin )
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ strtoupper($epin->epin_id) }}</td>
                                        <td>{{ $epin->package }}</td>
                                        <td>{{ $epin->epins }}</td>
                                        <td>{{ $epin->amount }}</td>
                                        <td>{{ $epin->payment_mode }}</td>
                                        <td>{{ $epin->payment_date }}</td>
                                        <td>{{ $epin->remark }}</td>
                                        <td>{{ $epin->status }}</td>
                                        <td>{{ $epin->created_at->format('d M Y H:i') }}</td>
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