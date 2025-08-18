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
                            <form class="form-horizontal" method="POST" action="{{ route('seller.signup') }}">
                                {{ csrf_field() }}
                                
                                <h2 class="normal text-center"><span>Sign Up</span></h2>
                                <p>Join and start selling your products.</p>

                                <div class="form-field-wrapper {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="first_name">Enter first name <span class="required">*</span></label>
                                    <input id="first_name" class="input-md form-full-width" name="first_name" placeholder="Enter first name" value="{{ old('first_name') }}" aria-required="true">
                                    @if ($errors->has('first_name'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name">Enter last name <span class="required">*</span></label>
                                    <input id="last_name" class="input-md form-full-width" name="last_name" placeholder="Enter last name" value="{{ old('last_name') }}" aria-required="true">
                                    @if ($errors->has('last_name'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Enter email <span class="required">*</span></label>
                                    <input id="email" class="input-md form-full-width" name="email" placeholder="Enter email" value="{{ old('email') }}" aria-required="true">
                                    @if ($errors->has('email'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Enter Your Password <span class="required">*</span></label>
                                    <input id="password" class="input-md form-full-width" name="password" placeholder="Enter password" value="" size="30" aria-required="true" type="password">
                                    @if ($errors->has('password'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper">
                                    <div>
                                        <input {{ old('tnc') ? 'checked' : '' }} type="checkbox" id="checkbox" name="tnc" value="1">
                                        <label class="checkbox" for="checkbox">By clicking your accept the terms & conditions.</label>
                                    </div>

                                    @if ($errors->has('tnc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tnc') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper">
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Sign Up" type="submit">
                                </div>

                                <p>If you are already member? <a href="{{ route('seller') }}">Sign In</a></p>

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