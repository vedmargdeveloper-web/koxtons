@extends('gift.user.app.app')


@section('title', 'Member List')

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>Member</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">

    	<div class="col-md-12">
            <a title="Go Back" href="{{ route('member.network') }}"><span class="fas fa-angle-left"></span></a>
            <a title="Add Member" href="{{ route('member.create', 'create') }}"><span class="fas fa-user-plus"></span></a>
           
    		<div class="card">
                <div class="card-header">{{ __('Member Details') }}</div>

                <div class="card-body">
                    <h3>Member</h3>
                	<table class="table table-bordered">
                		<tbody>
                			@if( $user )
            					<tr>
                                    <th>Reference ID</th>
                                    <td>{{ strtoupper($user->ref_id) }}</td>
                                </tr>
                                <tr>
                                    <th>Epin ID</th>
                                    <td>{{ strtoupper($user->epin_id) }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
            						<td>{{ strtoupper($user->username) }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
            						<td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
                                </tr>
                                <tr style="display:none">
                                    <th>Email</th>
            						<td>{{-- {{ $user->email }} --}}</td>
                                </tr>
                                <tr>
                                    <th>Joined At</th>
            						<td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Profile Pic</th>
                                    <td>
                                        @if( isset($user->avtar[0]->filename) )
                                            <img id="avtar" style="width: 150px;" class="img-thumbnail" src="{{ asset('public/images/avtars/'.$user->avtar[0]->filename) }}">
                                        @else
                                            <img id="avtar" class="img-thumbnail" src="http://placehold.it/150x150">
                                        @endif
                                    </td>
                                </tr>
                			@endif
                		</tbody>
                	</table>
              	</div>

                <div class="card-body" style="display:none;">
                    <h3>Contact Details</h3>
                    <table class="table table-bordered">
                        <tbody>
                            {{-- @if( $user->userdetail && count( $user->userdetail ) > 0 )
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ strtoupper($user->userdetail[0]->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ App\model\City::where('id', $user->userdetail[0]->city)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ App\model\State::where('id', $user->userdetail[0]->state)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ App\model\Country::where('id', $user->userdetail[0]->country)->value('name') }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $user->userdetail[0]->address }}</td>
                                </tr>
                                <tr>
                                    <th>Landmark</th>
                                    <td>{{ $user->userdetail[0]->landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Pincode</th>
                                    <td>{{ $user->userdetail[0]->pincode }}</td>
                                </tr>
                                <tr style="display:none">
                                    <th>Mobile</th>
                                    <td>{{ $user->userdetail[0]->phonecode.'-'.$user->userdetail[0]->mobile }}</td>
                                </tr>
                            @endif --}}
                        </tbody>
                    </table>
                </div>

                <div class="card-body" style="display:none;">
                    <h3>Bank Details</h3>
                    <table class="table table-bordered">
                        <tbody>
                            {{-- @if( $user->userdetail && count( $user->userdetail ) > 0 )
                                <tr>
                                    <th>Bank Name</th>
                                    <td>{{ $user->userdetail[0]->bank_name }}</td>
                                </tr>
                                <tr>
                                    <th>Account Holder Name</th>
                                    <td>{{ $user->userdetail[0]->account_holder_name }}</td>
                                </tr>
                                <tr>
                                    <th>Account No</th>
                                    <td>{{ $user->userdetail[0]->account_no }}</td>
                                </tr>
                                <tr>
                                    <th>Bank IFSC</th>
                                    <td>{{ $user->userdetail[0]->bank_ifsc }}</td>
                                </tr>
                                <tr>
                                    <th>Bank Address</th>
                                    <td>{{ $user->userdetail[0]->bank_address }}</td>
                                </tr>

                            @endif --}}
                        </tbody>
                    </table>
                </div>

                <div class="card-body" style="display:none;">
                    <h3>Documents</h3>
                    <table class="table table-bordered">
                        <tbody>
                            {{-- @if( $user->document && count( $user->document ) > 0 )

                                @foreach( $user->document as $doc )
                                    <tr>
                                        <th>{{ ucfirst($doc->name) }}</th>
                                        <td>
                                            @if( $doc->filename )
                                                <img id="signature" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$doc->filename) }}">
                                            @else
                                                <img id="avtar" class="img-thumbnail" src="http://placehold.it/150x150">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif --}}
                        </tbody>
                    </table>
                </div>

            </div>
    	</div>
    </div>

@endsection