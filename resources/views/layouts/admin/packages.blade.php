	@extends('trippoo/admin/header', ['request' => $request])

	@section('title', 'Packages')

	@section('content')

	<div class="td-right-head">
		<h2>All packages</h2>
		@if( $request->session()->has('message') )
			<span class="error-block">
				{{ $message = $request->session()->get('message') }}
			</span>
		@endif
		<p><a href="{{ url()->previous() }}">Go Back</a></p>
	</div>
	<div class="col-lg-12">
		
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<tr>
					<th style="width: 7%">No.</th>
					<th style="width: 20%">Title</th>
					<th style="width: 20%">Content</th>
					<th style="width: 15%">Category</th>
					<th style="width: 15%">Days</th>
					<th style="width: 15%">Cost</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$count=0;
				if( !isset( $post_model ) ) {
				}
				else {
					$data = $post_model->posts();
					if( $data===false ) {
					}
					else {
						foreach( $data as $row ) { $count++; ?>
							<tr>
								<td>{{ $count }}</td>
								<td>
									<div class="td-name"><a href="{{ url('/0/admin_/package/edit?id='.$row['id'].'&action=edit') }}"><span>{{ $row['title'] }}</span></a></div>
									<div class="td-action">
										<ul>
											<li><a href="{{ url('/'.strtolower($row['slug'])) }}">View</a></li>
											<li><a href="{{ url('/0/admin_/package/edit?id='.$row['id'].'&action=edit') }}">Edit</a></li>
											<li><a href="{{ url('/0/admin_/package/delete?id='.$row['id'].'&action=delete') }}">Delete</a></li>
										</ul>
									</div>
								</td>
								<td>{{ get_excerpt( $row['content'], 15 ).'...' }}</td>
								<?php
									$category = $post_model->get_category( $row['id'] ); 
									$cat_id = (( $category!==false) ? $category[0]['cat_id'] : '');
									$catData = $post_model->category_by_id($cat_id);
								?>
								<td>{{ (($catData!==false) ? $catData[0]['name'] : '') }}</td>
								<td>{{ $row['days'] }}</td>
								<td>{{ $row['price'] }}</td>
							</tr>
			<?php		}
					}
				}
			?>				
			</tbody>
		</table>		
		
	</div>

	@endsection