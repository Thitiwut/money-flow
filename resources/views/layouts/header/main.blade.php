<div class="main_header">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">
                        Toggle navigation
                    </span>
                    <span class="icon-bar">
                    </span>
                    <span class="icon-bar">
                    </span>
                    <span class="icon-bar">
                    </span>
                </button>
                <a class="navbar-brand" href="index">
                   <p class="text-info"><em>SMA</em></p>
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
           <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

             @if(Session::has('Admin'))
                 <ul class="nav nav-pills navbar-nav navbar-left">
                     <li class="page-scroll">
                        <a href="users">
                          <i class="glyphicon glyphicon-user" aria-hidden="true"> Users</i>
                        </a>
                    </li>
                   <li class="page-scroll">
                       
                        <a  href="feedbacks">
                           <i class="glyphicon glyphicon-envelope" aria-hidden="true"> Feedbacks</i>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li class="page-scroll">
                        <a href="logout">
                            Logout
                        </a>
                    </li>
                </ul>
            @else
                @if(Session::get('Auth'))

                <ul class="nav nav-pills navbar-nav navbar-left">
                    <li class="page-scroll">
                        <a href="plan" >
                            <em class="text-danger"><i class="glyphicon glyphicon-flag" aria-hidden="true"></i></em>Plan
                        </a>
                    </li>
                    <li class="page-scroll">
                        <div class="form-group navbar-form">
                            <select id="planList" class="form-control">
                                <option></option>
                                @if(Session::get('Auth'))
                                    <?php
                                        $plansList = Session::get('Auth')->plans()->get();
                                        foreach ($plansList as $planList) {?>
                                        <option value="{{$planList->id}}" @if(Session::has('Plan')) @if(Session::get('Plan') == $planList->id) selected @endif @endif >
                                           {{$planList->name}}
                                        </option>
                                    <?php } ?>
                                @endif
                            </select>
                        </div>
                    </li>
                    <li class="page-scroll">
                        
                        <a href="expense">
                          <em class="text-info"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i></em>Expense&Income
                        </a>
                    </li>
                    <li class="page-scroll">
                       
                        <a href="progress">
                           <em class="text-warning"><i class="glyphicon glyphicon-tasks" aria-hidden="true"></em></i>Progress
                        </a>
                    </li>
                   <li class="page-scroll">
                        
                        <a href="charts">
                          <em class="text-info"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></em>Charts
                        </a>
                    </li>
                    <li class="page-scroll">
                       
                        <a href="report">
                          <em class="text-info"> <i class="glyphicon glyphicon-copy" aria-hidden="true"></i></em>Report

                        </a>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="search" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword" />
                    </div>
                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                </form>
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li class="page-scroll">
                        <a href="feedback">
                            <em class="text-warning"><i class="glyphicon glyphicon-bullhorn" aria-hidden="true"></em></i>Feedback
                        </a>
                    </li>
                   <li class="dropdown">
                            <a href="setting" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><em class="text-danger"><i class="glyphicon glyphicon-cog" aria-hidden="true"></i></em>options<i class="caret"></i></a>
                             <!--<i class="glyphicon glyphicon-cog" aria-hidden="true"><em class="text-success">Setting</em></i>-->
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="setting">Setting</a></li>
                                <li><a href="list">Checklist</a></li>
                         
                              </ul>
                        </a>
                    </li>
                    <li class="page-scroll">
                        <a href="logout">
                             <i class="glyphicon glyphicon-off" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
                @else
                <ul class="nav nav-pills navbar-nav navbar-right">
                   <li class="page-scroll">
                        <a href="login">
                            Login
                        </a>
                    </li>
                   <li class="page-scroll">
                        <a href="register">
                            Register
                        </a>
                    </li>
                </ul>
                @endif
            @endif
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
</div>
