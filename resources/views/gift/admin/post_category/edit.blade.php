@extends( admin_app() )
@section('content')
<div class="form-container">
    <h1>Edit Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('post-categories.update', $postCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $postCategory->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $postCategory->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mr-2">Update </button>
         <a href="{{ route('post-categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
