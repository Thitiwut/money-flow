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
                    Money Flow
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse">
                @if(Session::get('Auth'))
                <ul class="nav nav-pills navbar-nav navbar-left">
                    <li>
                        <a href="plan">
                            Plan
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
                            Expense/Income
                        </a>
                    </li>
                    <li>
                        <a href="progress">
                            Progress
                        </a>
                    </li>
                    <li>
                        <a href="charts">
                            Charts
                        </a>
                    </li>
                    <li>
                        <a href="report">
                            Report
                        </a>
                    </li>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search"/>
                </div>
                <button type="submit" class="btn btn-default">
                    Submit
                </button>
            </form>
            <ul class="nav nav-pills navbar-nav navbar-right">
                <li>
                    <a href="feedback">
                        Feedback
                    </a>
                </li>
                <li>
                    <a href="setting">
                        Setting
                    </a>
                </li>
                <li>
                    <a href="logout">
                        Logout
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
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
</div>
