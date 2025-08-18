@extends( admin_app() )


@section('content')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.sellers') }}"><span class="fas fa-angle-left"></span></a></li>
        </ol>
    </div>

    <div class="row justify-content-center login-card">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Messages') }} ({{ $messages->count() }})</div>
                <div class="card-body">

                    @if( session()->has('profile_msg') )
                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                    @endif

                    <div class="message-contaienr perfect-scrollbar" data-perfect-scrollbar="" data-suppress-scroll-x="true">

                        @if( $messages && count( $messages ) > 0 )

                            @foreach( $messages as $message )
                                <div class="message-body {{ $message->seen ? 'read' : 'unread' }}">
                                    <div class="message"> 
                                        <span>{{ $message->message }}</span>
                                    </div>
                                    <div class="message-footer">
                                        
                                        <div class="message-date">{{ time_elapsed_string( $message->created_at ) }}</div>
                                    </div>
                                </div>
                            @endforeach

                        @endif

                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection