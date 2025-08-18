@extends('gift.app.app')

@section('content')

    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-3">
                        <div class="form-border-box">
                            <form class="" method="POST" action="{{ route('update.password') }}">
                                {{ csrf_field() }}

                                @if ( Session::has('pass_msg'))
                                    <span class="alert-success">
                                        <strong>{{ Session::get('pass_msg') }}</strong>
                                    </span>
                                @endif

                                @if ( Session::has('pass_err'))
                                    <span class="alert-warning">
                                        <strong>{{ Session::get('pass_err') }}</strong>
                                    </span>
                                @endif

                                <h1 class="normal text-center"><span>Change Password</span></h1>
                                <div class="form-field-wrapper {{ $errors->has('old_password') ? ' has-error' : '' }}">
                                    <label for="old_password">Your Old Password <span class="required">*</span></label>
                                    <input id="old_password" class="input-md form-full-width" name="old_password" placeholder="Your Old Password" value="" type="password">
                                    
                                    @if ($errors->has('old_password'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('old_password') }}</strong>
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
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Update" type="submit">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Content -->

    </div>
    <!-- End Page Content Wraper -->

@endsection