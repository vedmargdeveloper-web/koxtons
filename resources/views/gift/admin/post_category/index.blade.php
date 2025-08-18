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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('post-categories.edit', $category->id) }}" class="">Edit</a>
                     <a href="{{ route('post-categories.destroy', $category->id) }}"
                        onclick="event.preventDefault(); 
                            if(confirm('Delete this record?')) {
                                document.getElementById('delete-form-{{ $category->id }}').submit();
                            }" 
                        class="text-danger" style="margin-left: 10px;" >
                        Delete
                        </a>

                        <form id="delete-form-{{ $category->id }}" action="{{ route('post-categories.destroy', $category->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                </td>
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
        }, 2000); // 2 seconds
    </script>
@endsection
