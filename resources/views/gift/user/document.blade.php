@extends('gift.user.app.app')

@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card">
		
		<div class="col-md-8">
			<div class="card">
                <div class="card-header">
                    <div class="card-title">{{ __($title) }}</div>
                </div>

                <div class="card-body">
                	<div class="section-panel mb-3">
                        <h4>Upload photo for the following:</h4>
                        <div class="row form-group">
                            <div class="col-md-4">Upload Profile Pic *</div>
                            <div class="col-md-4">
                                <input type="file" name="avtar" id="document">
                                @if( session()->has('avtar') )
                                    <span class="text-warning">{{ session()->get('avtar') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if( isset( $user->avtar[0]->filename ) )
                                    <img id="avtar" style="width: 150px;" class="img-thumbnail" src="{{ asset('public/images/avtars/'.$user->avtar[0]->filename) }}">
                                @else
                                    <img id="avtar" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Upload Signature *</div>
                            <div class="col-md-4">
                                <input type="file" name="signature" id="document">
                                @if( session()->has('signature') )
                                    <span class="text-warning">{{ session()->get('signature') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <?php $signature = $user->document->where('name', 'signature')->first(); ?>
                                @if( $signature )
                                    <p class="text-warning">{{ ucfirst($signature->status) }}</p>
                                    <img id="signature" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$signature->filename) }}">
                                    <p class="text-warning">{{ $signature->remark }}</p>
                                @else
                                    <img id="signature" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Upload PAN Card *</div>
                            <div class="col-md-4">
                                <input type="file" name="pancard" id="document">
                                @if( session()->has('pancard') )
                                    <span class="text-warning">{{ session()->get('pancard') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <?php $pancard = $user->document->where('name', 'pancard')->first(); ?>
                                @if( $pancard )
                                    <p class="text-warning">{{ ucfirst($pancard->status) }}</p>
                                    <img id="pancard" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$pancard->filename) }}">
                                    <p class="text-warning">{{ $pancard->remark }}</p>
                                @else
                                    <img id="pancard" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                @endif
                            </div>
                            <input type="hidden" name="step" value="document">
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Upload Aadhar Card *</div>
                            <div class="col-md-4">
                                <input type="file" name="aadhar" id="document">
                                @if( session()->has('aadhar') )
                                    <span class="text-warning">{{ session()->get('aadhar') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <?php $aadhar = $user->document->where('name', 'aadhar')->first(); ?>
                                @if( $aadhar )
                                    <p class="text-warning">{{ ucfirst($aadhar->status) }}</p>
                                    <img id="aadhar" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$aadhar->filename) }}">
                                    <p class="text-warning">{{ $aadhar->remark }}</p>
                                @else
                                    <img id="aadhar" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Upload Bank Passbook *</div>
                            <div class="col-md-4">
                                <input type="file" name="passbook" id="document">
                                @if( session()->has('passbook') )
                                    <span class="text-warning">{{ session()->get('passbook') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <?php $passbook = $user->document->where('name', 'passbook')->first(); ?>
                                @if( $passbook )
                                    <p class="text-warning">{{ ucfirst($passbook->status) }}</p>
                                    <img id="passbook" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$passbook->filename) }}">
                                    <p class="text-warning">{{ $passbook->remark }}</p>
                                @else
                                    <img id="passbook" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                @endif
                            </div>
                            <input type="hidden" name="uid" value="{{ $user->uid }}">
                        </div>
                    </div>
                </div>
            </div>
		</div>

    </div>

@endsection