@extends('gift.app.app')

<?php $user = App\User::where('token', $token)->first(); ?>

@section('title', $user ? $title : 'Link Expired!')

@section('content')

    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-3">
                        <div class="form-border-box">

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            @if( $user )
                            <form class="" method="POST" action="{{ route('user.password.update') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">

                                <h1 class="normal text-center"><span>Reset Password</span></h1>
                                <div class="form-field-wrapper {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Your Email <span class="required">*</span></label>
                                    <input id="email" class="input-md form-full-width" name="email" placeholder="Your Email Address" value="{{ old('email') }}" type="email">
                                    @if ($errors->has('email'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Your New Password <span class="required">*</span></label>
                                    <input id="password" class="input-md form-full-width" name="password" placeholder="Your New Password" value="" type="password">
                                    
                                    @if ($errors->has('password'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password_confirmation">Your New Password Confirmation <span class="required">*</span></label>
                                    <input id="password_confirmation" class="input-md form-full-width" name="password_confirmation" placeholder="Your New Password Confirmation" value="" type="password">
                                    
                                    @if ($errors->has('password_confirmation'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper">
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Reset" type="submit">
                                </div>

                            </form>
                            @else
                                <p class="text-center">Link has been expired!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Content -->

    </div>
    <!-- End Page Content Wraper -->

@endsection