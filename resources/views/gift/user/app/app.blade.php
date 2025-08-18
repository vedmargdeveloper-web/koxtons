<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ strtoupper(Auth::user()->username) }} | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <base href="{{ url('/') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <link rel="stylesheet" href="{{ asset('public/styles/css/themes/lite-purple.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('public/styles/vendor/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css?v='.time()) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
    
    <script src="{{ asset('public/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/chartjs/Chart.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/chartjs/utils.js') }}"></script>
</head>

<body>

    <?php
        $site_logo = App\model\Meta::where('meta_name', 'app_logo')->value('meta_value');
        $footer_logo = App\model\Meta::where('meta_name', 'footer_logo')->value('meta_value');
        $site_name = App\model\Meta::where('meta_name', 'app_name')->value('meta_value');
    ?>
    <div class="app-admin-wrap">
        <div class="main-header">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/'. public_file( $site_logo ) ) }}" alt="{{ $site_name }}" />
                </a>
            </div>

            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div style="margin: auto"></div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="fa fa-arrows-alt" title="Full Screen" style="font-size:16px;padding:5px 11px;cursor:pointer" data-fullscreen></i>
                <a title="Add Member" style="padding:5px 11px;font-size:16px;" href="{{ route('member.create', 'create') }}"><i class="fas fa-user-plus"></i></a>

                <div class="dropdown">
                    <?php $messages = App\model\Message::where('receiver_id', Auth::id())->orderby('id', 'DESC')->limit(5)->get(); ?>
                    <div class="badge-top-container" id="dropdownNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="badge badge-primary">{{ App\model\Message::where(['receiver_id' => Auth::id(), 'seen' => 0])->count() }}</span>
                        <i class="i-Bell text-muted header-icon fa fa-bell"></i>
                    </div>
                    <!-- Notification dropdown -->
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown ps" aria-labelledby="dropdownNotification" data-perfect-scrollbar="" data-suppress-scroll-x="true" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-200px, 36px, 0px);">

                        
                        @if( $messages && count( $messages ) > 0 )
                            @foreach( $messages as $message )
                                <div class="dropdown-item d-flex">
                                    <div class="notification-details flex-grow-1">
                                        <p class="m-0 d-flex align-items-center">
                                            <span>New message</span>
                                            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                                            <span class="flex-grow-1"></span>
                                            <span class="text-small text-muted ml-auto">{{ time_elapsed_string( $message->created_at ) }}</span>
                                        </p>
                                        <p class="text-small text-muted m-0">{{ get_excerpt($message->message, 5).'...' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="dropdown-item" style="height:40px;display:block;text-align:center;background:rebeccapurple;">
                                <a style="padding:9px;display:inline-block;color:#fff;" href="{{ route('user.messages') }}">View</a>
                        </div>
                        
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div>
                    </div>
                </div>

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <?php $filename = App\model\Avtar::where('user_id', Auth::id())->value('filename'); 
                      $userName = optional(Auth::user())->username ?? 'User';
                    ?>
                  
                    <div class="user col align-self-end">
                        @if( $filename )
                            <img src="{{ asset('public/images/avtars/'.thumb($filename, 40, 40)) }}" id="userDropdown"   alt="{{ $userName }}'s avatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @else
                            <img src="http://placehold.it/40x40" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @endif

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{ strtoupper(Auth::user()->username) }} ({{ ucwords(Auth::user()->first_name.' '.Auth::user()->last_name) }})
                            </div>
                            <?php $wallet = App\model\Wallet::where('user_id', Auth::id())->first(); ?>
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> Wallet Points: {{ $wallet ? $wallet->amount : 0 }}
                            </div>
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> Membership Points: {{ $wallet ? $wallet->membership_amount : 0 }}
                            </div>
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> Member Since: {{ Auth::user()->created_at->format('d M, Y') }}
                            </div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-user"></i> Logout</a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="side-content-wrap">
            <div class="sidebar-left open" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item active">
                        <a class="nav-item-hold" href="{{ route('user.home') }}">
                            <i class="nav-icon fa fa-home"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="pin">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fa fa-credit-card"></i>
                            <span class="nav-text">E-Pin</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="extrakits">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fa fa-users"></i>
                            <span class="nav-text">Profile</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="network">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <span class="nav-text">Network</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="financial">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <span class="nav-text">Financial</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="orders">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fab fa-first-order-alt"></i>
                            <span class="nav-text">Orders</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                    <li class="nav-item" data-item="setting">
                        <a class="nav-item-hold" href="#">
                            <i class="nav-icon fas fa-cogs"></i>
                            <span class="nav-text">Setting</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>

            <div class="sidebar-left-secondary" data-perfect-scrollbar data-suppress-scroll-x="true">
                <ul class="childNav" data-parent="financial">
                    <li class="nav-item">
                        <a href="{{ route('user.point') }}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <span class="item-name">Points</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.transfer') }}">
                            <i class="nav-icon fas fa-share-square"></i>
                            <span class="item-name">Transfer/Withdraw</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.payout.request') }}">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <span class="item-name">Payout Request</span>
                        </a>
                    </li>
                </ul>

                <ul class="childNav" data-parent="pin">
                    <li class="nav-item">
                        <a href="{{ route('epins') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <span class="item-name">E-PIN</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('epin.create') }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <span class="item-name">Request Epin</span>
                        </a>
                    </li>
                </ul>

                <ul class="childNav" data-parent="network">
                    <li class="nav-item">
                        <a href="{{ route('member.network') }}">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <span class="item-name">Network List</span>
                        </a>
                    </li>
                    <li class="nav-item" style="display: none;">
                        <a href="{{ route('network.tree') }}">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <span class="item-name">Network Tree</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('member.create', 'create') }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <span class="item-name">Add member</span>
                        </a>
                    </li>
                </ul>


                <ul class="childNav" data-parent="orders">
                    <li class="nav-item">
                        <a href="{{ route('user.my.orders') }}">
                            <i class="nav-icon fab fa-first-order-alt"></i>
                            <span class="item-name">My Orders</span>
                        </a>
                    </li>
                </ul>


                <ul class="childNav" data-parent="setting">
                    <li class="nav-item">
                        <a href="{{ route('user.change.password') }}">
                            <i class="nav-icon fas fa-key"></i>
                            <span class="item-name">Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.edit') }}">
                            <i class="nav-icon fas fa-user-edit"></i>
                            <span class="item-name">Edit Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.contact') }}">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <span class="item-name">Contact Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.bank') }}">
                            <i class="nav-icon fas fa-piggy-bank"></i>
                            <span class="item-name">Bank Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.documents') }}">
                            <i class="nav-icon fas fa-file"></i>
                            <span class="item-name">Documents</span>
                        </a>
                    </li>
                </ul>


                <ul class="childNav" data-parent="extrakits">
                    <li class="nav-item">
                        <a href="{{ route('user.edit') }}">
                            <i class="nav-icon fas fa-user"></i>
                            <span class="item-name">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!--=============== Left side End ================-->


        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">


        @yield('content')

        <!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer" style="display: none;">
                <div class="footer-bottom d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded" href="https://techdost.com" target="_blank">Techdost</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="./assets/images/logo.png" alt="">
                        <div>
                            <p class="m-0">&copy; 2018 TechDost</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>


        <!-- ============ Body content End ============= -->
    </div>
    <!--=============== End app-admin-wrap ================-->

    <!-- ============ Search UI Start ============= -->
    <div class="search-ui">
        <div class="search-header">
            <img src="{{ asset('public/images/logo.png') }}" alt="" class="logo">
            <button class="search-close btn btn-icon bg-transparent float-right mt-2">
                <i class="i-Close-Window text-22 text-muted"></i>
            </button>
        </div>

        <input type="text" placeholder="Type here" class="search-input" autofocus>

        <div class="search-title">
            <span class="text-muted">Search results</span>
        </div>

        <div class="search-results list-horizontal">
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="{{ asset('public/images/products/headphone-1.jpg') }}"  alt="Headphone 1" >
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                $300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-danger">Sale</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="{{ asset('public/images/products/headphone-2.jpg') }}"  alt="Headphone 2" >
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                $300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="{{ asset('public/images/products/headphone-3.jpg') }}"  alt="Headphone 3" >
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                $300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="{{ asset('public/images/products/headphone-4.jpg') }}" alt="Headphone 4" >
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">
                                $300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- PAGINATION CONTROL -->
        <div class="col-md-12 mt-5 text-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-inline-flex">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    <div class="spinner-loader">
      <span class="loader-sm">
        <img src="{{ asset('public/images/loader-spinner.gif') }}" alt="Loader">
        <span id="progress-bar"></span>
      </span>
    </div>
    {{ csrf_field() }}

    
    <script src="{{ asset('public/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('public/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('public/assets/datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('public/js/es5/echart.options.min.js') }}"></script>
    <script src="{{ asset('public/js/es5/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('public/js/es5/script.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatables').DataTable();
        } );
    </script>
    <script src="{{ asset('public/assets/js/main.js?v='.time()) }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });
        });
    </script>
</body>

</html>