@extends('layouts.app')
@section('content')
<style>
	#banner{overflow: hidden;}
	#banner img{
		/*width: 100%;*/
		height: auto;
		min-height: 0;
		max-height: 250px;
	}
	#banner .col-sm-4{margin-top: 10px;position: relative;}
</style>
<section id="contact">
	<div class="container">
		<div class="roll" id="banner">
			<div class="col-sm-4 text-center">
				<div><img id="img1" src="{{$banners[0]->file}}" /><input type="hidden" id="url1" value="{{$banners[0]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(1);">
					Banner 1
					</button>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div><img id="img2" src="{{$banners[1]->file}}" /><input type="hidden" id="url2" value="{{$banners[1]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(2);">
					Banner 2
					</button>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div><img id="img3" src="{{$banners[2]->file}}" /><input type="hidden" id="url3" value="{{$banners[2]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(3);">
					Banner 3
					</button>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div><img id="img4" src="{{$banners[3]->file}}" /><input type="hidden" id="url4" value="{{$banners[3]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(4);">
					Banner 4
					</button>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div><img id="img5" src="{{$banners[4]->file}}" /><input type="hidden" id="url5" value="{{$banners[4]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(5);">
					Banner 5
					</button>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div><img id="img6" src="{{$banners[5]->file}}" /><input type="hidden" id="url6" value="{{$banners[5]->description}}" /></div>
				<div>
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal" onclick="updateId(6);">
					Banner 6
					</button>
				</div>
			</div>
		</div>
		<div id="addModal" class="portfolio-modal modal fade in" tabindex="-1" role="dialog">
			<div class="modal-dialog" style="margin-top: 20%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Update Banner</h4>
					</div>
					<div class="modal-body">
						<form id="bannerForm">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Picture</span>
								<input type="file" class="form-control" id="file" name="file" placeholder="File" aria-describedby="basic-addon1" required>
							</div>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">Description</span>
								<input type="text" class="form-control" id="description" name="description" placeholder="Description" aria-describedby="basic-addon1" required>
							</div>
							<div id="error"></div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#addModal').hide();">Close</button>
						<button type="button" class="btn btn-primary" onclick="formSubmit();">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script>
	var file;
	var id = 0;
	$('input[type=file]').on('change', function(){readURL(this);});
	function updateId(i){
		id = i;
		var imageURL = $("#url" + id).val();
		$('#description').val(imageURL);
	}
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				file = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	function formSubmit(event){
		var data = new FormData();
		data.append('id',id);
		data.append('description',$('#description').val());
		data.append('file',file);
		$('#error').html("");
		var description = $('#description').val();
		var form = document.getElementById("file");
		if(!ValidateSingleInput(form)){
			$('#error').html("Inalid File Format.");
			return;
		}
		var urlPattern = /[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
		var match = urlPattern.test(description);
		if(!match){
			$('#error').html("URL is not in correct format.");
			return;
		}
		if(description == ""){
			$('#bannerForm')[0].checkValidity();
			$('#error').html("Please enter description.");
			return;
		}
		console.log(data);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: 'banner',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(data, textStatus, jqXHR)
			{
				if(typeof data.error === 'undefined')
				{
					$('#img'+id).attr("src",file);
					console.log('SUCCESS: ' + textStatus);
					$('#error').html("Uploaded.");
				}
				else
				{
					console.log('ERRORS: ' + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				console.log('ERRORS: ' + textStatus);
			}
		});
	}
	var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
	function Validate(oForm) {
		var arrInputs = oForm.getElementsByTagName("input");
		for (var i = 0; i < arrInputs.length; i++) {
			var oInput = arrInputs[i];
			if (oInput.type == "file") {
				var sFileName = oInput.value;
				if (sFileName.length > 0) {
					var blnValid = false;
					for (var j = 0; j < _validFileExtensions.length; j++) {
						var sCurExtension = _validFileExtensions[j];
						if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
							blnValid = true;
							break;
						}
					}
					if (!blnValid) {
						alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
						return false;
					}
				}
			}
		}
		return true;
	}
	function ValidateSingleInput(oInput) {
if (oInput.type == "file") {
var sFileName = oInput.value;
if (sFileName.length > 0) {
var blnValid = false;
for (var j = 0; j < _validFileExtensions.length; j++) {
var sCurExtension = _validFileExtensions[j];
if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
blnValid = true;
break;
}
}

if (!blnValid) {
alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
oInput.value = "";
return false;
}
}else{
	return false;
}
}
return true;
}
</script>
@endsection