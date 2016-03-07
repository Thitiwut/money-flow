@extends('layouts.app')
@section('style')
<style>
    .category{
    margin: 0 5px;
    }
</style>
@endsection
@section('content')
<?php
$totalIncome  = 0;
$totalExpense = 0;
$progressBar  = 0;
?>
<div class="container">
    <div class="text-center">
        <h1 class="text-info">
          <i class="fa fa-refresh fa-spin"></i><em>Progress</em></span>
           </h1>
           <hr/>
  </div>
        <div class="text-center">

          <h3>Plan : @if(isset($plan)) {{$plan->name}} @endif now in <cite class="text-warning" id="demo"></cite>.</h3>
          <br>
        <h3><cite title="Source Title">@if(isset($plan)) {{$plan->description}} @endif</cite><cite>Now current balance is <em class="text-info">@if(isset($plan)) {{$plan->budget}} @endif</em>฿.</cite>
          <cite>initail budget is  <em class="text-warning">@if(isset($plan)) {{$plan->original}} @endif</em>฿.</cite></h3>
          <hr/>

    </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div>
                    <h4 class="text-muted">
                        <span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"><em>StartDate</em></span>
                    </h4>
                </div>
                <div>
                    <?php //var_dump($plan); ?>
                    @if(isset($plan)) {{date('D d F Y', strtotime($plan->
                    created_at))}} @endif
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h4 class="text-info">
                       <span class="glyphicon glyphicon-hourglass" aria-hidden="true"><em>CurrentDate</em></span>
                    </h4>
                </div>
                <div>
                    @if(isset($plan)) {{date('D d F Y')}} @endif
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h4 class="text-warning">
                        <span class="glyphicon glyphicon-star-empty" aria-hidden="true"><em>FinishDate</em></span>
                    </h4>

                </div>
                <div>
                    @if(isset($plan)) {{date('D d F Y', strtotime('+'.$plan->
                    period.' month', strtotime($plan->
                    created_at)))}} @endif

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
         <div class="row">
    <div class="col-xs-3 col-md-12"><h4><hr/><em>Plan target:</em><span class="text-warning">@if(isset($plan)) {{$plan->target}} @endif </span>฿ </h4></div>
    <div class="col-xs-6 col-md-12"><h4><cite title="Source Title">Target of this month:</cite><span class="text-warning"> @if(isset($month)) {{$month->limit}} @endif</span>฿</h4></div>

<div class="col-xs-6 col-md-12"><h4><cite title="Source Title">Current saving money(balance):</cite><span class="text-warning"> @if(isset($month)) {{$month->progress}}</span> ฿ out of <span class="text-warning"> {{$month->limit}}</span> ฿@endif</h4></div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="progress ">
            @if(isset($progress))
            <?php
				$progressBar = floor($progress);
				if($progressBar > 100){ $progressBar = 100;}
			?>
            @endif
            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="{{$progressBar}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$progressBar}}%;">
                    {{$progressBar}}%
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <table class="table table-bordered">
            <tr>
                <th>
                    <span class="glyphicon glyphicon-flash" aria-hidden="true"><em> Expense&Income</em></span>
                </th>
                <th width="200">

                    <span class="glyphicon glyphicon-sort" aria-hidden="true"><em>Amount</em></span>
                </th>
            </tr>
            <tr>
                <td colspan="2" class="container">
                    @if(isset($category))
                    @if($category)
                    @foreach($category as $financial)
                    <div class="col-md-12" style="border-bottom: 1px solid lightgray; margin-bottom: 15px;">
                        <div>
                            <strong>
                                {{$financial["name"]}}
                            </strong>
                        </div>
                        @if($financial["income"] >
                        0)
                        <div class="text-right col-md-offset-9 col-md-3">
                            <div class="col-md-6">
                                <span class="label label-success">
                                    Income
                                </span>
                            </div>
                            <div class="col-md-6">
                                {{$financial["income"]}}
                                <?php $totalIncome += $financial["income"];?>
                            </div>
                        </div>
                        @endif
                        @if($financial["expense"] >
                        0)
                        <div class="text-right col-md-offset-9 col-md-3">
                            <div class="col-md-6">
                                <span class="label label-danger">
                                    Expense
                                </span>
                            </div>
                            <div class="col-md-6">
                                {{$financial["expense"]}}
                                <?php $totalExpense += $financial["expense"];?>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @endif
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-export" aria-hidden="true"><em> TotalExpense</em></span>
                </td>
                <td width="200" class="text-danger">
                    {{$totalExpense}}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-import" aria-hidden="true"><em> TotalIncome</em></span>
                </td>
                <td width="200" class="text-success">
                    {{$totalIncome}}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-saved" aria-hidden="true"><em> NetWorth.</em></span>
                </td>
                <td width="200" class="text-info">
                    {{$totalIncome - $totalExpense}}
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
@section('script')
    <script>
             var month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";

    var d = new Date();
    var n = month[d.getMonth()];
    document.getElementById("demo").innerHTML = n;
    </script>
@endsection
