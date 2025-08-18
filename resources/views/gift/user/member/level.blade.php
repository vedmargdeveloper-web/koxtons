@extends('gift.user.app.app')


@section('title', $title)

@section('fix-nav', 'nav-fixed')

@section('content')

    <div class="breadcrumb">
        <h1>{{ $title }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row justify-content-center login-card member-card">

        <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); $walletHistory = false; ?>
        @if( $wallet )

            <?php $walletHistory = App\model\WalletRelation::where(['wallet_id' => $wallet->id, 'level' => $level])->get(); ?>
        
        <div class="col-md-12 mb-4">
            <a title="Add Member" href="{{ route('member.create', 'create') }}"><span class="fas fa-user-plus"></span></a>
            <div class="card">
                <div class="card-header">{{ __('Level '. str_replace('l', '', $level) .' Members') }}</div>

                <div class="card-body">
                    <table class="table table-bordered datatables">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Reference</th>
                                <th>Level</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $c = 0; ?>
                            @if( $walletHistory && count( $walletHistory ) > 0 )
                                @foreach( $walletHistory as $key => $w )
                                    <?php $user = App\User::find( $w->user_id ); ?>
                                    @if( $user )
                                        <tr>
                                            <td>{{ ++$c }}</td>
                                            <td>{{ strtoupper($user->ref_id) }}</td>
                                            <td>{{ ucfirst( $w->level ) }}</td>
                                            <td>{{ strtoupper($user->username) }}</td>
                                            <td>{{ ucwords($user->first_name.' '.$user->last_name) }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a class="action" href="{{ route('member.view', $user->id) }}"><span class="fas fa-eye"></span></a>
                                                
                                                <a class="action" href="{{ route('member.users', $user->username) }}"><span class="fas fa-users"></span></a>
                                            </td>
                                        </tr>
                                    @endif

                                @endforeach
                            @else

                                <p>No details found!</p>
                            
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @endif



    </div>

@endsection