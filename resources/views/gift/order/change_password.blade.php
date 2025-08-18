@extends( _app() )

@section('content')

<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="" style="margin-top: 0px;">
        <div class="container">
                <div class="row">
                    <div class="col-12 mt-10">
                        <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                              <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>
                             <span style="margin: 0 5px;">&raquo;</span>
                            <span>Change Password</span>
                        </nav>
                    </div>
                </div>
        </div>
    </section>
    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section class="content-page" >
        <div class="container">
             
                <div class="row">
                    <div class="col-sm-2"></div>
                	<div class="col-sm-8">
                        <article class="post-8">

                        @auth

                        <?php $user = App\User::with('userdetail')->where('id', Auth::id() )->first(); ?>

                        @if( $user )

                            <div class="card">
                                <div class="card-header">
                                    <h3>Change Password</h3>
                                </div>
                                <div class="card-block" style="padding: 30px;">
                                     @if( session()->has('profile_msg') )
                                        <span class="text-success">{{ session()->get('profile_msg') }}</span>
                                    @endif
                                      <form action="{{route('customer.profile.update.passoword')}}" method="post" accept-charset="utf-8">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input type="text" name="password" class="form-control" placeholder="Enter Password">
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary theme-btn" type="submit">Submit</button>
                                                </div>
                                            </div>



                                        </div>
                                      </form>
                                </div>
                            </div>

                        @endif

                        @endauth

                        </article>
                    </div>
                    <div class="col-sm-2"></div>

                </div>
        </div>
    </section>
</div>


@endsection