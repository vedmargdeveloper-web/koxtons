	
	@extends('trippoo/admin/header', ['request' => $request])

	@section('title', 'Categories')

	@section('content')

	<div class="td-right-head">
		<div class="td-head-content">
			<h2>Categories</h2>
			@if( $request->session()->has('message') )
				<span class="error-block">
                    {{ $request->session()->get('message') }}
                </span>
            @endif
            <p><a href="{{ url()->previous() }}">Go Back</a></p>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="td-container">
			
			<div class="td-right-body">
				{{ Form::open(['url' => url('/0/admin_/category/add'), 'class'=>'form', 'role'=>'form']) }}

					<div class="form-group">
						<label for="category">Category name</label>
						<input type="text" id="category" value="{{ old('name') }}" name="name" class="form-control input-field" placeholder="Category name" required="required">
						@if ($errors->has('name'))
		                    <span class="error-block">
		                        {{ $error = $errors->first('name') }}
		                    </span>
		                @endif
					</div>
					<div class="form-group">
						<label for="title">Description</label>
						<textarea placeholder="Short description..." class="form-control input-field description" name="description" rows="5">{{ old('description') }}</textarea>
					</div>
					<button class="btn btn-primary">Submit</button>


				{{ Form::close() }}
			</div>
			<div class="td-right-bottom">
			</div>
		</div>
	</div>
	<div class="col-lg-8 td-right">
		<div class="td-col-right-head">
			<label>All Category</label>
			<table class="table table-bordered table-hover table-responsive">
				<thead>
					<tr>
						<th style="width: 7%">No.</th>
						<th style="width: 32%">Name</th>
						<th style="width: 21%">Slug</th>
						<th style="width: 40%">Description</th>
					</tr>
				</thead>
				<?php
					$count = 0;
					if( isset( $post_model ) ) {
						$data = $post_model->categories();

						if( $data!==false ) { 
							foreach( $data as $row ) { $count++; ?>
								<tbody>
									<tr>
										<td><span>{{ $count }}</span></td>
										<td>
											<div class="td-name"><a href="{{ url('/0/admin_/category/edit?cat_id='.$row['id'].'&action=edit') }}"><span>{{ $row['name'] }}</span></a></div>
											<div class="td-action">
												<ul>
													<li><a href="{{ url('/'.strtolower($row['slug'])) }}">View</a></li>
													<li><a href="{{ url('/0/admin_/category/edit?cat_id='.$row['id'].'&action=edit') }}">Edit</a></li>
													<li><a href="{{ url('/0/admin_/category/delete?cat_id='.$row['id'].'&action=delete') }}">Delete</a></li>
												</ul>
											</div>
										</td>
										<td><span>{{ strtolower( $row['slug'] ) }}</span></td>
										<td><span>{{ urldecode($row['description']) }}</span></td>
									</tr>
								</tbody>
				<?php		}
						}
					}
				?>
			</table>
		</div>
		<div class="td-col-right-body">

		</div>
		<div class="td-col-right-footer">

		</div>
	</div>

	@endsection