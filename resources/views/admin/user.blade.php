@extends('layouts.app')
@section('content')
<section id="contact">
<div class="container">
		<div>
        	<div class="col-md-3">Username</div>
        	<div class="col-md-3">Email</div>
        	<div class="col-md-3">Create At</div>
        	<div class="col-md-3">Delete</div>
        </div>
    @foreach ($users as $user)
        <div>
        	<div class="col-md-3">{{ $user->username }}</div>
        	<div class="col-md-3">{{ $user->email }}</div>
        	<div class="col-md-3">{{ $user->created_at }}</div>
        	<div class="col-md-3">
	        	<form action="delete-user" method="post">
	        		<input type="hidden" name="id" value="{{$user->id}}" />
	        		<input type="hidden" name="_token" value="{{csrf_token()}}">
	        		<input type="submit" name="Delete"/>
	        	</form>
        	</div>
        </div>
    @endforeach
</div>
{!! $users->links() !!}
</section>
@endsection
