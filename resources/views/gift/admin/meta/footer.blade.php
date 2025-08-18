@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($app_name) ? $title : '' }}</h4>
	</div>
	<div class="card-block pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			@if( Session::has('meta_err') )
				<span class="label-warning">{{ Session::get('meta_err') }}</span>
			@endif

			@if( Session::has('meta_msg') )
				<span class="label-success">{{ Session::get('meta_msg') }}</span>
			@endif

			{{ Form::open(['url' => route('setting.store'), 'files' => true]) }}

			<div class="form-container col-lg-12 col-md-12">
				
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Footer logo</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="file" name="footer_logo">

							<div>
							<br>
								<img class="img-thumbnail" src="{{ asset( 'public/' . public_file() . App\model\Meta::where('meta_name', 'footer_logo')->value('meta_value') ) }}">
							</div>
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Copyright</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="text" name="copyright" class="form-control" value="{{ App\model\Meta::where('meta_name', 'copyright')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-primary">Save</button>
					</div>

				</div>
			</div>

			{{ Form::close() }}

		</div>
	</div>
</div>


@endsection