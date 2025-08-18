@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<a href="{{ route('admin.sellers') }}"><i class="material-icons">arrow_back_ios</i></a>
	</div>
	<div class="card-body pt-5 pb-5">
		<div class="form-container text-center" style="display: block;">
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-left" style="display: inline-block;">
				@if( Session::has('vendor_err') )
					<span class="label-warning">{{ Session::get('vendor_err') }}</span>
				@endif

				@if( Session::has('vendor_msg') )
					<span class="label-success">{{ Session::get('vendor_msg') }}</span>
				@endif

				{{ Form::open(['url' => route('admin.seller.store'), 'files' => true]) }}
					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>First name</label>
								<input type="text" value="{{ old('first_name') }}" name="first_name" class="form-control" placeholder="">
								@if( $errors->has('first_name') )
									<span class="label-warning">{{ $errors->first('first_name') }}</span>
								@endif
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Last name</label>
								<input type="text" value="{{ old('last_name') }}" name="last_name" class="form-control" placeholder="">
								@if( $errors->has('last_name') )
									<span class="label-warning">{{ $errors->first('last_name') }}</span>
								@endif
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" value="{{ old('email') }}" class="form-control">
								@if( $errors->has('email') )
									<span class="label-warning">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" value="" class="form-control">
								@if( $errors->has('password') )
									<span class="label-warning">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <div>
                                <input {{ old('tnc') ? 'checked' : '' }} type="checkbox" id="checkbox" name="tnc" value="1">
                                <label style="display: inline;padding-left: 5px;" class="checkbox" for="checkbox">By clicking your accept the terms & conditions.</label>
                            </div>

                            @if ($errors->has('tnc'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tnc') }}</strong>
                                </span>
                            @endif
                        </div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary mr-4" name="save" value="active">Submit</button>
						</div>

					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


@endsection