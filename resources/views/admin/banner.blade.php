@extends('layouts.app')
@section('content')
<section id="contact">
<div class="container">
			
			<div class="roll">
				<div class="col-sm-4">
 			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner1
							</button>
			</div>
					<div class="col-sm-4">
 			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner2
							</button>
			</div>
					<div class="col-sm-4">
 		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner3
							</button>
			</div>
					<div class="col-sm-4">
 		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner4
							</button>
			</div>
					<div class="col-sm-4">
 		
  			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner5
							</button>
			</div>
					<div class="col-sm-4">
 			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal3">
							  Banner6
							</button>
				</div>

		</div>
		
   <div id="myModal3" class="portfolio-modal modal fade in" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="margin-top: 20%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Update Banner</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Picture</span>
          <input type="file" class="form-control" id="checkName" placeholder="Username" aria-describedby="basic-addon1" required>
        
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Description</span>
          <input type="text" class="form-control" id="checkName" placeholder="Username" aria-describedby="basic-addon1" required>
        
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#addModal').hide();">Close</button>
        <a href="banners"><button type="button" class="btn btn-primary" onclick="mfCheckList.addCheck();$('#addModal').hide();">Save</button></a>
      </div>
    </div>
  </div>
</div>
</div>




</section>
@endsection
