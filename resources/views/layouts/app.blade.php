<html>
    <head>
        <link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
       


        @yield('style')
    </head>
    <body>
        <header>
            @include('layouts.header.main')
        </header>
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
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Success</h4>
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
        <footer>
            @yield('footer')
        </footer>
        <div class="main_script">
            <script src="https://cdn.jsdelivr.net/jquery/2.2.0/jquery.min.js">
            </script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous">
            </script>
			<script src="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/js/bootstrap-datepicker.js"></script>
            <script>
                var BASEURL = window.location.protocol + '//' + window.location.hostname + '' + window.location.pathname;
                $('#planList').on('change',function(){
                    window.location.href = BASEURL+'?id=' + $('#planList').val();
                });
            </script>

            <script >
                    $('.datepicker').datepicker({
                     format: 'mm/dd/yyyy',
                    startDate: '-3d'
                        });
            </script>
			<script>
			<?php if (Session::has('successes')){
				if(sizeOf(Session::get('successes')) > 0){?>
					 $('#myModal').modal('toggle');
				<?php }
			}?>
			</script>
            @yield('script')
			<?php Session::forget("successes"); ?>
        </div>
    </body>
</html>
