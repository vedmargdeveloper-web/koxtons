@extends( admin_app() )

@section('content')
<div class="form-container">
    <h4>Add Redirect</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('redirects.store') }}" method="POST">
        @csrf
        <div class="row">
        <div class="form-group col-md-4 ">
            <label>Old URL</label>
            <input type="text" name="old_url" class="form-control" placeholder="/old-page" value="{{ old('old_url') }}">
        </div>

        <div class="form-group col-md-4">
            <label>New URL</label>
            <input type="text" name="new_url" class="form-control" placeholder="/new-page" value="{{ old('new_url') }}">
        </div>

        <div class="form-group col-md-4">
            <label>Status Code</label>
            <select name="status_code" class="form-control">
                <option value="301">301 (Permanent)</option>
                <option value="302">302 (Temporary)</option>
            </select>
        </div>
        </div>
       

        <button type="submit" class="btn btn-primary mr-2">Save Redirect</button>
    </form>
</div>
@endsection
