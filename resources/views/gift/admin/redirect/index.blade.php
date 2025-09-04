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
        <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S./No.</th>
                <th>Old URL</th>
                <th>New URL</th>
                <th>Status Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redirects as $redirect)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $redirect->old_url }} <br>
                        <ul class="action d-inline-flex align-items-center gap-2 ms-2" style="list-style:none; padding:0; margin-left:5px;">
                            <li>
                                <a href="{{ route('redirects.edit', $redirect->id) }}">Edit</a>
                            </li>
                            <li><span class="pipe"></span></li>
                            <li>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['redirects.destroy', $redirect->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Delete', [
                                        'onclick'=>"return confirm('Are you sure?')",
                                        'class' => 'btn btn-link text-danger p-0 m-0'
                                    ]) !!}
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </td>
                    <td>{{ $redirect->new_url }}</td>
                    <td>{{ $redirect->status_code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $redirects->links() }}
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
