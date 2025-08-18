@extends('gift.user.app.app')


@section('title', 'Add Member')

@section('fix-nav', 'nav-fixed')

@section('content')


<?php $uid = Input::has('uid') ? Input::get('uid') : ''; ?>
<?php $step = Input::has('s') ? Input::get('s') : ''; ?>
<?php $side = Input::has('side') ? Input::get('side') : ''; ?>

        <div class="breadcrumb">
            <h1>Add Member</h1>
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row justify-content-center login-card">

            @if( !$uid )

            <div class="col-md-5">

                <form method="POST" id="member-creation-form" action="{{ route('member.store') }}">
                {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">{{ __('Add Member') }}</div>

                        <div class="card-body">
                        

                            @if( Session::has('member_err') )
                                <span class="text-warning">{{ Session::get('member_err') }}</span>
                            @endif

                            <div class="section-panel">

                                <input type="hidden" name="step" value="create">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <label>Reference ID *</label>
                                        <input id="reference" type="text" class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="Reference ID" name="reference" value="{{ old('reference') }}" required autofocus>

                                        @if ($errors->has('reference'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('reference') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <label>EPIN ID *</label>
                                        <input id="epin_id" type="text" class="form-control{{ $errors->has('epin_id') ? ' is-invalid' : '' }}" placeholder="EPIN ID" name="epin_id" value="{{ old('epin_id') }}" autofocus>

                                        @if ($errors->has('epin_id'))
                                            <span class="text-warning" role="alert">
                                                <strong>{{ $errors->first('epin_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row" style="display: none;">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <label>Side *</label>
                                        <?php $side = old('side') ? old('side') : $side; ?>
                                        <br>
                                        <div>
                                            <input {{ $side == 'left' ? 'checked' : '' }} type="radio" class="tree-side" name="side" value="left" id="left"> 
                                            <label for="left">Left</label>
                                            <input {{ $side == 'right' ? 'checked' : '' }} class="ml-3 tree-side" type="radio" name="side" value="right" id="right"> 
                                            <label for="right">Right</label>
                                        </div>
                                        @if ($errors->has('side'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('side') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                        <label>First name *</label>
                                        <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="First name" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                        <label>Last name *</label>
                                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Last name" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <label>Email address *</label>
                                        <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <label>Password *</label>
                                        <input id="password" type="password" placeholder="********" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                        <div>
                                            <input {{ old('tnc') ? 'checked' : '' }} type="checkbox" id="checkbox" name="tnc" value="1"> 
                                            <label for="checkbox">By clicking your accept the terms & conditions.</label>
                                        </div>

                                        @if ($errors->has('tnc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tnc') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </form>

            </div>

        @endif

        <?php $user = $uid ? App\User::with('userdetail')->where('uid', $uid)->first() : false; ?>


        @if( $uid && $user && $step === 'contact' )

            <div class="col-md-8">

                <form method="POST" action="{{ route('member.store') }}">
                {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('Contact & Bank Details') }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="section-panel mb-3">
                                <h4>Contact Details</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                        <label>Gender *</label>
                                        <?php $gender = '';
                                            if(old('gender') )
                                                $gender = old('gender');
                                            elseif( isset($user->userdetail[0]->gender) )
                                                $gender = $user->userdetail[0]->gender;
                                        ?>
                                        <select name="gender" class="form-control">
                                            <option value="">Select</option>
                                            <option {{ $gender == 'm' ? 'selected' : ''  }} value="m">Male</option>
                                            <option {{ $gender == 'f' ? 'selected' : ''  }} value="f">Female</option>
                                            <option {{ $gender == 'o' ? 'selected' : ''  }} value="o">Other</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                        <label>Mobile no. *</label>
                                        <div class="input-group">
                                        <?php $phonecode = '';
                                            if(old('code') )
                                                $phonecode = old('code');
                                            elseif( isset($user->userdetail[0]->phonecode) )
                                                $phonecode = $user->userdetail[0]->phonecode;
                                        ?>
                                        <?php $countries = App\model\Country::all(); ?>
                                        @if( $countries && count( $countries ) > 0 )
                                            <div class="input-group-prepend">
                                                <select name="code">
                                                @foreach( $countries as $country )
                                                    <option {{ $phonecode == $country->phonecode ? 'selected' : '' }} value="{{ $country->phonecode }}">{{ $country->phonecode }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <?php $mobile = '';
                                            if(old('mobile') )
                                                $mobile = old('mobile');
                                            elseif( isset($user->userdetail[0]->mobile) )
                                                $mobile = $user->userdetail[0]->mobile;
                                        ?>
                                          <input id="mobile" type="tel" placeholder="" value="{{ $mobile }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="mobile" required>
                                        </div>

                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif

                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                        <label>Country *</label>
                                        <?php 
                                            $country_id = '';
                                            if( old('country') )
                                                $country_id = old('country');
                                            else if( isset($user->userdetail[0]->country) )
                                                $country_id = $user->userdetail[0]->country;
                                        ?>
                                        
                                        <select name="country" class="form-control" id="countries">
                                            <option value="">Select</option>
                                            @if( $countries && count( $countries ) > 0 )
                                                @foreach( $countries as $country )
                                                    <option {{ $country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                        <label>State *</label>
                                        <?php 
                                            $state_id = '';
                                            if( old('state') )
                                                $state_id = old('state');
                                            else if( isset($user->userdetail[0]->state) )
                                                $state_id = $user->userdetail[0]->state;
                                        ?>
                                        <select name="state" class="form-control" id="states">
                                            <option value="{{ $state_id }}">Select</option>
                                        </select>
                                        @if ($errors->has('state'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                        <label>City *</label>
                                        <?php 
                                            $city_id = '';
                                            if( old('city') )
                                                $city_id = old('city');
                                            else if( isset($user->userdetail[0]->city) )
                                                $city_id = $user->userdetail[0]->city;
                                        ?>
                                        <select name="city" class="form-control" id="cities">
                                            <option value="{{ $city_id }}">Select</option>
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="uid" value="{{ $uid }}">
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                        <?php 
                                            $address = '';
                                            if( old('address') )
                                                $address = old('address');
                                            else if( isset($user->userdetail[0]->address) )
                                                $address = $user->userdetail[0]->address;
                                        ?>
                                        <label>Address</label>
                                        <input type="text" value="{{ $address }}" name="address" class="form-control">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                        <?php 
                                            $landmark = '';
                                            if( old('landmark') )
                                                $landmark = old('landmark');
                                            else if( isset($user->userdetail[0]->landmark) )
                                                $landmark = $user->userdetail[0]->landmark;
                                        ?>
                                        <label>Landmark</label>
                                        <input type="text" name="landmark" value="{{ $landmark }}" class="form-control">
                                        @if ($errors->has('landmark'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('landmark') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                        <?php 
                                            $pincode = '';
                                            if( old('pincode') )
                                                $pincode = old('pincode');
                                            else if( isset($user->userdetail[0]->pincode) )
                                                $pincode = $user->userdetail[0]->pincode;
                                        ?>
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" value="{{ $pincode }}" class="form-control">
                                        @if ($errors->has('pincode'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pincode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="step" value="contact">
                            
                            </div>


                            <div class="section-panel">
                                <h4>Bank Details</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                        <?php 
                                            $bank_name = '';
                                            if( old('bank_name') )
                                                $bank_name = old('bank_name');
                                            else if( isset($user->userdetail[0]->bank_name) )
                                                $bank_name = $user->userdetail[0]->bank_name;
                                        ?>
                                        <label>Bank name</label>
                                        <input type="text" name="bank_name" value="{{ $bank_name }}" class="form-control">
                                        @if ($errors->has('bank_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bank_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                        <?php 
                                            $account_holder_name = '';
                                            if( old('account_holder_name') )
                                                $account_holder_name = old('account_holder_name');
                                            else if( isset($user->userdetail[0]->account_holder_name) )
                                                $account_holder_name = $user->userdetail[0]->account_holder_name;
                                        ?>
                                        <label>Account holder name</label>
                                        <input type="text" name="account_holder_name" value="{{ $account_holder_name }}" class="form-control">
                                        @if ($errors->has('account_holder_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('account_holder_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                        <?php 
                                            $account_no = '';
                                            if( old('account_no') )
                                                $account_no = old('account_no');
                                            else if( isset($user->userdetail[0]->account_no) )
                                                $account_no = $user->userdetail[0]->account_no;
                                        ?>
                                        <label>Account no</label>
                                        <input type="text" name="account_no" value="{{ $account_no }}" class="form-control">
                                        @if ($errors->has('account_no'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('account_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                        <?php 
                                            $bank_ifsc = '';
                                            if( old('bank_ifsc') )
                                                $bank_ifsc = old('bank_ifsc');
                                            else if( isset($user->userdetail[0]->bank_ifsc) )
                                                $bank_ifsc = $user->userdetail[0]->bank_ifsc;
                                        ?>
                                        <label>Bank IFSC Code</label>
                                        <input type="text" name="bank_ifsc" value="{{ $bank_ifsc }}" class="form-control">
                                        @if ($errors->has('bank_ifsc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bank_ifsc') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                        <?php 
                                            $bank_address = '';
                                            if( old('bank_address') )
                                                $bank_address = old('bank_address');
                                            else if( isset($user->userdetail[0]->bank_address) )
                                                $bank_address = $user->userdetail[0]->bank_address;
                                        ?>
                                        <label>Bank Address</label>
                                        <input type="text" name="bank_address" value="{{ $bank_address }}" class="form-control">
                                        @if ($errors->has('bank_address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bank_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary step-2">
                                        {{ __('Continue') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        @endif


        <?php $user = $uid ? App\User::where('uid', $uid)->first() : false; ?>


        @if( $uid && $user && $step === 'document' )

            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Upload Documents') }}</h3>
                        {{ Form::open(['url' => route('member.create', 'create'), 'method' => 'GET']) }}
                            <input type="hidden" name="uid" value="{{ $uid }}">
                            <input type="hidden" name="s" value="contact">
                            <button title="Go Back" class="btn btn-default btn-back">
                                <span class="fa fa-angle-left"></span>
                            </button>
                        {{ Form::close() }}
                    </div>

                    <form method="POST" action="{{ route('member.store') }}" data-id="{{ $uid }}" id="document-form">
                        {{ csrf_field() }}

                        <?php $docs = App\model\Document::where('user_id', $user->id)->get(); ?>
                        <?php $avtar = App\model\Avtar::where('user_id', $user->id)->value('filename'); ?>

                        <div class="card-body">
                            @if( session()->has('member_err') )
                                <span class="text-warning">{{ session()->get('member_err') }}</span>
                            @endif
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
                                        @if( $avtar )
                                            <img id="avtar" style="width: 150px;" class="img-thumbnail" src="{{ asset('public/images/avtars/'.$avtar) }}">
                                        @else
                                            <img id="avtar" class="img-thumbnail" src="http://placehold.it/150x150">
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
                                        <?php $signature = $docs->where('name', 'signature')->first(); ?>
                                        @if( $signature )
                                            <img id="signature" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$signature->filename) }}">
                                        @else
                                            <img id="signature" class="img-thumbnail" src="http://placehold.it/150x150">
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
                                        <?php $pancard = $docs->where('name', 'pancard')->first(); ?>
                                        @if( $pancard )
                                            <img id="pancard" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$pancard->filename) }}">
                                        @else
                                            <img id="pancard" class="img-thumbnail" src="http://placehold.it/150x150">
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
                                        <?php $aadhar = $docs->where('name', 'aadhar')->first(); ?>
                                        @if( $aadhar )
                                            <img id="aadhar" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$aadhar->filename) }}">
                                        @else
                                            <img id="aadhar" class="img-thumbnail" src="http://placehold.it/150x150">
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
                                        <?php $passbook = $docs->where('name', 'passbook')->first(); ?>
                                        @if( $passbook )
                                            <img id="passbook" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$passbook->filename) }}">
                                        @else
                                            <img id="passbook" class="img-thumbnail" src="http://placehold.it/150x150">
                                        @endif
                                    </div>
                                    <input type="hidden" name="uid" value="{{ $uid }}">
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary step-2">
                                            {{ __('Final submit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                
            </div>
        @endif

        </div>


@endsection
