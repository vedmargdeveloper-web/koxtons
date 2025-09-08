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
  <base href="{{ admin_url('mlm') }}">
  <!-- CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

  <!--for minify css -->
   {{--CSS Load --}}
   <link rel="stylesheet" href="{{ mix('css/app.min.css') }}">

  <!-- fontawesome css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css?v='.time()) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/design.css?v='.time()) }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}">
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
              <li>
                <a href="{{ route('mlm') }}">Booming Member</a>
              </li>
              <li class="has-children">
                <a>Epins</a>
                <ul class="sub-menu">
                  <li>
                    <?php $epin = App\model\Epin::count(); ?>
                    <a href="{{ route('mlm.epins') }}" class="tooltip-right" data-tooltip="You have {{ $epin }} EPINs!">Epins <span class="badge">{{ $epin }}</span></a>
                  </li>
                  <li>
                    <?php $epin = App\model\Epin::where(['status' => 'pending'])->count(); ?>
                    <a href="{{ route('mlm.epin.requested') }}" class="tooltip-right" data-tooltip="You have {{ $epin }} requested EPINs!">Requested Epins <span class="badge">{{ $epin }}</span></a>
                  </li>
                  <li>
                    <a href="{{ route('mlm.epin.create') }}">Sell Epin</a>
                  </li>
                </ul>
              </li>

              <li class="has-children">
                <a>Members</a>
                <ul class="sub-menu">
                  <li>
                    <?php $mem = App\User::where('role', 'member')->count(); ?>
                    <a href="{{ route('mlm.members') }}" class="tooltip-right" data-tooltip="You have {{ $mem }} members!">Members <span class="badge">{{ $mem }}</span></a>
                  </li>
                  <li>
                    <?php $mem = App\User::where(['ref_id' => null, 'role' => 'member'])->count(); ?>
                    <a href="{{ route('mlm.members.direct') }}" class="tooltip-right" data-tooltip="You have {{ $mem }} direct members!">Direct Members <span class="badge">{{ $mem }}</span></a>
                  </li>
                  <li>
                    <?php $mem = App\User::where('role', 'member')->where('ref_id', '!=', null)->count(); ?>
                    <a href="{{ route('mlm.members.reference') }}" class="tooltip-right" data-tooltip="You have {{ $mem }}  reference members">Reference Members <span class="badge">{{ $mem }}</span></a>
                  </li>
                  <li>
                    <a href="{{ route('mlm.member.create', 'create') }}" class="tooltip-right">Add Member</a>
                  </li>
                </ul>
              </li>

              <li class="has-children">
                <a>Financial</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('mlm.wallet') }}" class="tooltip-right" data-tooltip="You have 2 new reviews!">Wallet <span class="badge">2</span></a>
                  </li>
                  <li>
                    <?php $pay = App\model\PayoutRequest::count(); ?>
                    <a href="{{ route('mlm.wallet.payout.requested') }}" class="tooltip-right" data-tooltip="You have {{ $pay }} payout requests!">Payout Requests<span class="badge">{{ $pay }}</span></a>
                  </li>
                </ul>
              </li>

              <li class="has-children">
                <a>Salary</a>
                <ul class="sub-menu">
                  <li>
                    <a href="{{ route('mlm.salary') }}" class="tooltip-right" data-tooltip="You have 2 new reviews!">Salary <span class="badge">2</span></a>
                  </li>
                  <li>
                    <?php $pay = App\model\PayoutRequest::count(); ?>
                    <a href="{{ route('mlm.salary.upcoming') }}" class="tooltip-right" data-tooltip="You have {{ $pay }} payout requests!">Upcoming payouts<span class="badge">{{ $pay }}</span></a>
                  </li>
                </ul>
              </li>

              <li class="spacer"><div class="hr"></div></li>
              <li>
                <a href="#" class="tooltip-right" data-tooltip="Ready to leave? :(">Logout</a>
              </li>
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
        <img src="{{ asset('public/loader-spinner.gif') }}" alt="loading Spinner">
        <span id="progress-bar"></span>
      </span>
    </div>

    {{ csrf_field() }}

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      {{-- JS Load --}}
    <script src="{{ mix('js/app.min.js') }}"></script>

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
      });
    </script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/admin.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/jquery.nestable.js') }}"></script>
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
    <script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this work.');
        }
    };

    // activate Nestable for list 1
    /*$('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);*/

    $('#nestable2').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable3').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable4').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable5').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    // $('#nestable2').nestable({
    //     group: 1
    // })
    // .on('change', updateOutput);

    // output initial serialised data
    /*updateOutput($('#nestable').data('output', $('#output')));*/
    updateOutput($('#nestable2').data('output', $('#nestable-output')));
    updateOutput($('#nestable3').data('output', $('#nestable-output')));
    updateOutput($('#nestable4').data('output', $('#nestable-output')));
    updateOutput($('#nestable5').data('output', $('#nestable-output5')));
    // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    // $('#nestable3').nestable();

});
</script>
</body>
</html>