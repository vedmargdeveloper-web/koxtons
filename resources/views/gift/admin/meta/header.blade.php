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
							<label>Site name</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="text" placeholder="Website name" name="app_name" value="{{ App\model\Meta::where('meta_name', 'app_name')->value('meta_value') }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Site logo</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="file" name="app_logo">
							<div>
							<img class="img-thumbnail" src="{{ asset( 'public/' . public_file() . App\model\Meta::where('meta_name', 'app_logo')->value('meta_value') ) }}">
							</div>
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Analytics code</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea class="form-control" name="analytics">{{ App\model\Meta::where('meta_name', 'analytics')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Messenger code</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea class="form-control" name="messenger">{{ App\model\Meta::where('meta_name', 'messenger')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div>
					<h4>Product Receipt Details</h4>
				</div>
				<br>
				
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Company Name</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea class="form-control" name="receipt_company_name">{{ App\model\Meta::where('meta_name', 'receipt_company_name')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Company Logo</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="file" name="company_logo">
							<div>
							<img class="img-thumbnail" src="{{ asset( 'public/' . public_file() . App\model\Meta::where('meta_name', 'company_logo')->value('meta_value') ) }}">
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Full Address</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea class="form-control" name="receipt_address">{{ App\model\Meta::where('meta_name', 'receipt_address')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Customer Care</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							
							<input class="form-control" name="customer_care" value="{{ old('customer_care', App\Model\Meta::where('meta_name', 'customer_care')->value('meta_value')) }}">
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Company Email</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input class="form-control" name="company_email" value="{{ old('company_email', App\Model\Meta::where('meta_name', 'company_email')->value('meta_value')) }}">

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