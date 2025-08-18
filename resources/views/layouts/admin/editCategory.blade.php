	
	@extends('trippoo/admin/header', ['request' => $request])

	@section('title', 'Edit category')

	@section('content')

	<?php
		if( !isset( $post_model, $id ) ) {
		}
		elseif( !valid_id( $id ) ) {
			echo '<span class="error-block">Category not found</span>';
		}
		else {
			$data = $post_model->category_by_id( $id );
			if( $data === false ) {
				echo '<span class="error-block">Category not found</span>';
			}
			else {
				?>

			<div class="td-right-head">
				<div class="td-head-content">
					<h2>Edit category</h2>
					<p><a href="{{ url('/0/admin_/categories') }}">Go Back to category</a></p>
					@if( $request->session()->has('message') )
						<span class="error-block">
		                    {{ $request->session()->get('message') }}
		                </span>
		            @endif
		            <!-- <p><a href="{{ url()->previous() }}"></a></p> -->
				</div>
			</div>
			
			<div class="td-container">		
				<div class="td-right-body">
					

					{{ Form::open(['url' => url('/0/admin_/category/update?cat_id='.$data[0]['id']), 'class'=>'form', 'role'=>'form']) }}

						<input type="hidden" name="cat_id" value="{{ $data[0]['id'] }}">
						<input type="hidden" name="prev_url" value="{{ current_url() }}">
						<div class="col-lg-12">
							<div class="col-lg-2">
								<label for="category">Category name</label>
							</div>
							<div class="col-lg-6">
								<div class="form-group">					
									<input type="text" id="category" value="{{ $data[0]['name'] }}" name="name" class="form-control input-field" placeholder="Category name" required="required">
									@if ($errors->has('name'))
					                    <span class="error-block">
					                        {{ $error = $errors->first('name') }}
					                    </span>
					                @endif
								</div>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="col-lg-2">
								<label for="title">Description</label>
							</div>

							<div class="col-lg-6">
								<div class="form-group">					
									<textarea placeholder="Short description..." class="form-control input-field description" name="description" rows="4">{{ urldecode( $data[0]['description'] ) }}</textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<button class="btn btn-primary">Update</button>
						</div>

					{{ Form::close() }}
				</div>
			</div>


	<?php
			}
		}
	?>

	@endsection