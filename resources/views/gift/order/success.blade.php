@extends( _app() )

@section('content')

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Page Content -->
    <section class="content-page">
        <div class="container mb-80">
            <div class="row">
                <div class="col-sm-12">
                    <article class="post-8 text-center">
                        <h1>Thank You!</h1>
                        <h5>Your order has been placed successfully!</h5>
                        <p><strong>Order no:</strong> {{ $order_id }}</p>
                        <br>
                        @if( Session::has('memberCoupon') && Session::get('memberCoupon') && App\User::isMember() )
                            <p>Congratualations</p>
                            <p>You have got Rs.6000 points in offer which you can use in your next shopping! <a href="{{ route('user.home') }}">Click here</a>
                            </p>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection