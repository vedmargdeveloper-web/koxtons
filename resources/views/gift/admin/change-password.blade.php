@extends( admin_app() )


@section('content')


	<div class="card">

		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }}</h4>
		</div>



		<div class="card-block pt-4">

			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

				@if( Session::has('pass_err') )
					<label class="label-warning">{{ Session::get('pass_err') }}</label>
				@endif

				@if( Session::has('pass_msg') )
					<label class="label-success">{{ Session::get('pass_msg') }}</label>
				@endif

				{{ Form::open(['url' => route('admin.update.password')]) }}

				<div class="form-group">
					<label for="">Old password</label>
					<input type="password" name="old_password" value="" class="form-control" placeholder="">
					@if( $errors->has('old_password') )
						<span class="label-warning">{{ $errors->first('old_password') }}</span>
					@endif
				</div>

				<div class="form-group">
					<label for="">New password</label>
					<input type="password" name="password" value="" class="form-control" placeholder="">
					@if( $errors->has('password') )
						<span class="label-warning">{{ $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group">
					<label for="">Confirm password</label>
					<input type="password" name="password_confirmation" value="" class="form-control" placeholder="">
					@if( $errors->has('password_confirmation') )
						<span class="label-warning">{{ $errors->first('password_confirmation') }}</span>
					@endif
				</div>

				<button type="submit" class="btn btn-primary">Update</button>

				{{ Form::close() }}

			</div>
		</div>

	</div>


@endsection