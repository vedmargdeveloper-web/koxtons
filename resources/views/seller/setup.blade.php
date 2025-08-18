@extends('gift.app.app')

@section('content')


<?php $step = Input::has('s') ? Input::get('s') : ''; ?>

<!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Page Content -->
        <section class="content-page">
            <div class="container">
                <div class="row form-wrapper">
                    <div class="col-md-12 form-container">
                        <div class="form-border-box">

                            @if( $user )

                                @if( $step === 'document' && isset($user->userdetail[0]->mobile) && $user->userdetail[0]->mobile )

                                    <form method="POST" action="{{ route('seller.document') }}" data-id="{{ $user->uid }}" id="document-form">
                                        {{ csrf_field() }}

                                        <?php $docs = App\model\Document::where('user_id', $user->id)->get(); ?>
                                        <?php $avtar = App\model\Avtar::where('user_id', $user->id)->value('filename'); ?>
                                        @if( session()->has('setup_err') )
                                            <span class="text-warning">{{ session()->get('setup_err') }}</span>
                                        @endif
                                        @if( $errors->has('uid') )
                                            <span class="text-warning">{{ $errors->first('uid') }}</span>
                                        @endif

                                        <div class="">
                                            <h3>Upload Documents</h3>
                                            <div class="row form-group">
                                                <div class="col-md-4">Upload Profile Pic *</div>
                                                <div class="col-md-4">
                                                    <input type="file" name="avtar" id="document">
                                                    @if( $errors->has('avtar') )
                                                        <span style="display: block;" class="text-warning">{{ $errors->first('avtar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    @if( $avtar )
                                                        <img id="avtar" style="width: 150px;" class="img-thumbnail" src="{{ asset('public/images/avtars/'.$avtar) }}">
                                                    @else
                                                        <img id="avtar" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-4">Upload Signature *</div>
                                                <div class="col-md-4">
                                                    <input type="file" name="signature" id="document">
                                                    @if( $errors->has('signature') )
                                                        <span style="display: block;" class="text-warning">{{ $errors->first('signature') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <?php $signature = $docs->where('name', 'signature')->first(); ?>
                                                    @if( $signature )
                                                        <img id="signature" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$signature->filename) }}">
                                                    @else
                                                        <img id="signature" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-4">Upload PAN Card *</div>
                                                <div class="col-md-4">
                                                    <input type="file" name="pancard" id="document">
                                                    @if( $errors->has('pancard') )
                                                        <span style="display: block;" class="text-warning">{{ $errors->first('pancard') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <?php $pancard = $docs->where('name', 'pancard')->first(); ?>
                                                    @if( $pancard )
                                                        <img id="pancard" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$pancard->filename) }}">
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
                                                    @if( $errors->has('aadhar') )
                                                        <span style="display: block;" class="text-warning">{{ $errors->first('aadhar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <?php $aadhar = $docs->where('name', 'aadhar')->first(); ?>
                                                    @if( $aadhar )
                                                        <img id="aadhar" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$aadhar->filename) }}">
                                                    @else
                                                        <img id="aadhar" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-4">Upload Bank Passbook *</div>
                                                <div class="col-md-4">
                                                    <input type="file" name="passbook" id="document">
                                                    @if( $errors->has('passbook') )
                                                        <span style="display: block;" class="text-warning">{{ $errors->first('passbook') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <?php $passbook = $docs->where('name', 'passbook')->first(); ?>
                                                    @if( $passbook )
                                                        <img id="passbook" style="width: 150px;" class="img-thumbnail" src="{{ asset('storage/app/public/'.$passbook->filename) }}">
                                                    @else
                                                        <img id="passbook" style="width: 150px;" class="img-thumbnail" src="http://placehold.it/150x150">
                                                    @endif
                                                </div>
                                                <input type="hidden" name="uid" value="{{ $user->uid }}">
                                            </div>

                                            <div class="form-field-wrapper mt-3 text-center">
                                                <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Final Submit" type="submit">
                                            </div>
                                        </div>

                                    </form>


                                @else

                                    <form class="form-horizontal" method="POST" action="{{ route('seller.setup.store') }}">
                                        {{ csrf_field() }}
                                        
                                        <h2 class="normal text-center"><span>Setup Profile</span></h2>
                                        <p>Join and start selling your products.</p>
                                        @if( session()->has('setup_err') )
                                            <span class="text-warning">{{ session()->get('setup_err') }}</span>
                                        @endif
                                        @if( $errors->has('uid') )
                                            <span class="text-warning">{{ $errors->first('uid') }}</span>
                                        @endif
                                        <div class="form-section">
                                            <h3>Contact Details</h3>
                                            <div class="row">
                                                <?php 
                                                        $phone = '';
                                                        if( old('phone') )
                                                            $phone = old('phone');
                                                        else if( isset($user->userdetail[0]->mobile) )
                                                            $phone = $user->userdetail[0]->mobile;
                                                    ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-field-wrapper {{ $errors->has('phone') ? ' has-error' : '' }}">
                                                        <label for="phone">Phone no.<span class="required">*</span></label>
                                                        <input id="phone" class="input-md form-full-width" name="phone" placeholder="+917500996633" value="{{ $phone }}" aria-required="true">
                                                        @if ($errors->has('phone'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <?php 
                                                        $alternate = '';
                                                        if( old('alternate') )
                                                            $alternate = old('alternate');
                                                        else if( isset($user->userdetail[0]->alternate) )
                                                            $alternate = $user->userdetail[0]->alternate;
                                                    ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-field-wrapper {{ $errors->has('phone') ? ' has-error' : '' }}">
                                                        <label for="alternate">Alternate no.<span class="required">*</span></label>
                                                        <input id="alternate" class="input-md form-full-width" name="alternate" placeholder="+917500996633" value="{{ $alternate }}" aria-required="true">
                                                        @if ($errors->has('alternate'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('alternate') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
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
                                                        else if( isset($user->userdetail[0]->country) )
                                                            $country_id = $user->userdetail[0]->country;
                                                    ?>
                                                    
                                                    <select name="country" class="input-md form-full-width" id="tdcountry">
                                                        <option value="">Select</option>
                                                        @if( $countries && count( $countries ) > 0 )
                                                            @foreach( $countries as $country )
                                                                <option {{ $country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('country'))
                                                        <span class="alert-warning" role="alert">
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
                                                    <select name="state" class="input-md form-full-width" id="tdstate">
                                                        <option value="{{ $state_id }}">Select</option>
                                                    </select>
                                                    @if ($errors->has('state'))
                                                        <span class="alert-warning" role="alert">
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
                                                    <select name="city" class="input-md form-full-width" id="tdcity">
                                                        <option value="{{ $city_id }}">Select</option>
                                                    </select>
                                                    @if ($errors->has('city'))
                                                        <span class="alert-warning" role="alert">
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
                                                        else if( isset($user->userdetail[0]->address) )
                                                            $address = $user->userdetail[0]->address;
                                                    ?>
                                                    <label>Address</label>
                                                    <input type="text" placeholder="D-119, Metro Plaza" value="{{ $address }}" name="address" class="input-md form-full-width">
                                                    @if ($errors->has('address'))
                                                        <span class="alert-warning" role="alert">
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
                                                    <input type="text" name="landmark" placeholder="HRS Chowk" value="{{ $landmark }}" class="input-md form-full-width">
                                                    @if ($errors->has('landmark'))
                                                        <span class="alert-warning" role="alert">
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
                                                    <input type="text" name="pincode" placeholder="250002" value="{{ $pincode }}" class="input-md form-full-width">
                                                    @if ($errors->has('pincode'))
                                                        <span class="alert-warning" role="alert">
                                                            <strong>{{ $errors->first('pincode') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h3>GST No.</h3>
                                            <div class="row">
                                                <?php 
                                                        $gst = '';
                                                        if( old('gst') )
                                                            $gst = old('gst');
                                                        else if( isset($user->userdetail[0]->gst) )
                                                            $gst = $user->userdetail[0]->gst;
                                                    ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-field-wrapper {{ $errors->has('gst') ? ' has-error' : '' }}">
                                                        <label for="gst">Enter GST no. <span class="required">*</span></label>
                                                        <input id="gst" placeholder="43238498489" class="input-md form-full-width" name="gst" placeholder="Enter GST nol." value="{{ $gst }}" aria-required="true">
                                                        @if ($errors->has('gst'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('gst') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h3>Account Details</h3>
                                            <div class="row">
                                                <?php 
                                                        $account_holder_name = '';
                                                        if( old('account_holder_name') )
                                                            $account_holder_name = old('account_holder_name');
                                                        else if( isset($user->userdetail[0]->account_holder_name) )
                                                            $account_holder_name = $user->userdetail[0]->account_holder_name;
                                                    ?>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                     <div class="form-field-wrapper {{ $errors->has('account_holder_name') ? ' has-error' : '' }}">
                                                        <label for="account_holder_name">Account holder name <span class="required">*</span></label>
                                                        <input id="account_holder_name" class="input-md form-full-width" name="account_holder_name" placeholder="Account holder name" value="{{ $account_holder_name }}" aria-required="true">
                                                        @if ($errors->has('account_holder_name'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('account_holder_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <?php 
                                                        $bank_name = '';
                                                        if( old('bank_name') )
                                                            $bank_name = old('bank_name');
                                                        else if( isset($user->userdetail[0]->bank_name) )
                                                            $bank_name = $user->userdetail[0]->bank_name;
                                                    ?>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                     <div class="form-field-wrapper {{ $errors->has('bank_name') ? ' has-error' : '' }}">
                                                        <label for="bank_name">Bank name <span class="required">*</span></label>
                                                        <input id="bank_name" class="input-md form-full-width" name="bank_name" placeholder="Bank name" value="{{ $bank_name }}" aria-required="true">
                                                        @if ($errors->has('bank_name'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('bank_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <?php 
                                                        $account_no = '';
                                                        if( old('account_no') )
                                                            $account_no = old('account_no');
                                                        else if( isset($user->userdetail[0]->account_no) )
                                                            $account_no = $user->userdetail[0]->account_no;
                                                    ?>
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                     <div class="form-field-wrapper {{ $errors->has('account_no') ? ' has-error' : '' }}">
                                                        <label for="account_no">Enter account no. <span class="required">*</span></label>
                                                        <input id="account_no" class="input-md form-full-width" name="account_no" placeholder="Account no" value="{{ $account_no }}" aria-required="true">
                                                        @if ($errors->has('account_no'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('account_no') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="uid" value="{{ $user->uid }}">
                                            </div>
                                            <div class="row">
                                                <?php 
                                                        $bank_ifsc = '';
                                                        if( old('bank_ifsc') )
                                                            $bank_ifsc = old('bank_ifsc');
                                                        else if( isset($user->userdetail[0]->bank_ifsc) )
                                                            $bank_ifsc = $user->userdetail[0]->bank_ifsc;
                                                    ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                     <div class="form-field-wrapper {{ $errors->has('bank_ifsc') ? ' has-error' : '' }}">
                                                        <label for="bank_ifsc">Enter IFSC code <span class="required">*</span></label>
                                                        <input id="bank_ifsc" class="input-md form-full-width" name="bank_ifsc" placeholder="IFSC code" value="{{ $bank_ifsc }}" aria-required="true">
                                                        @if ($errors->has('bank_ifsc'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('bank_ifsc') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <?php 
                                                        $bank_address = '';
                                                        if( old('bank_address') )
                                                            $bank_address = old('bank_address');
                                                        else if( isset($user->userdetail[0]->bank_address) )
                                                            $bank_address = $user->userdetail[0]->bank_address;
                                                    ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                     <div class="form-field-wrapper {{ $errors->has('bank_address') ? ' has-error' : '' }}">
                                                        <label for="bank_address">Bank address <span class="required">*</span></label>
                                                        <input id="bank_address" class="input-md form-full-width" name="bank_address" placeholder="Bank address" value="{{ $bank_address }}" aria-required="true">
                                                        @if ($errors->has('bank_address'))
                                                            <span class="alert-warning">
                                                                <strong>{{ $errors->first('bank_address') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-field-wrapper text-right">
                                            <input name="submit" id="submit" class="submit btn btn-md btn-primary" value="Continue" type="submit">
                                        </div>

                                    </form>

                                
                                @endif

                            @else
                                <div class="text-center">
                                    <p>No details found!</p>
                                    <p class="text-center">Go <a href="{{ url('/') }}">Home</a></p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Content -->

    </div>
    <!-- End Page Content Wraper -->


@endsection