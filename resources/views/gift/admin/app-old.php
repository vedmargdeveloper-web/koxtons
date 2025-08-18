<!DOCTYPE html>
<html>
<head>
  
  <meta charset="utf-8">
  <title>{{ isset( $title ) ? $title : '' }}</title>
  <meta name="description" content="" />
  <meta name="keywords" content="">
  <meta name="author" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

  <!-- Favicone Icon -->
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="icon" type="img/png" href="{{ asset('assets/img/favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">
  <base href="{{ admin_url() }}">
  <!-- CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  <!-- fontawesome css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css?v='.time()) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/design.css?v='.time()) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/styles/vendor/perfect-scrollbar.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/datetimepicker/jquery.datetimepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/select/dist/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/chosen/chosen.min.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/datepicker/dist/css/bootstrap-datepicker.min.css') }}">

  <script type="text/javascript" src="{{ asset('public/chartjs/Chart.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ asset('public/chartjs/utils.js') }}"></script>

  <?php //echo App\model\Meta::where('meta_name', 'analytics')->value('meta_value'); ?>

</head>


<body>

<div class="container-fluid">
    <div class="row">
      <div class="sidebar col-lg-2 col-md-2">
        <div class="row">
          <div class="logo">
            <a href="{{ admin_url() }}">
                   <img src="{{ asset('public/'. public_file( App\model\Meta::where('meta_name', 'footer_logo')->value('meta_value') ) ) }}" alt="{{ App\model\Meta::where('meta_name', 'app_name')->value('meta_value') }}" />
                </a>
          </div>
            <ul>
              <li class="current">
                <a href="{{ admin_url() }}">Home</a>
              </li>
             
              
              @if( Auth::user()->isAdmin() || Auth::user()->isEditor() )



              <li class="has-children">
                <a href="{{ route('post.index') }}">Posts</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('post.index') }}">Posts</a>
                  </li>
                  <li>
                    <a href="{{ route('post.create') }}">Create post</a>
                  </li>
                </ul>
              </li>
              <li class="has-children">
                <a href="{{ route('page.index') }}">Pages</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('page.index') }}">Pages</a>
                  </li>
                  <li>
                    <a href="{{ route('page.create') }}">Create Page</a>
                  </li>
                 </ul>
              </li>

               <li class="has-children">
                <a href="#">Products</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('product.index') }}">Products</a>
                  </li>
                  <li>
                    <a href="{{ route('product.create') }}">Add Product</a>
                  </li>
                 </ul>
              </li>

              <li>
                <a href="{{ route('slide.index') }}">Sliders</a>
              </li>

              <li>
                <a href="{{ route('admin.reviews') }}">Reviews</a>
              </li>

               <li>
                <a href="{{ route('admin.complains') }}">Complains</a>
              </li>




              @endif
            
             

              @if( Auth::user()->isAdmin() )
              <li class="has-children">
                <a href="{{ route('category.index') }}">Categories</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('category.index') }}">Categories</a>
                  </li>
                  <li>
                    <a href="{{ route('category.create') }}">Create category</a>
                  </li>
                 </ul>
              </li>


              <li class="has-children">
                <a href="{{ route('admin.users') }}">Users Role</a>
                <ul class="sub-menu">
                  <li><a href="{{ route('admin.user.create') }}">Add User</a></li>
                 </ul>
              </li>

              <li><a href="{{ route('admin.users') }}">Customers</a></li>
              @endif

              <li>
                
              </li>
               @if( Auth::user()->isAdmin() || Auth::user()->isAccountant() )
              <li class="has-children">
                <a href="{{ route('orders') }}">Orders</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('orders.status', 'delivered') }}">Delivered</a>
                  </li>
                  <li>
                    <a href="{{ route('orders.status', 'shipped') }}">Shipped</a>
                  </li>
                  <li>
                    <a href="{{ route('orders.status', 'cancelled') }}">Cancelled</a>
                  </li>
                  <li>
                    <a href="{{ route('orders.status', 'pending') }}">Pending</a>
                  </li>
                 </ul>
              </li>

              <li>
                <a href="{{ route('admin.invoice') }}">Invoice</a>
              </li>


              @endif

            

             


              @if( Auth::user()->isAdmin() )

            

              <li>
                <a href="{{ route('ourclient.index') }}">Our Clients</a>
              </li>

              <li>
                <a href="{{ route('set.pincode') }}">Pincode</a>
              </li>


             

              <li class="spacer">Setting</li>

              <li>
                <a href="{{ route('setting.index', 'header') }}">Header</a>
              </li>

              <li>
                <a href="{{ route('setting.index', 'footer') }}">Footer</a>
              </li>

              <li>
                <a href="{{ route('setting.index', 'contact') }}">Contact</a>
              </li>

              <li>
                <a href="{{ route('setting.index', 'change-password') }}">Change password</a>
              </li>

              @endif

            </ul>
        </div>
      </div>


      <div class="content col-lg-10 col-md-10 pb-5">
        <div class="row">
            <div class="header">
              <span class="label"><strong><a href="{{ url('/') }}">View Site</a></strong></span>
              <div class="menu">                
                <a href="{{ route('admin.logout') }}"><i class="material-icons">power_settings_new</i></a>
              </div>
            </div>
            <div class="section data-container">
              
                @yield('content')
                
            </div>
        </div>
      </div>
      
    </div>

</div>

<div class="lightbox-target">
  <div>
    <img src="" alt="Lightbox Image"/>
  </div>
  <a class="download" target="_blank" href="" download>
    <span class="fa fa-download"></span>
  </a>
   <a class="lightbox-close" href="#"></a>
</div>

    
    <div class="spinner-loader">
      <span class="loader-sm">
        <img src="{{ asset('public/loader-spinner.gif') }}" alt="Loading Spinner">
        <span id="progress-bar"></span>
      </span>
    </div>

    {{ csrf_field() }}

    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="{{ asset('public/js/vendor/perfect-scrollbar.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        /*const ps = new PerfectScrollbar('.perfect-scrollbar');*/
      });
    </script>

    <script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatables').DataTable({
              dom: 'Bfrtip',
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
              ]
            });
        } );
    </script>
    <script type="text/javascript" src="{{ asset('assets/datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        jQuery('.datetimepicker').datetimepicker({
          format:'d-m-Y H:i:s'
        });
      });
    </script>
    <script src="{{ asset('public/assets/datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/chosen/chosen.jquery.js') }}"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
         $(".multi-selector").chosen({no_results_text: "Oops, nothing found!", width: "95%"});
         $(".chosen").chosen({no_results_text: "Oops, nothing found!", width: "95%"});
      });
    </script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/admin.js?v='.time()) }}"></script>
    
    <script type="text/javascript" src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        tinymce.init({
          selector: '.texteditor',
          height: 250,
          plugins: 'paste autolink directionality fullscreen image media charmap hr anchor insertdatetime advlist lists textcolor imagetools colorpicker table code preview link',
          toolbar1: "formatselect fontsizeselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify",
          toolbar2: "bullist numlist blockquote | undo redo | link unlink anchor image media | insertdatetime table mediaembed hr table code preview",
          image_advtab: true,
          menubar: false,
          statusbar: false,
          valid_elements : '*[*]',
          paste_as_text: true,
          relative_urls : false,
          remove_script_host : false,
          convert_urls : true,
        });
        tinymce.init({
          selector: '.tinyeditor',
          height: 50,
          plugins: 'paste autolink directionality fullscreen image media charmap hr anchor insertdatetime advlist lists textcolor imagetools colorpicker code preview',
          toolbar1: "fontsizeselect bold italic underline  | alignleft aligncenter alignright | bullist numlist | link unlink anchor image media | mediaembed hr code",
          image_advtab: true,
          menubar: false,
          statusbar: false,
          valid_elements : '*[*]',
          paste_as_text: true,
          relative_urls : false,
          remove_script_host : false,
          convert_urls : true,
        });
      });
    </script>

</body>
</html>