@extends('layouts.app')
@section('content')
<div class="row">
	<div class="container">
		<div class="text-center"><h1 class="text-warning"><em><i class="fa fa-rss fa-lg"></i>Feedback</em></h1></div>
		<div class="text-center"><h3><em>Send Feedback</em></h3></div>

		<form class="col-md-offset-3 col-md-6" method="post" action="feedback">
			<div class="form-group">
				<label for="feedback">Message</label>
				<textarea class="form-control" id="feedback"  name="feedback" required></textarea>
			</div>
			<div class="col-md-12">
				<button type="submit" onclick="return confirm('send feedback?')? true: false;"  class="btn btn-block btn-success">Send</button>
			</div>
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		</form>
	</div>
</div>
@endsection
