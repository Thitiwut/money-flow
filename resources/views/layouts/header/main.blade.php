<div class="main_header">
    <nav class="navbar navbar-default">
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
                <a class="navbar-brand" href="#">
                   <p class="text-info"><em>MoneyFlow</em></p>
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse">
             @if(Session::has('Admin'))
                 <ul class="nav nav-pills navbar-nav navbar-left">
                     <li>
                        <a href="users">
                          <span class="glyphicon glyphicon-user" aria-hidden="true"> Users</span>
                        </a>
                    </li>
                    <li>
                       
                        <a href="feedbacks">
                           <span class="glyphicon glyphicon-envelope" aria-hidden="true"> Feedbacks</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li>
                        <a href="logout">
                            Logout
                        </a>
                    </li>
                </ul>
            @else
                @if(Session::get('Auth'))
                <ul class="nav nav-pills navbar-nav navbar-left">
                    <li>
                        <a href="plan">
                            <span class="glyphicon glyphicon-flag" aria-hidden="true"><em>Plan</em></span>
                        </a>
                    </li>
                    <li>
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
                    <li>
                        
                        <a href="expense">
                          <span class="glyphicon glyphicon-list-alt" aria-hidden="true"><em>Expense&Income</em></span>
                        </a>
                    </li>
                    <li>
                       
                        <a href="progress">
                           <span class="glyphicon glyphicon-tasks" aria-hidden="true"><em>Progress</em></span>
                        </a>
                    </li>
                    <li>
                        
                        <a href="charts">
                          <span class="glyphicon glyphicon-stats" aria-hidden="true"><em>Charts</em></span>
                        </a>
                    </li>
                    <li>
                       
                        <a href="report">
                           <span class="glyphicon glyphicon-copy" aria-hidden="true"><em>Report</em></span>

                        </a>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="search" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword" />
                    </div>
                    <button type="submit" class="btn btn-default">
                        Submit
                    </button>
                </form>
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li>
                        <a href="feedback">
                            <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"><em/>Feedback</em></span>
                        </a>
                    </li>
                    <li>
                        <a href="setting">
                             <span class="glyphicon glyphicon-cog" aria-hidden="true"><em>Setting</em></span>
                        </a>
                    </li>
                    <li>
                        <a href="logout">
                             <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </li>
                </ul>
                @else
                <ul class="nav nav-pills navbar-nav navbar-right">
                    <li>
                        <a href="login">
                            Login
                        </a>
                    </li>
                    <li>
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
