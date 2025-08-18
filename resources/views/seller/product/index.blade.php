@extends('seller.app')

@section('title', $title)

@section('content')


	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12">
			<div class="breadcrumb">
	            <h1>{{ $title }}</h1>
	        </div>

	        <a href="{{ route('seller.product.create') }}" title="Add Product">Add <span class="fa fa-plus"></span></a>

	        <div class="separator-breadcrumb border-top"></div>
	    </div>
	</div>

    <div class="row mb-2">
        <div class="col-md-12 col-lg-12 col-xs-12">
			
            <table class="table table-bordered table-hover datatables">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Name</th>
						<th>Category</th>
						<th>Price</th>
						<th>MRP</th>
						<th>Status</th>
						<th>Created at</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				
				<?php $products = App\model\Product::with('product_category')->where('user_id', Auth::id())->orderby('id', 'DESC')
											->get(); ?>

					@if( $products )

						@foreach( $products as $key => $row )

						<tr>
							<td>{{ ++$key }}</td>
							<td>
								<a href="{{ route('seller.product.edit', $row->id) }}">{{ $row->title }}</a>
							</td>
							<td>
								<?php $cat_slug = ''; ?>
								@if($row->product_category)
									@foreach($row->product_category as $cat)
										{{ $cat->name }}
										<?php $cat_slug = $cat->slug; ?>
									@endforeach
								@endif
							</td>
							<td>{{ $row->price }}</td>
							<td>{{ $row->mrp }}</td>
							<td>{{ ucfirst($row->status) }}</td>
							<td>{{ $row->created_at->format('d M Y, H:i') }}</td>
							<td>
								@if( $row->status !== 'active' )
									<a href="{{ route('seller.product.edit', $row->id) }}">Edit</a> | 
								@endif
								<a href="{{ url('/'.$cat_slug.'/'.$row->slug.'/'.$row->product_id) }}">View</a>
							</td>
						</tr>
						
						@endforeach

					@endif
					
				</tbody>
			</table>
            
        </div>
    </div>

@endsection