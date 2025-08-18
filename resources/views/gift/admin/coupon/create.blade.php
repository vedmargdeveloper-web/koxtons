@extends( admin_app() )


@section('content')


<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<a href="{{ route('coupon.index') }}"><i class="fa fa-arrow-back"></i> Back</a>
	</div>
	<div class="card-block pt-4">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{{ Form::open(['url' => route('coupon.store'), 'files' => true]) }}
			<div class="form-horizontal">
				<div class="col-lg-6 col-md-6 float-left">

					@if( Session::has('coupon_err') )
						<span class="label-warning">{{ Session::get('coupon_err') }}</span>
					@endif

					@if( Session::has('coupon_msg') )
						<span class="label-success">{{ Session::get('coupon_msg') }}</span>
					@endif
			
					<div class="form-group">
						<label>Coupon code</label>
						<input type="text" value="{{ old('code') }}" name="code" class="form-control" placeholder="">
						@if( $errors->has('code') )
							<span class="label-warning">{{ $errors->first('code') }}</span>
						@endif
					</div>


					<div class="form-group">
						<label>Content</label>
						<textarea class="form-control tinyeditor" name="text" rows="5" placeholder="">{{ old('text') }}</textarea>
						@if( $errors->has('text') )
							<span class="label-warning">{{ $errors->first('text') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Content</label>
						<textarea class="form-control tinyeditor" name="content" rows="5" placeholder="">{{ old('content') }}</textarea>
						@if( $errors->has('content') )
							<span class="label-warning">{{ $errors->first('content') }}</span>
						@endif
					</div>
					
				</div>

				<div class="col-lg-6 col-md-6 float-left">
				
					<div class="form-group">
						<button class="btn btn-primary mr-4" name="submit" value="active">Live</button>
						<button class="btn btn-primary" name="submit" value="inactive">Draft</button>
					</div>

					<div class="form-group">
						<label>Discount</label>
						<div class="input-group">
                            <input name="discount" class="form-control" placeholder="" type="text">
                            <div class="input-group-append">
                                <select name="discount_type" class="form-control">
                                	<option value="">Select</option>
                                	<option value="percent">%</option>
                                	<option value="inr">INR</option>
                                </select>
                            </div>
                        </div>
                        @if( $errors->has('discount') )
							<span class="label-warning">{{ $errors->first('discount') }}</span>
						@endif
						@if( $errors->has('discount_type') )
							<span class="label-warning">{{ $errors->first('discount_type') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Start time</label>
						<input type="text" name="start" value="{{ old('start') }}" class="form-control datetimepicker">
						@if( $errors->has('start') )
							<span class="label-warning">{{ $errors->first('start') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>End time</label>
						<input type="text" name="end" value="{{ old('end') }}" class="form-control datetimepicker">
						@if( $errors->has('end') )
							<span class="label-warning">{{ $errors->first('end') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Usage number</label>
						
                            <input name="usage_number" value="{{ old('usage_number') }}" class="form-control" placeholder="" type="text">
                            
                        
                        @if( $errors->has('usage_number') )
							<span class="label-warning">{{ $errors->first('usage_number') }}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Usage amount</label>
						
                            <input name="usage_amount" value="{{ old('usage_amount') }}" class="form-control" placeholder="" type="text">
                            
                        @if( $errors->has('usage_amount') )
							<span class="label-warning">{{ $errors->first('usage_amount') }}</span>
						@endif
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>


@endsection