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
    <div>
        <label>Plan List</label>
        <select id="planList">
            <option></option>
                @if(Session::get('Auth'))
                    <?php 
                        $plans = Session::get('Auth')->plans()->get();
                        foreach($plans as $plan){ ?>
                            <option value="{{$plan->id}}" @if(Session::has('Plan')) @if(Session::get('Plan') == $plan->id) selected @endif @endif >{{$plan->name}}</option>
                        <?php }
                    ?>
                @endif
        </select>
    </div>
</div>
<div class="container">
    <div class="text-center">
        <h1>
            Progress
        </h1>
    </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div>
                    <h4>
                        Start Date
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
                    <h4>
                        Current Date
                    </h4>
                </div>
                <div>
                    @if(isset($plan)) {{date('D d F Y')}} @endif
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h4>
                        Finish Date
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
    <div class="container" style="margin-top: 20px;">
        <div class="progress">
            @if(isset($progress))
            <?php $progressBar = floor($progress);?>
            @endif
            <div class="progress-bar" role="progressbar" aria-valuenow="{{$progressBar}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$progressBar}}%;">
                <span class="sr-only">
                    60% Complete
                </span>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <table class="table table-bordered">
            <tr>
                <th>
                    Expense / Income
                </th>
                <th width="200">
                    Amount
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
                    Total Expense
                </td>
                <td width="200">
                    {{$totalExpense}}
                </td>
            </tr>
            <tr>
                <td>
                    Total Income
                </td>
                <td width="200">
                    {{$totalIncome}}
                </td>
            </tr>
            <tr>
                <td>
                    Net Worth
                </td>
                <td width="200">
                    {{$totalIncome - $totalExpense}}
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
