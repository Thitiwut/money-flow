<html>
<head>
    <link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
   <link href="http://blackrockdigital.github.io/startbootstrap-freelancer/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://blackrockdigital.github.io/startbootstrap-freelancer/css/freelancer.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        #portfolio *{z-index: 0;}
        #portfolio *.portfolio-modal{z-index: 1050;}
        #portfolio *.portfolio-modal .modal-content{min-height: auto;}
         #yolo *{z-index: 0;}
        #yolo *.yolo-modal{z-index: 1050;}
        #yolo *.yolo-modal .modal-content{min-height: auto;}
    </style>
    @yield('style')
</head>

<body id="page-top" class="index">
  <div class="container">
    <header>
        @include('layouts.header.main')
    </header>
</div>
<section id="portfolio">
    <div class="main_body">
        <div class="container">
            <div class="col-md-offset-3 col-md-6">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>
                            {!! $error !!}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="portfolio-modal modal fade in" id="myModal" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Notice</h4>
                </div>
                <div class="modal-body" style="overflow: hidden;">
                    <div class="">
                        @if (Session::has('successes'))
                        @if(sizeOf(Session::get('successes')) > 0)
                        <div class="alert alert-success">
                            <ul>
                                @foreach (Session::get('successes') as $success)
                                <li>
                                    {!! $success !!}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div>
    @yield('content')
</div>
</div>
</section>
<footer>
    @yield('footer')
</footer>
<div class="main_script">
    <script src="https://cdn.jsdelivr.net/jquery/2.2.0/jquery.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="http://blackrockdigital.github.io/startbootstrap-freelancer/js/jqBootstrapValidation.js"></script>

    <!-- Theme JavaScript -->
    <script src="http://blackrockdigital.github.io/startbootstrap-freelancer/js/freelancer.min.js"></script>
    <script>
        var BASEURL = window.location.protocol + '//' + window.location.hostname + '' + window.location.pathname;
        $('#planList').on('change',function(){
            window.location.href = BASEURL+'?plan_id=' + $('#planList').val();
        });
    </script>

    <script >
        $('.datepicker').datepicker({
           format: 'mm/dd/yyyy',
           startDate: '-3d'
       });
   </script>
   <script>
    <?php if (Session::has('successes')) {
    if (sizeOf(Session::get('successes')) > 0) {?>
           $('#myModal').modal('toggle');
           <?php }
}?>
   </script>
   @yield('script')
   <?php Session::forget("successes");?>

</div>
</body>
</html>
