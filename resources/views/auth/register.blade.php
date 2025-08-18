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
                        <form class="" method="POST" action="{{ route('user.register') }}">
                            {{ csrf_field() }}
                            <h1 class="normal"><span>Create An Account</span></h1>
                            <p>If you are not a member, sign up now.</p>

                            <div class="form-field-wrapper {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="text">Enter Your First Name <span class="required">*</span></label>
                                <input id="text" class="input-md form-full-width" name="first_name" placeholder="Enter Your First Name" value="{{ old('first_name') }}" aria-required="true" type="text">
                                @if ($errors->has('first_name'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-field-wrapper {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="text">Enter Your Last Name <span class="required">*</span></label>
                                <input id="text" class="input-md form-full-width" name="last_name" placeholder="Enter Your Last Name" value="{{ old('last_name') }}" aria-required="true" type="text">
                                @if ($errors->has('last_name'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-field-wrapper {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email">Enter Your Email <span class="required">*</span></label>
                                <input id="email" class="input-md form-full-width" name="email" placeholder="Enter Your Email Address" value="{{ old('email') }}" aria-required="true" type="email">
                                @if ($errors->has('email'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-field-wrapper {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="email">Enter Your Mobile <span class="required">*</span></label>
                                <input id="email" class="input-md form-full-width" name="mobile" placeholder="Enter Your Mobile No" value="{{ old('mobile') }}" aria-required="true" type="text">
                                @if ($errors->has('mobile'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-field-wrapper {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Your Password <span class="required">*</span></label>
                                <input id="password" class="input-md form-full-width" name="password" placeholder="Your Password" aria-required="true" type="password">

                                @if ($errors->has('password'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-field-wrapper {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation">Your Password Confirmation <span class="required">*</span></label>
                                <input id="password_confirmation" class="input-md form-full-width" name="password_confirmation" placeholder="Your Password Confirmation" aria-required="true" type="password">

                                @if ($errors->has('password_confirmation'))
                                    <span class="alert-warning">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-field-wrapper">
                                <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Sign Up" type="submit">
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-border-box">
                        <form>
                            <h1 class="normal"><span>Already Customer?</span></h1>
                            <p>If you are already a member, Sign in here.</p>
                            <div class="form-field-wrapper">
                                <a class="submit btn btn-md btn-color" href="{{ route('login') }}">Sign In</a>
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