@extends('layouts.app')
@section('content')


 <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
                   
              <h3>Check-List</h3><br>
             <div class="row">
                <div class="col-sm-4"></div>
                  <div class="col-sm-7"></div>
                    <div class="col-sm-1"><a href ="#" class="text-right"><button class="btn btn-info">create</button></p></a></div>
               
               </div>
               <br>
              <div class="jumbotron">
                           
      <div class="row">
    <div class="col-sm-4">
         <a href=""><h3>เอกสารฝึกงาน</h3></a>
        <a href="edit" class="btn btn-primary btn-xs">Edit</a>
        <a href="delete" class="btn btn-danger btn-xs">delete</a>
     </div>
     
     <div class="col-sm-4">
       <a href=""><h3>กยศ</h3></a>
        <a href="edit" class="btn btn-primary btn-xs">Edit</a>
        <a href="delete" class="btn btn-danger btn-xs">delete</a>
     </div>
     
</div>
</div>
              <div class="row">
                <div class="col-sm-4">
                  <a href="#" class="btn btn-default">Back</a>

                </div>
                <div class="col-sm-7">
                
                </div>
                <div class="col-sm-1">
                 <a href="#" class="btn btn-success">Save</a>

                </div>
              </div>
            </div><br>
   
    </section>

@endsection