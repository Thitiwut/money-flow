@extends('layouts.app')
@section('content')
 <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 300px; height: 300px;" 
                    src="http://image.flaticon.com/icons/svg/138/138323.svg" data-holder-rendered="true">
                    <div class="intro-text">
                        <span class="name">Student Money Assistance</span>
                        <hr class="star-light">
                        <span class="skills">Money - Plan - Goal</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

 <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Activities News</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item text-center">
                    
            		 <a href="http://google.com" class="portfolio-link" >
                        <div class="caption">
                            <div class="caption-content">
                            	
                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                        <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[0]->file}}" data-holder-rendered="true">
                        <!--<img src="http://image.flaticon.com/icons/svg/138/138297.svg" class="img-responsive" alt="">-->
                     </a>
                </div>
                <div class="col-sm-4 portfolio-item text-center">
                    <a href="http://google.com" class="portfolio-link" target="_blank">
                        <div class="caption">
                            <div class="caption-content">

                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                         <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[1]->file}}" data-holder-rendered="true">
                    </a>
                </div>
               <div class="col-sm-4 portfolio-item text-center">
                    <a href="http://google.com" class="portfolio-link" target="_blank">
                        <div class="caption">
                            <div class="caption-content">

                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                         <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[2]->file}}" data-holder-rendered="true">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item text-center">
                    <a href="http://google.com" class="portfolio-link" target="_blank">
                        <div class="caption">
                            <div class="caption-content">

                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                       <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[3]->file}}" data-holder-rendered="true">
                    </a>
                </div>
             <div class="col-sm-4 portfolio-item text-center">
                    <a href="http://google.com" class="portfolio-link" target="_blank">
                        <div class="caption">
                            <div class="caption-content">

                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                         <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[4]->file}}" data-holder-rendered="true">
                    </a>
                </div>
              <div class="col-sm-4 portfolio-item text-center">
                    <a href="http://google.com" class="portfolio-link" target="_blank">
                        <div class="caption">
                            <div class="caption-content">

                                <i class="fa fa-location-arrow fa-3x"></i>
                            </div>
                        </div>
                         <img data-src="holder.js/140x140" class="img-rounded" alt="140x140" style="width: 250px; height: 250px;" 
                    src="{{$banners[5]->file}}" data-holder-rendered="true">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <p><img src="http://www.camt.cmu.ac.th/en/imgs/logo.png" alt="cmu" class="img-rounded"></p>
                </div>
                <div class="col-lg-4">
                    <p><img src="http://www.camt.cmu.ac.th/th/images/course_se.jpg" alt="camt" class="img-rounded"></p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="#" class="btn btn-lg btn-outline">
                        <i class="fa fa-file-code-o"></i>CAMT SOFTWARE ENGINEERING
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection