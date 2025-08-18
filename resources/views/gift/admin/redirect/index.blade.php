@extends( admin_app() )

@section('content')
    <div class="form-container">
    @php
        $redirectCount = \App\Model\Redirect::count();
    @endphp

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Redirects</h4>

            <a href="{{ route('redirects.create') }}" class="btn btn-primary">Create</a>
    </div>
    <br>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr><th>S./No.</th>
                <th>Old URL</th>
                <th>New URL</th>
                <th>Status Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redirects as $redirect)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $redirect->old_url }}</td>
                    <td>{{ $redirect->new_url }}</td>
                    <td>{{ $redirect->status_code }}</td>
                    
                    <td>
                        <a href="{{ route('redirects.edit', $redirect->id) }}">Edit</a>
                        
                        {!! Form::open(['method' => 'DELETE', 'route' => ['redirects.destroy', $redirect->id] ]) !!}
                            {!! Form::submit('Delete', [
                                'onclick'=>"return confirm('Are you sure?')",
                                'class' => 'btn btn-danger mb-2',
                                    'style' => 'color: red; background-color: transparent; border: none; cursor: pointer; text-decoration: underline;'
                                ]) 
                            !!}
                        {!! Form::close() !!}
												
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $redirects->links() }}
</div>
@endsection
