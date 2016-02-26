@extends('layouts.app')
@section('content')
<div class="container">
		<div>
        	<div class="col-md-4">Username</div>
        	<div class="col-md-4">Feedback</div>
        	<div class="col-md-4">Create At</div>
        </div>
    @foreach ($feedbacks as $feedback)
        <div>
        	<div class="col-md-4">{{ $feedback->user->username }}</div>
        	<div class="col-md-4">{{ $feedback->feedback }}</div>
        	<div class="col-md-4">{{ $feedback->created_at }}</div>
        </div>
    @endforeach
</div>

{!! $feedbacks->links() !!}
@endsection
