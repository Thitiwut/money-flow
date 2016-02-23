@extends('layouts.app')
@section('content')
<div class="row">
	<div class="container">
		<div class="text-center"><h1>Login</h1></div>
		<form class="col-md-offset-3 col-md-6" method="post" action="login">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{old('email')}}" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
			</div>
			<div class="col-md-12">
				<button type="submit" class="btn btn-block btn-success">Login</button>
			</div>
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		</form>
	</div>
</div>
@endsection