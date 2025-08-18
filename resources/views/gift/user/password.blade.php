@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>
                <div class="card-body">

                    @if( session()->has('pass_msg') )
                        <span class="text-success">{{ session()->get('pass_msg') }}</span>
                    @endif

                    {{ Form::open(['url' => route('user.change.password')]) }}

                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" class="form-control" name="old_password" placeholder="********">
                            @if( $errors->has('old_password') )
                                <span class="text-warning">{{ $errors->first('old_password') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="********">
                            @if( $errors->has('password') )
                                <span class="text-warning">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="********">
                            @if( $errors->has('password_confirmation') )
                                <span class="text-warning">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-primary">Update</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection