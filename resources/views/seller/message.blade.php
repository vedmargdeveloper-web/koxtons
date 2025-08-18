@extends('seller.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Messages') }}</div>
                <div class="card-body">

                    @if( session()->has('profile_msg') )
                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                    @endif

                    <div class="message-contaienr" data-perfect-scrollbar="" data-suppress-scroll-x="true">

                        <?php $messages = App\model\Message::where('receiver_id', Auth::id())->orderby('id', 'DESC')->get(); ?>
                        @if( $messages && count( $messages ) > 0 )

                            @foreach( $messages as $message )
                                <div class="message-body {{ $message->seen ? 'read' : 'unread' }}">
                                    <div class="message"> 
                                        <span>{{ $message->message }}</span>
                                    </div>
                                    <div class="message-footer">
                                        @if( !$message->seen )
                                        <div class="message-mark-read">
                                            <a role="button" data-id="{{ $message->id }}" class="mark-read">Mark as read</a>
                                        </div>
                                        @endif
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