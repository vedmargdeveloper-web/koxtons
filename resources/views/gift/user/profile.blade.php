@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>
                <div class="card-body">

                    @if( session()->has('profile_msg') )
                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                    @endif

                    {{ Form::open(['url' => route('user.edit')]) }}

                        <div class="form-group text-center">
                            <div class="user-image">
                                <?php $filename = App\model\Avtar::where('user_id', Auth::id())->value('filename'); ?>
                                @if( $filename )
                                    <img id="profile-image" class="img-circle" src="{{ asset('public/images/avtars/' . thumb( $filename, 120, 120 ) ) }}">
                                @else
                                    <img id="profile-image" class="img-circle" src="http://placehold.it/120/120">
                                @endif
                                <div class="button-wrapper">
                                    <input type="file" name="file" id="uploadFile" style="display: none;">
                                    <a role="button" class="btn btn-default btn-upload-profile">Upload</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>First name</label>
                            <input type="text" class="form-control" value="{{ Input::old('first_name') ? Input::old('first_name') : Auth::user()->first_name }}" name="first_name" placeholder="Andy">
                            @if( $errors->has('first_name') )
                                <span class="text-warning">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Last name</label>
                            <input type="text" class="form-control" value="{{ Input::old('last_name') ? Input::old('last_name') : 
                            Auth::user()->last_name }}" name="last_name" placeholder="Sandy">
                            @if( $errors->has('last_name') )
                                <span class="text-warning">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ Input::old('email') ? Input::old('email') : Auth::user()->email }}" name="email" placeholder="xyz@example.com">
                            @if( $errors->has('email') )
                                <span class="text-warning">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-primary">Update</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection