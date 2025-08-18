@extends( admin_app() )

@section('content')
<div class="form-container">
    <h4>Edit Redirect</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('redirects.update', $redirect) }}" method="POST">
        @csrf @method('PUT')

       <div class="row">
         <div class="form-group col-md-4">
            <label>Old URL</label>
            <input type="text" name="old_url" class="form-control" value="{{ old('old_url', $redirect->old_url) }}">
        </div>

        <div class="form-group col-md-4">
            <label>New URL</label>
            <input type="text" name="new_url" class="form-control" value="{{ old('new_url', $redirect->new_url) }}">
        </div>

        <div class="form-group col-md-4">
            <label>Status Code</label>
            <select name="status_code" class="form-control">
                <option value="301" {{ $redirect->status_code == 301 ? 'selected' : '' }}>301 (Permanent)</option>
                <option value="302" {{ $redirect->status_code == 302 ? 'selected' : '' }}>302 (Temporary)</option>
            </select>
        </div>
       </div>

        <button type="submit" class="btn btn-primary mr-2">Update Redirect</button>
    </form>
</div>
@endsection
