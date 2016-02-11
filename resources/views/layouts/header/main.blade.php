<div class="main_header">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Money Flow	</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse">
				@if(Session::get('Auth'))
				<ul class="nav nav-pills navbar-nav navbar-left">
					<li><a href="plan">Plan</a></li>
					<li><a href="expense">Expense/Income</a></li>
					<li><a href="progress">Progress</a></li>
					<li><a href="charts">Charts</a></li>
				</ul>
				<ul class="nav nav-pills navbar-nav navbar-right">
					<li><a href="feedback">Feedback</a></li>
					<li><a href="setting">Setting</a></li>
					<li><a href="logout">Logout</a></li>
				</ul>
				@else
				<ul class="nav nav-pills navbar-nav navbar-right">
					<li><a href="login">Login</a></li>
					<li><a href="register">Register</a></li>
				</ul>
				@endif
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</div>