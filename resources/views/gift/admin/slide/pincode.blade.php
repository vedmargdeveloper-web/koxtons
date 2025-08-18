@extends( admin_app() )


@section('content')
<style type="text/css">
	.sider-button{list-style: none; display: flex;padding-left: 0;}
	.sider-button li{  }
	
</style>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }}</h4>
		</div>
		<div class="card-body pt-4">
			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif
			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif
			
			

			<div class="row">
				<div class="col-lg-4 col-md-4">
				</div>
				<div class="col-lg-4 col-md-4">

				@if( Session::has('slide_msg') )
					<span class="label-success">{{ Session::get('slide_msg') }}</span>
				@endif

				@if( Session::has('slide_err') )
					<span class="label-warning">{{ Session::get('slide_err') }}</span>
				@endif

				{!! Form::open( ['url' => route('upload.pincode'),'files'=> true ] ) !!}
					<div class="form-group">
						<label for="">Upload Pincode File(*Excel file)</label>
						<input type="file" name="file">
						@if( $errors->has('file') )
							<span class="text-danger">{{ $errors->first('file') }}</span>
						@endif
					</div>

					<button class="btn btn-primary" value="active" name="submit">Submit</button>

				{!! Form::close() !!}

			

			</div>
			

			</div>


		</div>
	</div>
</div>

@endsection