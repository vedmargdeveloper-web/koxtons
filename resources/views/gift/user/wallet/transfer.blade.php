@extends('gift.user.app.app')

@section('title', 'Withdraw Request')

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>Withdraw Request</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <?php $error = true; ?>
    <div class="text-center mb-2">
        <?php $docs = App\model\Document::where('user_id', Auth::id())->get(); ?>
        @if( $docs && count( $docs ) > 0 )
            <?php $status = $docs->where('status', 'reject')->first(); ?>
            @if( $status )
                <?php $error = false; ?>
                <span class="text-warning">Your document verification failed, click here to <a href="{{ route('user.documents') }}">see</a></span>
            @endif
            
            <?php $signature = $docs->where('name', 'signature')->first(); ?>
            <?php $aadhar = $docs->where('name', 'aadhar')->first(); ?>
            <?php $pancard = $docs->where('name', 'pancard')->first(); ?>
            <?php $passbook = $docs->where('name', 'passbook')->first(); ?>

            @if( !$signature || !$aadhar || !$pancard || !$passbook )
                <?php $error = false; ?>
                <span class="text-warning">You have not uploaded all documents, click here to <a href="{{ route('user.documents') }}">upload</a></span>
            @endif
        @else
            <?php $error = false; ?>
            <span class="text-warning">You have not uploaded documents, click here to <a href="{{ route('user.documents') }}">upload</a></span>
        @endif
    </div>


    <div class="row justify-content-center login-card">

        <div class="col-md-5">

            <div class="card">

                <div class="card-header">{{ __('Withdraw Request') }}</div>

                <div class="card-body">

                    @if( !$error )

                        <span class="text-warning">Your documents have a problem, please fix that problem then only you can request for payout, <a href="{{ route('user.documents') }}">click here</a></span>

                    @else

                        <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); ?>

                        @if( $wallet )

                            <form method="POST" action="{{ route('user.transfer.store') }}">
                                
                                {{ csrf_field() }}

                                @if( Session::has('req_err') )
                                    <span class="text-warning">{{ Session::get('req_err') }}</span>
                                @endif

                                @if( Session::has('req') )
                                    <span class="text-success">{{ Session::get('req') }}</span>
                                @endif

                                <div class="section-panel">

                                    <input type="hidden" name="step" value="create">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                            <label><strong>Total Amount:</strong> {{ $wallet->amount }}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                            <label> Amount *</label>
                                            <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="Amount" name="amount" value="{{ old('amount') }}" required autofocus>

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                            <label> Remark</label>
                                            <textarea name="remark" placeholder="Remark" class="form-control" rows="2">{{ old('remark') }}</textarea>

                                            @if ( $errors->has('remark') )
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('remark') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        @endif

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection