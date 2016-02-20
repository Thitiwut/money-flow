<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
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
                                {{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="container">
                <div class="col-md-offset-3 col-md-6">
                    @if (Session::has('successes'))
                    <div class="alert alert-success">
                        <ul>
                            @foreach ($successes->all() as $success)
                            <li>
                                {{ $success }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
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
            <script>
                $('#planList').on('change',function(){
                    window.location.href = window.location.protocol + '//' + window.location.hostname + ':8080' + window.location.pathname+'?id=' + $('#planList').val();
                });
            </script>
            @yield('script')
        </div>
    </body>
</html>
