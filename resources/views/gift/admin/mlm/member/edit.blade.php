@extends( 'gift.admin.mlm.app' )


@section('content')
	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('mlm.members') }}"><span class="fas fa-angle-left"></span></a></li>
				<li><a href="{{ route('mlm.member.create', 'create') }}"><span class="fas fa-user-plus"></span></a></li>
			</ol>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">

			@if( $user )
			
			<form method="POST" id="member-creation-form" action="{{ route('mlm.member.update', $user->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('Edit Member') }}</div>
                    </div>

                    <div class="card-body">
                    
                        <div class="col-md-8 offset-2 col-lg-8 col-sm-12 col-xs-12 mb-3">
                        	@if( Session::has('member_err') )
	                            <span class="text-warning">{{ Session::get('member_err') }}</span>
	                        @endif

	                        @if( Session::has('member_msg') )
	                            <span class="text-success">{{ Session::get('member_msg') }}</span>
	                        @endif

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>Reference ID *</label>
                                    <input id="reference" type="text" class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="Reference ID" name="reference" value="{{ old('reference') ? old('reference') : $user->ref_id }}" autofocus>

                                    @if ($errors->has('reference'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('reference') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>EPIN ID *</label>
                                    @if( $user->epin_id )
                                        <input id="epin_id" type="text" class="form-control{{ $errors->has('epin_id') ? ' is-invalid' : '' }}" placeholder="EPIN ID" name="epin_id" value="{{ $user->epin_id }}" required readonly>
                                    @else
                                        <input id="epin_id" type="text" class="form-control{{ $errors->has('epin_id') ? ' is-invalid' : '' }}" placeholder="EPIN ID" name="epin_id" value="{{ old('epin_id') ? old("epin_id") : $user->epin_id }}" required>
                                    @endif

                                    @if ($errors->has('epin_id'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('epin_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <label>First name *</label>
                                    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="First name" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" autofocus required>

                                    @if ($errors->has('first_name'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <label>Last name *</label>
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Last name" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" required autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>Email address *</label>
                                    <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ? old('email') : $user->email }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    @if (Session::has('email_err'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ Session::get('email_err') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>Password *</label>
                                    <input id="password" type="password" placeholder="********" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                    @if ($errors->has('password'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>


                        <div class="col-md-8 offset-2 col-lg-8 col-sm-12 col-xs-12 mb-3">
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
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <label>Mobile no. *</label>
                                    
                                    <?php $countries = App\model\Country::all(); ?>
                                    
                                    <?php $mobile = '';
                                        if(old('mobile') )
                                            $mobile = old('mobile');
                                        elseif( isset($user->userdetail[0]->mobile) )
                                            $mobile = $user->userdetail[0]->mobile;
                                    ?>
                                      <input id="mobile" type="tel" placeholder="" value="{{ $mobile }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="mobile" required>
                                    
                                    @if ($errors->has('mobile'))
                                        <span class="text-warning" role="alert">
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
                                    @if( $countries && count( $countries ) > 0 )
                                        <select name="country" class="form-control" id="countries">
                                            <option value="">Select</option>
                                            @foreach( $countries as $country )
                                                <option {{ $country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="text-warning" role="alert">
                                                <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                        @endif
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
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                    <?php 
                                        $city_id = '';
                                        if( old('city') )
                                            $city_id = old('city');
                                        else if( isset($user->userdetail[0]->city) )
                                            $city_id = $user->userdetail[0]->city;
                                    ?>
                                    <label>City *</label>
                                    <select name="city" class="form-control" id="cities">
                                        <option value="{{ $city_id }}">Select</option>
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" name="uid" value="{{ $user->uid }}">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="col-md-8 offset-2 col-lg-8 col-sm-12 col-xs-12 mb-3">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
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
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('bank_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary step-2">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            @endif

		</div>

@endsection