@extends('layouts.app')
@section('content')
<!-- Portfolio Grid Section -->
<section id="portfolio">
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
      <div class="container">
        <h3>Check-List</h3><br>
        <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-7"></div>
          <div class="col-sm-1">
            <a href="#create" aria-controls="create" role="tab" data-toggle="tab" class="text-right" onclick="mfCheckList.clear();">
              <button class="btn btn-info">create</button>
            </a>
          </div>
        </div>
        <br>
        <div class="jumbotron">
          <div class="row" id="listRender">
           <!--  <div class="col-sm-4">
              <a href=""><h3>เอกสารฝึกงาน</h3></a>
              <a href="edit" class="btn btn-primary btn-xs">Edit</a>
              <a href="delete" class="btn btn-danger btn-xs">delete</a>
            </div>
            <div class="col-sm-4">
              <a href=""><h3>กยศ</h3></a>
              <a href="edit" class="btn btn-primary btn-xs">Edit</a>
              <a href="delete" class="btn btn-danger btn-xs">delete</a>
            </div> -->
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <!--<a href="#" class="btn btn-default" onclick="mfCheckList.clear();">ack</a>-->
          </div>
          <div class="col-sm-7">
          </div>
          <div class="col-sm-1">
            <a href="#" class="btn btn-success" onclick="mfCheckList.save();">Save</a>
          </div>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="create">
      <div class="container">
        <h3>Create Check-List</h3>
        <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-7"></div>
          <div class="col-sm-1">
            <a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="text-right" onclick="mfCheckList.clear();">
              <button class="btn btn-info">back</button>
            </a>
          </div>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Name</span>
          <input type="text" class="form-control" id="listName" placeholder="List name" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Description</span>
          <input type="text" class="form-control" id="listDescription" placeholder="List description" aria-describedby="basic-addon1" required>
        </div>
        <div class="jumbotron">
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-success" onclick="$('#addModal').toggle();">Add List</a>
            </div>
          </div>
          <div class="row" id="checkRender">
            <!-- <div class="col-sm-4">
              <div class="panel panel-default text-left">
                <div class="panel-body">
                  <input type="checkbox" />
                  <span>Test</span>
                </div>
              </div>
            </div> -->
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <a href="#home" class="btn btn-default" data-toggle="tab" onclick="mfCheckList.clear();">Back</a>
          </div>
          <div class="col-sm-4 text-center">
            <a href="#home" class="btn btn-danger" data-toggle="tab" onclick="mfCheckList.delete();">Delete</a>
          </div>
          <div class="col-sm-4 text-right">
            <a href="#home" class="btn btn-success" data-toggle="tab" onclick="mfCheckList.updateList();mfCheckList.clear();">Save</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="addModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="margin-top: 20%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Add new List</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">Name</span>
          <input type="text" class="form-control" id="checkName" placeholder="Username" aria-describedby="basic-addon1" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#addModal').hide();">Close</button>
        <button type="button" class="btn btn-primary" onclick="mfCheckList.addCheck();$('#addModal').hide();">Add Check</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<?php $list = $user->checklists()->first(); ?>
<script>
  var mfCheckList = {
    lists: <?php if($list == null){echo "{}";}else{echo $list->lists;} ?>,
    currentId: null,
    currentList: null,
    tempCheck: [],
    save: function(){
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "list",
        method: "post",
        data: { lists: JSON.stringify(mfCheckList.lists), },
        success: function(log,status){
          console.log(log);
          console.log(status);
          $.notify("Checklist Saved.", {className: "success", position:"top center" });
        },
        error: function(log,status){
          $.notify("Error during transaction.", {className: "error", position:"top center" });
        }
      });
    },
    edit: function(id){
      mfCheckList.currentId = id;
      mfCheckList.currentList = mfCheckList.lists[id];
      mfCheckList.tempCheck = mfCheckList.lists[id].checks;
      mfCheckList.updateEditor();
    },
    delete: function(id){
      if(mfCheckList.currentId){id = mfCheckList.currentId;}
      mfCheckList.lists[id] = undefined;
      mfCheckList.renderList();
    },
    clear: function(){
      $('#listName').val("");
      $('#listDescription').val("");
      $('#checkName').val("");
      $('#checkRender').html("");
      mfCheckList.currentId = null;
      mfCheckList.currentList = null;
      mfCheckList.tempCheck = [];
    },
    updateEditor: function(){
      $('#listName').val(mfCheckList.currentList['name']);
      $('#listDescription').val(mfCheckList.currentList['description']);
      mfCheckList.renderCheck();
    },
    updateList: function(){
      var count = 0;
      if(mfCheckList.currentList){
        count = mfCheckList.currentId;
      }else{
        if(Object.keys(mfCheckList.lists).length){
          count = Object.keys(mfCheckList.lists).length;
        }
        else{
          count = 0;
        }
      }
      
      var list = {};
      list["name"] = $('#listName').val();
      list["description"] = $('#listDescription').val();
      list["checks"] = mfCheckList.tempCheck;
      mfCheckList.lists[count] = list;
      mfCheckList.renderList();

    },
    renderList: function(){
      var lists = mfCheckList.lists;
      var listRender = document.getElementById('listRender');
      listRender.innerHTML = "";
      for(var id in lists){
        if(lists[id]){
          var col = document.createElement("div");
          col.className = "col-sm-4";
          var content = "<a><h3>"+lists[id].name+"</h3></a>";
          content += '<a onclick="mfCheckList.edit('+id+');" href="#create" data-toggle="tab" class="btn btn-primary btn-xs">Edit</a>';
          content +=  '<a onclick="mfCheckList.delete('+id+');" class="btn btn-danger btn-xs">delete</a>';
          col.innerHTML += content;
          listRender.appendChild(col);
        }
      }
    },
    check: function(el,id){
      var checkBox = $(el);
      // checkBox.prop("checked", !checkBox.prop("checked"));
      mfCheckList.tempCheck[id]["check"] = checkBox.prop("checked");
    },
    addCheck: function(){
      var count = 0;
      if(Object.keys(mfCheckList.tempCheck).length){
        count = Object.keys(mfCheckList.tempCheck).length;
      }
      else{
        count = 0;
      }
      var check = {};
      check["name"] = $('#checkName').val();
      check["check"] = false;
      mfCheckList.tempCheck[count] = check;
      mfCheckList.renderCheck();
    },
    deleteCheck: function(id){
      mfCheckList.tempCheck.splice(id, 1);
      mfCheckList.renderCheck();
    },
    renderCheck: function(){
      var checks = mfCheckList.tempCheck;
      var checkRender = document.getElementById('checkRender');
      checkRender.innerHTML = "";
      for(var id in checks){
        var content =      '<div class="col-sm-4">';
        content += '<div class="panel panel-default text-left">';
        content += '<div class="panel-body">';
        content +=  '<a onclick="mfCheckList.deleteCheck('+id+');" class="btn btn-danger btn-xs">delete</a>';
        if(checks[id]["check"]){
          content += '<input type="checkbox" onclick="mfCheckList.check(this,'+id+')" checked />';
        }else{
          content += '<input type="checkbox" onclick="mfCheckList.check(this,'+id+')" />';
        }
        content += '<span>'+checks[id].name+'</span>';
        content += '</div>';
        content += '</div>';
        content += '</div>';
        checkRender.innerHTML += content;
      }
    },
  };
  mfCheckList.renderList();
</script>
@endsection