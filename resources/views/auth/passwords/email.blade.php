@extends('gift.app.app')

@section('content')


    <!-- Page Content Wraper -->
    <div class="page-content-wraper">

        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-border-box">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="" method="POST" action="{{ route('request.mail') }}">
                                {{ csrf_field() }}

                                <h1 class="text-center normal">Forget Password link</h1>

                                <div class="form-field-wrapper {{ $errors->has('email') ? ' has-error' : '' }}">
                                    
                                    <label for="email">Enter Your Email <span class="required">*</span></label>

                                    <input id="email" class="input-md form-full-width" name="email" placeholder="Enter Your Email Address" value="{{ old('email') }}" type="email">

                                    @if ($errors->has('email'))
                                        <span class="alert-warning">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-field-wrapper">
                                    <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Submit" type="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </section>
        <!-- End Page Content -->

    </div>
    <!-- End Page Content Wraper -->


@endsection