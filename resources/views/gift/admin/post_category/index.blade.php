@extends( admin_app() )

@section('content')
<div class="form-container">
   
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Post Categories</h4>
        <a href="{{ route('post-categories.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <br>

    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S./No.</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $category->name }} <br>
                    <ul class="action d-inline-flex align-items-center" style="list-style:none; margin-left:5px;">
                        <li>
                            <a href="{{ route('post-categories.edit', $category->id) }}">Edit</a>
                        </li>
                        <li><span class="pipe"></span></li>
                        <li>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['post-categories.destroy', $category->id], 'style' => 'display:inline']) !!}
                                {!! Form::submit('Delete', [
                                    'onclick'=>"return confirm('Are you sure?')",
                                    'class' => 'btn btn-link text-danger p-0 m-0'
                                ]) !!}
                            {!! Form::close() !!}
                        </li>
                    </ul>
                </td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>

<script>
    setTimeout(() => {
        let msg = document.getElementById('success-message');
        if (msg) {
            msg.style.transition = "opacity 0.5s ease"; 
            msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 500); 
        }
    }, 2000);
</script>
@endsection
