@extends('gift.user.app.app')

@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __($title) }}</div>

                <div class="card-body">
                    @if( $payouts && count( $payouts ) > 0 )
                        <table class="table datatables table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Amount</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Response</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach( $payouts as $key => $pay )
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td> {{ strtoupper($pay->amount) }}</td>
                                        <td>{{ $pay->remark }}</td>
                                        <td>{{ ucfirst($pay->status) }}</td>
                                        <td>{{ $pay->response }}</td>
                                        <td>{{ $pay->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No detail found!</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection