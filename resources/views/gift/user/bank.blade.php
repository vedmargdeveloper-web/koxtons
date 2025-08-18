@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bank Details') }}</div>
                <div class="card-body">

                    <?php $userdetail = App\model\UserDetail::where('user_id', Auth::id())->first(); ?>

                    @if( session()->has('profile_msg') )
                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                    @endif

                    {{ Form::open(['url' => route('user.bank')]) }}

                        <div class="section-panel">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <?php 
                                        $bank_name = '';
                                        if( old('bank_name') )
                                            $bank_name = old('bank_name');
                                        else if( isset($userdetail->bank_name) )
                                            $bank_name = $userdetail->bank_name;
                                    ?>
                                    <label>Bank name</label>
                                    <input type="text" name="bank_name" value="{{ $bank_name }}" class="form-control">
                                    @if ($errors->has('bank_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <?php 
                                        $account_holder_name = '';
                                        if( old('account_holder_name') )
                                            $account_holder_name = old('account_holder_name');
                                        else if( isset($userdetail->account_holder_name) )
                                            $account_holder_name = $userdetail->account_holder_name;
                                    ?>
                                    <label>Account holder name</label>
                                    <input type="text" name="account_holder_name" value="{{ $account_holder_name }}" class="form-control">
                                    @if ($errors->has('account_holder_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_holder_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <?php 
                                        $account_no = '';
                                        if( old('account_no') )
                                            $account_no = old('account_no');
                                        else if( isset($userdetail->account_no) )
                                            $account_no = $userdetail->account_no;
                                    ?>
                                    <label>Account no</label>
                                    <input type="text" name="account_no" value="{{ $account_no }}" class="form-control">
                                    @if ($errors->has('account_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <?php 
                                        $bank_ifsc = '';
                                        if( old('bank_ifsc') )
                                            $bank_ifsc = old('bank_ifsc');
                                        else if( isset($userdetail->bank_ifsc) )
                                            $bank_ifsc = $userdetail->bank_ifsc;
                                    ?>
                                    <label>Bank IFSC Code</label>
                                    <input type="text" name="bank_ifsc" value="{{ $bank_ifsc }}" class="form-control">
                                    @if ($errors->has('bank_ifsc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_ifsc') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <?php 
                                        $bank_address = '';
                                        if( old('bank_address') )
                                            $bank_address = old('bank_address');
                                        else if( isset($userdetail->bank_address) )
                                            $bank_address = $userdetail->bank_address;
                                    ?>
                                    <label>Bank Address</label>
                                    <input type="text" name="bank_address" value="{{ $bank_address }}" class="form-control">
                                    @if ($errors->has('bank_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary">Update</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection