@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">

      <div class="text-center">
           <h3 class="text-info"><i class="fa fa-cog fa-spin"></i><em>Setting</em></h3>
           <hr/>
      </div>
      <div class="col-md-2">

        <div class="btn-group btn-group-justified">
          <div class="col-md-12">
            <a href="#profile" aria-controls="home" role="tab" data-toggle="tab" class="btn btn-info">
                <span class="glyphicon glyphicon-user" aria-hidden="true"> User-info </span>
            </a>
          <hr/>
          </div>
          <div class="col-md-12">
            <a href="#notification" aria-controls="home" role="tab" data-toggle="tab"  class="btn btn-warning">
                <span class="glyphicon glyphicon-bell" aria-hidden="true">
                </span> Notification
            </a>
          </div>
        </div>
   </div>
   <div class="cold-md-8">
<div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="profile">
        <div>
            <h4><em>Username</em> :<span class="text-info"> {{$user->username}}</span></h4>
            <h4><em>Email</em> : <span class="text-warning">{{$user->email}}</span></h4>
            <a href="#settings" aria-controls="home" role="tab" data-toggle="tab">
               <button class="btn btn-warning">Edit</button>
           </a>
       </div>
   </div>

   <div role="tabpanel" class="tab-pane" id="notification">
        <div>
            <form>
                <div class="checkbox">
                    <label>
                      <input type="checkbox"> Notification Email
                    </label>
                    <label>
                      <input type="date">Date
                    </label>
                    <label>
                      <input type="time">Time
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
   </div><!-- -->

   <div role="tabpanel" class="tab-pane" id="settings">
    <div class="row">
        <div class="container">
            <div><h1><em>User Setting</em></h1></div>
            <form class="col-md-5" method="post" action="update">
                <div class="form-group">
                    <label for="username">Usename</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{$user->username}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$user->email}}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="{{$user->password}}" pattern=".{6,}" title="6 characters minimum" value="{{old('password')}}" required>
                </div>
                <div class="form-group">
                    <label for="repassword">Re-Password</label>
                    <input type="password" class="form-control" id="repassword" placeholder="Re-Password" name="repassword" value="{{$user->password}}" pattern=".{6,}" title="6 characters minimum" required>
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
  </div>
</div>
</div>

</div>

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
