@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="row justify-content-center login-card">
    	<div class="col-md-12">
    		<div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body tree user-tree">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        @if( Session::has('member_msg') )
                            <span class="text-success">{{ Session::get('member_msg') }}</span>
                        @endif
                        @if( Session::has('member_err') )
                            <span class="text-warning">{{ Session::get('member_err') }}</span>
                        @endif
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 text-center user-tree-row">
                        <div class="user-image">
                            <img class="img-circle" src="http://placehold.it/50x50">
                            <div class="user-details-box">
                                <div class="box-inner">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ ucwords(Auth::user()->first_name.' '.Auth::user()->last_name) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td>{{ strtoupper(Auth::user()->username) }}</td>
                                            </tr>
                                            <?php $userdetail = App\model\UserDetail::where('id', Auth::id())->first(); ?>
                                            @if( $userdetail )
                                                <tr>
                                                    <th>Gender</th>
                                                    <td>{{ ucfirst( $userdetail->gender ) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ ucfirst( $userdetail->address.', '.$userdetail->landmark ) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td>{{ App\model\City::where('id', $userdetail->city)->value('name') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td>{{ App\model\State::where('id', $userdetail->state)->value('name') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>County</th>
                                                    <td>{{ App\model\Country::where('id', $userdetail->country)->value('name') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Contact No.</th>
                                                    <td>{{ $userdetail->phonecode.'-'.$userdetail->mobile }}</td>
                                                </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="user-name">
                            <span>{{ strtoupper(Auth::user()->username) }}</span>
                        </div>
                        
                        <div class="underline">
                            <span class="pull-left">Left</span>
                            <span class="pull-right">Right</span>
                        </div>
                    </div>



                    <?php $users = App\User::with('userdetail')->where('ref_id', Auth::user()->username)->get(); $c = 0; ?>

                    @if( $users && count( $users ) > 0 )

                        @foreach( $users as $key => $user )

                            <?php $c++; $left = $right = ''; ?>

                            @if( $user->side === 'left' )
                                <?php $left = $user; ?>
                            @endif

                            @if( $user->side === 'right' )
                                <?php $right = $user; ?>
                            @endif

                            @if( $c == 2 )

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                        @if( $left )
                                            <div class="user-image">
                                                <img class="img-circle" src="http://placehold.it/50x50">
                                                <div class="user-details-box">
                                                    <div class="box-inner">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <td>{{ ucwords($left->first_name.' '.$left->last_name) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Username</th>
                                                                    <td>{{ strtoupper($left->username) }}</td>
                                                                </tr>
                                                                @if( $left->userdetail && count( $left->userdetail ) > 0 )
                                                                    <tr>
                                                                        <th>Gender</th>
                                                                        <td>{{ ucfirst( $left->userdetail[0]->gender ) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Address</th>
                                                                        <td>{{ ucfirst( $left->userdetail[0]->address.', '.$left->userdetail[0]->landmark ) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>City</th>
                                                                        <td>{{ App\model\City::where('id', $left->userdetail[0]->city)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>State</th>
                                                                        <td>{{ App\model\State::where('id', $left->userdetail[0]->state)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>County</th>
                                                                        <td>{{ App\model\Country::where('id', $left->userdetail[0]->country)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Contact No.</th>
                                                                        <td>{{ $left->userdetail[0]->phonecode.'-'.$left->userdetail[0]->mobile }}</td>
                                                                    </tr>

                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="user-name">
                                                <span>{{ strtoupper($left->username) }}</span>
                                            </div>
                                        @else
                                            <a href="{{ route('member.create', 'create?side=left') }}">Add</a>
                                        @endif
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                        @if( $right )
                                            <div class="user-image">
                                                <img class="img-circle" src="http://placehold.it/50x50">
                                                <div class="user-details-box">
                                                    <div class="box-inner">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <td>{{ ucwords($right->first_name.' '.$right->last_name) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Username</th>
                                                                    <td>{{ strtoupper($right->username) }}</td>
                                                                </tr>
                                                                @if( $right->userdetail && count( $right->userdetail ) > 0 )
                                                                    <tr>
                                                                        <th>Gender</th>
                                                                        <td>{{ ucfirst( $right->userdetail[0]->gender ) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Address</th>
                                                                        <td>{{ ucfirst($right->userdetail[0]->address.', '.$right->userdetail[0]->landmark) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>City</th>
                                                                        <td>{{ App\model\City::where('id', $right->userdetail[0]->city)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>State</th>
                                                                        <td>{{ App\model\State::where('id', $right->userdetail[0]->state)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>County</th>
                                                                        <td>{{ App\model\Country::where('id', $right->userdetail[0]->country)->value('name') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Contact No.</th>
                                                                        <td>{{ $right->userdetail[0]->phonecode.'-'.$right->userdetail[0]->mobile }}</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="user-name">
                                                <span>{{ strtoupper($right->username) }}</span>
                                            </div>

                                            <div class="underline">
                                                <span class="pull-left">Left</span>
                                                <span class="pull-right">Right</span>
                                            </div>

                                        @else
                                            <a href="{{ route('member.create', 'create?side=right') }}">Add</a>
                                        @endif
                                    </div>
                                </div>
                                <?php $c = 0; ?>

                            @else

                                @if( count( $users ) < 2 )
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                            @if( $left )
                                                <div class="user-image">
                                                    <img class="img-circle" src="http://placehold.it/50x50">
                                                    <div class="user-details-box">
                                                        <div class="box-inner">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <td>{{ ucwords($left->first_name.' '.$left->last_name) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Username</th>
                                                                        <td>{{ strtoupper($left->username) }}</td>
                                                                    </tr>
                                                                    @if( $left->userdetail && count( $left->userdetail ) > 0 )
                                                                        <tr>
                                                                            <th>Gender</th>
                                                                            <td>{{ ucfirst( $left->userdetail[0]->gender ) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Address</th>
                                                                            <td>{{ ucfirst( $left->userdetail[0]->address.', '.$left->userdetail[0]->landmark ) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>City</th>
                                                                            <td>{{ App\model\City::where('id', $left->userdetail[0]->city)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>State</th>
                                                                            <td>{{ App\model\State::where('id', $left->userdetail[0]->state)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>County</th>
                                                                            <td>{{ App\model\Country::where('id', $left->userdetail[0]->country)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Contact No.</th>
                                                                            <td>{{ $left->userdetail[0]->phonecode.'-'.$left->userdetail[0]->mobile }}</td>
                                                                        </tr>

                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-name">
                                                    <span>{{ strtoupper($left->username) }}</span>
                                                </div>
                                            @else
                                                <a href="{{ route('member.create', 'create?side=left') }}">Add</a>
                                            @endif
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                            @if( $right )
                                                <div class="user-image">
                                                    <img class="img-circle" src="http://placehold.it/50x50">
                                                    <div class="user-details-box">
                                                        <div class="box-inner">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <td>{{ ucwords($right->first_name.' '.$right->last_name) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Username</th>
                                                                        <td>{{ strtoupper($right->username) }}</td>
                                                                    </tr>
                                                                    @if( $right->userdetail && count( $right->userdetail ) > 0 )
                                                                        <tr>
                                                                            <th>Gender</th>
                                                                            <td>{{ ucfirst( $right->userdetail[0]->gender ) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Address</th>
                                                                            <td>{{ ucfirst($right->userdetail[0]->address.', '.$right->userdetail[0]->landmark) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>City</th>
                                                                            <td>{{ App\model\City::where('id', $right->userdetail[0]->city)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>State</th>
                                                                            <td>{{ App\model\State::where('id', $right->userdetail[0]->state)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>County</th>
                                                                            <td>{{ App\model\Country::where('id', $right->userdetail[0]->country)->value('name') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Contact No.</th>
                                                                            <td>{{ $right->userdetail[0]->phonecode.'-'.$right->userdetail[0]->mobile }}</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-name">
                                                    <span>{{ strtoupper($right->username) }}</span>
                                                </div>

                                                <div class="underline">
                                                    <span class="pull-left">Left</span>
                                                    <span class="pull-right">Right</span>
                                                </div>
                                                <?php $users = App\User::with('userdetail')->where('ref_id', $right->username)->get(); ?>
                                                <?php list_tree( $users ); ?>
                                            @else
                                                <a href="{{ route('member.create', 'create?side=right') }}">Add</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            @endif

                	   @endforeach
                    @else
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                <a href="{{ route('member.create', 'create?side=left') }}">Add</a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 text-center user-tree-row">
                                <a href="{{ route('member.create', 'create?side=right') }}">Add</a>
                            </div>
                        </div>
                    @endif
              	</div>
            </div>
    	</div>
    </div>

@endsection