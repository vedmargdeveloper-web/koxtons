@extends('gift.app.app')

@section('content')


<!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-border-box">

                            <form class="" method="POST" action="{{ route('user.login') }}">
                                {{ csrf_field() }}
                                @if( isset( $_GET['back'] ) && $_GET['back'] !== '' )
                                    <input type="hidden" name="back" value="{{ $_GET['back'] }}">
                                @endif
                                <h1 class="normal"><span>Login</span></h1>
                                <p>If you are already member, login now.</p>
                                
                                @if( $errors->has('message') )
                                    <span class="text-warning">{{ $errors->first('message') }}</span>
                                @endif

                                <div class="form-field-wrapper {{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username">Enter Username <span class="required">*</span></label>
                                    <input id="username" class="input-md form-full-width" name="username" placeholder="Enter Username" value="{{ old('username') }}" aria-required="true">
                                    @if ($errors->has('username'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-field-wrapper {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Enter Your Password <span class="required">*</span></label>
                                    <input id="password" class="input-md form-full-width" name="password" placeholder="Enter Your Password" value="" size="30" aria-required="true" type="password">
                                    <a class="mt-1 pull-right btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                    @if ($errors->has('password'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-field-wrapper">
                                    <p>
                                        <input type="checkbox" id="checkbox" name="use_coupon" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                                        <label style="display: inline-block;margin:0;" for="checkbox">Remember Me</label>
                                    </p>
                                </div>
                                <div class="form-field-wrapper">
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Sign In" type="submit">
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-border-box">
                            <form>
                                <h1 class="normal"><span>New Customer</span></h1>
                                <p>If you are not a member, become a member.</p>
                                <div class="form-field-wrapper">
                                    <a class="submit btn btn-md btn-color" href="{{ route('register') }}">Create An Account</a>
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