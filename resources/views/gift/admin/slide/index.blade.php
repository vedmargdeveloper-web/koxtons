@extends( admin_app() )


@section('content')
<style type="text/css">
	.sider-button{list-style: none; display: flex;padding-left: 0;}
	.sider-button li{  }
	
</style>
<?php $slide = App\model\Slide::orderby('id', 'DESC')->get(); ?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	<div class="card">
		<div class="card-header">
			<h4>{{ isset($title) ? $title : '' }} <sub>({{ $slide->count() }})</sub></h4>
		</div>
		<div class="card-body pt-4">
			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif
			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif
			
			

			<div class="row">
				{{-- <div class="col-lg-4 col-md-4">
				</div> --}}
			<div class="col-lg-4 col-md-4 mb-3" style="display: block;">

				@if( Session::has('slide_msg') )
					<span class="label-success">{{ Session::get('slide_msg') }}</span>
				@endif

				@if( Session::has('slide_err') )
					<span class="label-warning">{{ Session::get('slide_err') }}</span>
				@endif



			

				{!! Form::open( ['url' => route('slide.store'), 'files' => true] ) !!}

				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" value="{{ old('title') }}" class="form-control">
					@if( $errors->has('title') )
						<span class="text-danger">{{ $errors->first('title') }}</span>
					@endif
				</div>

				<div class="form-group">
					<label>Type</label>
					<select name="type" class="form-control">
						<option value="mainslider">Main Slider</option>
						<option value="mobileslider">Mobile Slider (1000 x 700)</option>
						<option value="collection">Collection</option>
						<option value="top-promo-banner">Top Promo Banner</option>
						<option value="bottom-promo-banner">Bottom Promo Banner</option>
						<option value="bottomslider">Bottom Slider</option>
						<option value="video">Video</option>
					</select>
					@if( $errors->has('title') )
						<span class="text-danger">{{ $errors->first('title') }}</span>
					@endif
				</div>


				<div class="form-group">
					<label>Button</label>
					<input type="text" placeholder="Text" value="{{ old('see_more') }}" name="see_more" class="form-control">
					@if( $errors->has('see_more') )
						<span class="text-danger">{{ $errors->first('see_more') }}</span>
					@endif
					<br>
					<input type="text" placeholder="Link" value="{{ old('see_more_link') }}" name="see_more_link" class="form-control">
					@if( $errors->has('see_more_link') )
						<span class="text-danger">{{ $errors->first('see_more_link') }}</span>
					@endif
				</div>

				<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
						@if( $errors->has('description') )
							<span class="text-danger">{{ $errors->first('description') }}</span>
						@endif
					</div>


				<div class="form-group">
					<label>Content Position</label><br>
					<input type="radio" {{ old('position') === 'left' ? 'checked' : '' }} value="left" name="position"> Left 
					<input type="radio" {{ old('position') === 'right' ? 'checked' : '' }} value="right" name="position"> Right 
					<input type="radio" {{ old('position') === 'center' ? 'checked' : '' }} value="center" name="position"> Center 
					@if( $errors->has('position') )<br>
							<span class="text-danger">{{ $errors->first('position') }}</span>
						@endif
				</div>

                <div class="form-group">
						<label>Image Alt</label>
						<input class="form-control" name="image_alt" rows="3">
						@if( $errors->has('image_alt') )
							<span class="text-danger">{{ $errors->first('image_alt') }}</span>
						@endif
				</div>
				<div class="form-group">
					<input type="file" name="file">
					@if( $errors->has('file') )
						<span class="text-danger">{{ $errors->first('file') }}</span>
					@endif
				</div>

				

				<button class="btn btn-primary" value="active" name="submit">Submit</button>
				<button class="btn btn-primary" value="inactive" name="draft">Draft</button>

				{!! Form::close() !!}

			</div>
			<div class="col-lg-8 col-md-8" style="overflow: auto;">
				<div class="row">
					<div class="col-md-12">
						{{-- <ul class="sider-button">
							<li> <a href="#mainslider"></a></li>
							<li> <a href=""></a></li>
							<li> <a href="">Top Promo Bannerr</a></li>
							<li> <a href="">Bottom Promo Banner</a></li>
							<li> <a href="">Bottom Slider</a></li>
						</ul> --}}

						<div id="accordion">
							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							          Main Slider 
							          <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 1600x500)</label>
							    </div>

							    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="mainslider")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}" alt="{{ $row->image_alt ?? $row->title }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>

							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseNew" aria-expanded="true" aria-controls="collapseNew">
							          Mobile Slider 
							          <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 1000x700)</label>
							    </div>

							    <div id="collapseNew" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="mobileslider")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>

							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
							          Main Collection
							          <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 360x220)</label>
							    </div>

							    <div id="collapsetwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="collection")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>



							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
							          Top Promo Banner <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 560x320)</label>
							    </div>

							    <div id="collapsethree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="top-promo-banner")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>


							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
							          Bottom Promo Banner <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 560x320)</label>
							    </div>

							    <div id="collapsefour" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="bottom-promo-banner")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>


							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsefive" aria-expanded="true" aria-controls="collapsefive">
							          Bottom Slider <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							      <label>Image (File size must be less than 1MB & Image dimensions 1600x320)</label>
							    </div>

							    <div id="collapsefive" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Link</th>
												<th>Image</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="bottomslider")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td>{{ $row->see_more_link }}</td>
														<td><img class="img-thumbnail" src="{{ asset( 'public/' . public_file( thumb( $row->image, 130, 140 ) ) ) }}"></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>


							<div class="card mb-5">
							    <div class="card-header" id="headingOne">
							      <h5 class="mb-0">
							        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapsesix">
							          Video <i class="fa fa-angle-right"></i>
							        </button>
							      </h5>
							    </div>

							    <div id="collapsesix" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body">
							        <table class="table table-bordered table-hover datatables" id="mainslider">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>video link</th>
												<th>Status</th>
												<th>Created at</th>
											</tr>
										</thead>
										<tbody>
										@if( $slide && count( $slide ) )
											@foreach( $slide as $key => $row )

												@if($row->type=="video")
													<tr>
														<td>{{ ++$key }}</td>
														<td>
															<div>{{ ucfirst($row->title) }}</div>
															<ul class="action">
																<li><a href="{{ route('slide.edit', $row->id) }}">Edit</a></li>
																<li><span class="pipe"></span></li>
																<li>
																{!! Form::open(['method' => 'DELETE', 'route' => ['slide.destroy', $row->id] ]) !!}

								                            		{!! Form::submit('Delete', [
								                            					'onclick'=>"return confirm('Are you sure?')",
								                            					'class' => 'btn btn-danger'
								                            					]) 
								                            				!!}

								                            	{!! Form::close() !!}
																</li>
															</ul>
														</td>
														<td><a href="{{ asset( 'public/' . public_file( 'video/'.$row->image ) ) }}">Video Link</a></td>
														<td>{{ ucfirst($row->status) }}</td>
														<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
													</tr>
												@endif
											@endforeach
										@endif
										</tbody>
									</table>
							      </div>
							    </div>
							</div>

							
						</div>
					</div>
				</div>
				
			</div>

			</div>


		</div>
	</div>
</div>

@endsection