@extends('seller.app')


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
                <div class="card-header">{{ __('Contact Details') }}</div>
                <div class="card-body">

                    <?php $userdetail = App\model\UserDetail::where('user_id', Auth::id())->first(); ?>

                    @if( session()->has('profile_msg') )
                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                    @endif

                    {{ Form::open(['url' => route('user.contact')]) }}

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <label>Mobile no. *</label>
                                    <?php $mobile = '';
                                        if(old('mobile') )
                                            $mobile = old('mobile');
                                        elseif( isset($userdetail->mobile) )
                                            $mobile = $userdetail->mobile;
                                    ?>
                                      <input id="mobile" type="tel" placeholder="" value="{{ $mobile }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="mobile" required>
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <label>Alternate no. *</label>
                                    
                                    <?php $alternate = '';
                                        if(old('alternate') )
                                            $alternate = old('alternate');
                                        elseif( isset($userdetail->alternate) )
                                            $alternate = $userdetail->alternate;
                                    ?>
                                      <input id="alternate" type="tel" placeholder="" value="{{ $alternate }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="alternate" required>
                                    


                                    @if ($errors->has('alternate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('alternate') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                    <label>Country *</label>
                                    <?php $countries = App\model\Country::all(); ?>
                                    <?php 
                                        $country_id = '';
                                        if( old('country') )
                                            $country_id = old('country');
                                        else if( isset($userdetail->country) )
                                            $country_id = $userdetail->country;
                                    ?>
                                    @if( $countries && count( $countries ) > 0 )
                                        <select name="country" class="form-control" id="countries">
                                            <option value="">Select</option>
                                            @foreach( $countries as $country )
                                                <option {{ $country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback" role="alert">
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
                                        else if( isset($userdetail->state) )
                                            $state_id = $userdetail->state;
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
                                    <?php 
                                        $city_id = '';
                                        if( old('city') )
                                            $city_id = old('city');
                                        else if( isset($userdetail->city) )
                                            $city_id = $userdetail->city;
                                    ?>
                                    <label>City *</label>
                                    <select name="city" class="form-control" id="cities">
                                        <option value="{{ $city_id }}">Select</option>
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6 form-group">
                                    <?php 
                                        $address = '';
                                        if( old('address') )
                                            $address = old('address');
                                        else if( isset($userdetail->address) )
                                            $address = $userdetail->address;
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
                                        else if( isset($userdetail->landmark) )
                                            $landmark = $userdetail->landmark;
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
                                        else if( isset($userdetail->pincode) )
                                            $pincode = $userdetail->pincode;
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

                        <button class="btn btn-primary">Update</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection