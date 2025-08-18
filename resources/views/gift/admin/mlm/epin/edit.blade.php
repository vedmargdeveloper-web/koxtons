@extends('gift.admin.mlm.app')

@section('content')

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 offset-3">


            @if( $epin )

            <form method="POST" class="epin-creation-form" action="{{ route('mlm.epin.update', $epin->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH')}}

                <input type="hidden" name="step" value="admin-epin">

                <div class="card">
                    <div class="card-header">{{ $title }}</div>

                    <div class="card-body">
                    
                        @if( Session::has('member_err') )
                            <span class="text-warning">{{ Session::get('member_err') }}</span>
                        @endif

                        @if( Session::has('epin_msg') )
                            <span class="text-success">{{ Session::get('epin_msg') }}</span>
                        @endif

                        <div class="section-panel mb-3">
                            <h5>Epin Details</h5>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>Reference ID *</label>
                                    <input id="reference" type="text" class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="Reference ID" name="reference" value="{{ old('reference') ? old('reference') : $epin->user[0]->username }}" autofocus>

                                    @if ($errors->has('reference'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('reference') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                    <label>Package *</label>
                                    <input id="package" type="text" class="form-control{{ $errors->has('package') ? ' is-invalid' : '' }}" name="package" data-value="10000" value="Rs. 10000" required readonly>
                                    @if ($errors->has('package'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('package') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                    <label>No. of Epin *</label>
                                    <input id="epins" type="text" class="form-control{{ $errors->has('epins') ? ' is-invalid' : '' }}" placeholder="No. of Epin" name="epins" value="{{ old('epins') ? old('epins') : $epin->epins }}" required autofocus>
                                    @if ($errors->has('epins'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('epins') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-4 col-xs-4 form-group">
                                    <label>Total Amount *</label>
                                    <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') ? old('amount') : $epin->amount }}" required readonly>
                                    @if ($errors->has('amount'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="section-panel mb-3">
                            <h5>Payment Details</h5>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <label>Payment mode *</label>
                                    <?php $payment_mode = old("payment_mode") ? old("payment_mode") : $epin->payment_mode; ?>
                                    <select name="payment_mode" class="form-control payment-mode">
                                        <option value="">Select</option>
                                        <option {{ $payment_mode == 'cash' ? 'selected' : '' }} value="cash">Cash</option>
                                        <option {{ $payment_mode == 'neft' ? 'selected' : '' }} value="neft">NEFT</option>
                                        <option {{ $payment_mode == 'imps' ? 'selected' : '' }} value="imps">IMPS</option>
                                        <option {{ $payment_mode == 'netbanking' ? 'selected' : '' }} value="netbanking">Net Banking</option>
                                    </select>
                                    @if ($errors->has('payment_mode'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('payment_mode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12 form-group">
                                    <label>Payment Date *</label>
                                    <?php $payment_date = old("payment_date") ? old("payment_date") : $epin->payment_date; ?>
                                    <input id="payment_date" type="text" class="datepicker form-control{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" name="payment_date" placeholder="{{ date('d/m/Y') }}" value="{{ $payment_date ? $payment_date : date('d/m/Y') }}" required autofocus>
                                    @if ($errors->has('payment_date'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('payment_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" rows="2" name="remark">{{ old('remark') ? old('remark') : $epin->remark }}</textarea>
                                    @if ($errors->has('amount'))
                                        <span class="text-warning" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row otherfields"></div>
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
