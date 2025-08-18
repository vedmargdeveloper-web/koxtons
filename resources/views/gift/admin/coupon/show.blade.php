@extends( admin_app() )


@section('content')


<?php $coupon = App\model\Coupon::find( $id ); ?>

<div class="card">
	<div class="card-header">
		<h4>{{ isset($title) ? $title : '' }}</h4>
		<a href="{{ route('coupon.create') }}">Create</a>
		@if( $coupon )
			 | <a href="{{ route('coupon.edit', $coupon->id) }}">Edit</a>
		@endif
	</div>

	<div class="card-block">
		<div class="col-lg-12 col-md-12 col-sm-12 mt-2">

			@if( $coupon )
			
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>Code</th>
						<td>{{ $coupon->code }}</td>
					</tr>

					<tr>
						<th>Text</th>
						<td><?php echo $coupon->text; ?></td>
					</tr>

					<tr>
						<th>Content</th>
						<td><?php echo $coupon->content; ?></td>
					</tr>

					<tr>
						<th>Start time</th>
						<td>{{ date('d M, Y H:i:s', strtotime($coupon->start)) }}</td>
					</tr>

					<tr>
						<th>End time</th>
						<td>{{ date('d M, Y H:i:s', strtotime($coupon->end)) }}</td>
					</tr>

					<tr>
						<th>Status</th>
						<td>{{ $coupon->status }}</td>
					</tr>

					<tr>
						<th>Created at</th>
						<td>{{ date('d M, Y H:i:s', strtotime($coupon->created_at)) }}</td>
					</tr>

					<tr>
						<th>Updated at</th>
						<td>{{ date('d M, Y H:i:s', strtotime($coupon->updated_at)) }}</td>
					</tr>
				</tbody>
			</table>

			@else

				<p>Data not found!</p>

			@endif


		</div>
	</div>
</div>


@endsection