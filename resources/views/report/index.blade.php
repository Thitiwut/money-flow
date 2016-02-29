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
        <h1>
             <span class="glyphicon glyphicon-file" aria-hidden="true"><em>Report</em></span>
              
        </h1>
    </div>
        <div class="text-center">
            <blockquote>
          <p>Your plan is @if(isset($plan)) {{$plan->name}} @endif </p>
          <small><cite title="Source Title">@if(isset($plan)) {{$plan->description}} @endif</cite></small>
        </blockquote>
        </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6">
                <div class="well well-sm">
                     <span><em>-StartDate</em>: </span>
                          <?php //var_dump($plan); ?>
                    @if(isset($plan)) {{date('D d F Y', strtotime($plan->
                    created_at))}} @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="well well-sm">
                <span><em>-FinishDate:</em></span>   
                    @if(isset($plan)) {{date('D d F Y', strtotime('+'.$plan->
                    period.' month', strtotime($plan->
                    created_at)))}} @endif
                </div>
            </div>
        </div>
         <div class="row text-center">
                <div class="col-md-4"></div>
                <div class="col-md-4"> <div class="well well-sm">
                <span><em>Today :</em></span>   
                    @if(isset($plan)) {{date('D d F Y')}} @endif
                </div></div>
                <div class="col-md-4"></div>
         </div>
    </div>
    <div class="container-fluid">
         <div class="row text-center">
            <div class="col-xs-6 col-md-4"><div class="panel panel-default">
                <div class="panel-heading">Goal</div><div class="panel-body">
                 @if(isset($plan)) {{$plan->target}} @endif ฿
            </div></div></div>
            <div class="col-xs-6 col-md-4"><div class="panel panel-default">
                <div class="panel-heading">Max</div><div class="panel-body">
                 @if(isset($month)) {{$month->limit}} @endif ฿</div></div></div>
	       <div class="col-xs-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">CurrentBudget</div><div class="panel-body">
             @if(isset($plan)) {{$plan->budget}} @endif ฿</div></div></div>
        </div>

    </div>

    <div class="container" style="margin-top: 20px;">
        <table class="table table-bordered">
            <tr>
                <th>
                    <span class="glyphicon glyphicon-flash" aria-hidden="true"><em>Expense&Income</em></span>
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
                    <span class="glyphicon glyphicon-export" aria-hidden="true"><em>Total Expense</em></span>
                </td>
                <td width="200">
                    {{$totalExpense}}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-import" aria-hidden="true"><em>Total Income</em></span>
                </td>
                <td width="200">
                    {{$totalIncome}}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="glyphicon glyphicon-saved" aria-hidden="true"><em>Net Worth</em></span>
                </td>
                <td width="200">
                    {{$totalIncome - $totalExpense}}
                </td>
            </tr>
        </table>
    </div>
      <div class="text-center">
     
             <div><a href="http://pdfcrowd.com/" class="btn btn-success">
                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"><em>Getreport.</em></span>
              </a></div>
 
    </div>
</div>
@endsection
