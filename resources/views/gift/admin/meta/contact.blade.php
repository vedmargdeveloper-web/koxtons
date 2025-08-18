@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>Contact details</h4>
	</div>
	<div class="card-body pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			@if( Session::has('meta_err') )
				<span class="label-warning">{{ Session::get('meta_err') }}</span>
			@endif

			@if( Session::has('meta_msg') )
				<span class="label-success">{{ Session::get('meta_msg') }}</span>
			@endif

			{{ Form::open(['url' => route('setting.store'), 'files' => true]) }}

			<div class="form-container col-lg-12 col-md-12">
				
				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Contact email</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="email" placeholder="Contact email" name="contact_email" value="{{ App\model\Meta::where('meta_name', 'contact_email')->value('meta_value') }}" class="form-control">
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Address</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea rows="2" placeholder="Contact address" style="height: 100px;" class="form-control tinyeditor" name="address">{{ App\model\Meta::where('meta_name', 'address')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Phone no.</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="tel" placeholder="Phone number" class="form-control" name="phone" value="{{ App\model\Meta::where('meta_name', 'phone')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Mobile no.</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="tel" placeholder="Mobile number" class="form-control" name="mobile" value="{{ App\model\Meta::where('meta_name', 'mobile')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Whatsapp no.</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="tel" placeholder="Whatsapp number" class="form-control" name="whatsapp" value="{{ App\model\Meta::where('meta_name', 'whatsapp')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Google map location</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea rows="2" placeholder="Map location" class="form-control tinyeditor" name="location">{{ App\model\Meta::where('meta_name', 'location')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Social medai username</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="text" placeholder="Facebook username" class="form-control" name="facebook" value="{{ App\model\Meta::where('meta_name', 'facebook')->value('meta_value') }}">
						</div>
						<div class="form-group mb-4">
							<input type="text" placeholder="Twitter username" class="form-control" name="twitter" value="{{ App\model\Meta::where('meta_name', 'twitter')->value('meta_value') }}">
						</div>
						<div class="form-group mb-4">
							<input type="text" placeholder="Linkedin username" class="form-control" name="linkedin" value="{{ App\model\Meta::where('meta_name', 'linkedin')->value('meta_value') }}">
						</div>
						<div class="form-group mb-4">
							<input type="text" placeholder="Instagram username" class="form-control" name="instagram" value="{{ App\model\Meta::where('meta_name', 'instagram')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Mail signature</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea rows="2" placeholder="" style="height: 100px;" class="form-control tinyeditor" name="signature">{{ App\model\Meta::where('meta_name', 'signature')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Company name</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<textarea rows="2" placeholder="" style="height: 100px;" class="form-control tinyeditor" name="company_name">{{ App\model\Meta::where('meta_name', 'company_name')->value('meta_value') }}</textarea>
						</div>
					</div>
				</div>

				<div class="row mb-1">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>GST No.</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="text" placeholder="" class="form-control" name="gst_no" value="{{ App\model\Meta::where('meta_name', 'gst_no')->value('meta_value') }}">
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Digital Signature</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group mb-4">
							<input type="file" name="digital_signature">
							<div>
							<img class="img-thumbnail" src="{{ asset( 'public/' . public_file() . App\model\Meta::where('meta_name', 'digital_signature')->value('meta_value') ) }}">
							</div>
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