@extends( admin_app() )


@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
	
	<div class="card">
		<div class="card-header">
			

			<h4>{{ isset($title) ? $title : '' }}</h4>
			@if( $type === 'post' )
				<a href="{{ route('post.create') }}">Create post</a>
			@else
				<a href="{{ route('page.create') }}">Create page</a>
			@endif
		</div>
		<div class="card-body pt-4">
		
			@if( Session::has('post_msg') )
				<span class="label-success">{{ Session::get('post_msg') }}</span>
			@endif
			@if( Session::has('post_err') )
				<span class="label-warning">{{ Session::get('post_err') }}</span>
			@endif
			@if( $type === 'post' )
				<?php $all = App\model\Post::Where('type', 'post')->get(); ?>
				<?php $published = App\model\Post::Where(['type' => 'post', 'status' => 'publish'])->get(); ?>
				<?php $draft = App\model\Post::Where(['type' => 'post', 'status' => 'draft'])->get(); ?>
			@else
				<?php $all = App\model\Post::Where('type', 'page')->get(); ?>
				<?php $published = App\model\Post::Where(['type' => 'page', 'status' => 'publish'])->get(); ?>
				<?php $draft = App\model\Post::Where(['type' => 'page', 'status' => 'draft'])->get(); ?>
			@endif
			<div class="h-tab">
	  
				<ul class="h-tab_tab-head">
				  <li class="active" rel="all">All post ( {{ count($all) }} )</li>
				  <li rel="published">Published post ( {{ count($published) }} )</li>
				  <li rel="draft">Draft Post ( {{ count($draft) }} )</li>
				</ul>
				  
				<div class="h-tab_container">

				  	<div id="all" class="h-tab_content">
				    
					    <table class="table table-bordered table-hover datatables">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Title</th>
									<th>Slug</th>
									<th>Category</th>
									<th>Created at</th>
									<th>Updated at</th>
								</tr>
							</thead>
							<tbody>
							@if( $all && count( $all ) )
								@foreach( $all as $key => $row )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											<div>{{ ucfirst($row->title) }} <b>{{ $row->status !== 'publish' ? '- '.ucfirst($row->status) : '' }}</b></div>
											<ul class="action">
												@if( $type === 'post' )
												<li><a href="{{ route('post.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@else
												<li><a href="{{ route('page.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['page.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@endif
											</ul>
										</td>
										<td>{{ $row->slug }}</td>
										<td>{{ ucfirst( $row->category_id ? App\model\PostCategory::find($row->category_id)->value('name') : '' ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->updated_at ) ) }}</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>

				  	</div>
				  	<!-- #all -->

				  	<div id="published" class="h-tab_content">
						<table class="table table-bordered table-hover datatables">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Title</th>
									<th>Slug</th>
									<th>Category</th>
									<th>Created at</th>
									<th>Updated at</th>
								</tr>
							</thead>
							<tbody>
							@if( $published && count( $published ) )
								@foreach( $published as $key => $row )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											<div>{{ ucfirst($row->title) }}</div>
											<ul class="action">
												@if( $type === 'post' )
												<li><a href="{{ route('post.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@else
												<li><a href="{{ route('page.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['page.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@endif
											</ul>
										</td>
										<td>{{ $row->slug }}</td>
										<td>{{ ucfirst( $row->category_id ? App\model\PostCategory::find($row->category_id)->value('name') : '' ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->updated_at ) ) }}</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
				  	</div>
				  	<!-- #tab2 -->

				  	<div id="draft" class="h-tab_content">
					    <table class="table table-bordered table-hover datatables">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Title</th>
									<th>Slug</th>
									<th>Category</th>
									<th>Created at</th>
									<th>Updated at</th>
								</tr>
							</thead>
							<tbody>
							@if( $draft && count( $draft ) )
								@foreach( $draft as $key => $row )
									<tr>
										<td>{{ ++$key }}</td>
										<td>
											<div>{{ ucfirst($row->title) }}</div>
											<ul class="action">
												@if( $type === 'post' )
												<li><a href="{{ route('post.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@else
												<li><a href="{{ route('page.edit', $row->id) }}">Edit</a></li>
												<li><span class="pipe"></span></li>
												<li>
												{!! Form::open(['method' => 'DELETE', 'route' => ['page.destroy', $row->id] ]) !!}

				                            		{!! Form::submit('Delete', [
				                            					'onclick'=>"return confirm('Are you sure?')",
				                            					'class' => 'btn btn-danger'
				                            					]) 
				                            				!!}

				                            	{!! Form::close() !!}
												</li>
												@endif
											</ul>
										</td>
										<td>{{ $row->slug }}</td>
										<td>{{ ucfirst( $row->category_id ? App\model\Category::find($row->category_id)->value('name') : '' ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->created_at ) ) }}</td>
										<td>{{ date('d, M Y H:i', strtotime($row->updated_at ) ) }}</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
				  	</div>
				  <!-- #tab3 -->

				</div>

			</div>

		</div>
	</div>
</div>

@endsection