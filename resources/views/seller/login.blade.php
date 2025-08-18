@extends('gift.app.app')

@section('content')


<!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row form-wrapper">
                    <div class="col-md-6 form-container">
                        <div class="form-border-box">
                            <form class="form-horizontal" method="POST" action="{{ route('seller.login') }}">
                                {{ csrf_field() }}
                                
                                <h2 class="normal text-center"><span>Seller Login</span></h2>
                                <p>If you are already member, login now.</p>
                                
                                @if( session()->has('message') )
                                    <span class="text-warning">{{ session()->get('message') }}</span>
                                @endif

                                <div class="form-field-wrapper {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Enter Username <span class="required">*</span></label>
                                    <input id="email" class="input-md form-full-width" name="email" placeholder="Enter Username" value="{{ old('email') }}" aria-required="true">
                                    @if ($errors->has('email'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('email') }}</strong>
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
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="form-field-wrapper">
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Sign In" type="submit">
                                </div>

                                <p>Want to become a seller? <a href="{{ route('seller.register') }}">Sign Up</a></p>

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