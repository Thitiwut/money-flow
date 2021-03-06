@extends('layouts.app')
@section('content')
<section class="success" id="about">
<div class="row">
	<div class="container">
		<div class="text-center"><h1>Register</h1></div>
		<form class="col-md-offset-3 col-md-6" method="post" action="register">
			<div class="form-group">
				<label for="username">Usename</label>
				<input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{old('username')}}" minlength="4"  maxlength="10" required>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{old('email')}}" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" placeholder="Password" name="password" pattern=".{6,}" title="6 characters minimum" maxlength="10" value="{{old('password')}}" required>
			</div>
			<div class="form-group">
				<label for="repassword">Re-Password</label>
				<input type="password" class="form-control" id="repassword" placeholder="Re-Password" name="repassword" pattern=".{6,}" title="6 characters minimum"  maxlength="10" required>
			</div>
			<div class="col-md-12">
				<div class="col-md-6 text-center">
					<button class="btn btn-block btn-warning" onclick="window.history.back()" >Back</button>
				</div>
				<div class="col-md-6 text-center">
					<button type="submit" name="Submit" class="btn btn-block btn-info">Submit</button>
				</div>
			</div>
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		</form>
	</div>
</div>
</section>
@endsection

@section('script')
<script type="text/javascript">
	window.onload = function () {
		document.getElementById("password").onchange = validatePassword;
		document.getElementById("repassword").onchange = validatePassword;
	}
	function validatePassword(){
		var pass2=document.getElementById("repassword").value;
		var pass1=document.getElementById("password").value;
		if(pass1!=pass2)
			document.getElementById("repassword").setCustomValidity("Passwords Don't Match");
		else
			document.getElementById("repassword").setCustomValidity('');
//empty string means no validation error
}
</script>
@endsection