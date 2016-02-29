@extends('layouts.app')
@section('style')
<style>
    .section{
    padding-top: 20px;
    padding-bottom: 20px;
    border-radius: 5px;
    border: 1px solid lightgrey;
    }
    .financial{
    padding-left: 20px;
    }
    .badge{float: right;}
    .expense_today{
    min-height: 500px;
    }
    .expense_add{
    margin-bottom: 10px;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="text-center">
        <h1>
            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
            <em>Expense and Income</em>
        </h1>
    </div>
    <div class="container">
        <div class="col-md-6">
            <div class="expense_add">
                <div>
                    <h3>
                       <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    <em>Detail</em>
                    </h3>
                </div>
                <form action="expense/finance" method="post">
                    <div class="form-group">
                        <label for="fdate">
                            Date
                        </label>
                        <input type="text" class="form-control" id="fdate" placeholder="Date" name="fdate" value="{{old('fdate')}}" />
                    </div>
                    <label for="email">
                        Type
                    </label>
                    <div class="form-group">
                        <div class="radio-inline">
                            <label for="ftyped">
                                <input type="radio" id="ftyped" name="ftype" value="0" @if(old('ftype') == 0) selected @endif />
                                Expense
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label for="ftypem">
                                <input type="radio" id="ftypem" name="ftype" value="1"  @if(old('ftype') == 1) selected @endif />
                                Income
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fcategory">
                            Category
                        </label>
                        <select id="fcategory" name="fcategory" class="form-control">
                            <option>
                                ---- Please Select Category ----
                            </option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}"  @if(old('fcategory') == $category->id) selected @endif >
                                {{$category->
                                name}}
                            </option>
                            @endforeach
                            @if($user)
                            @if($uCategories = $user->
                            categories()->
                            get())
                            @foreach($uCategories as $category)
                            <option value="{{$category->id}}" @if(old('fcategory') == $category->id) selected @endif >
                                {{$category->
                                name}}
                            </option>
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fname">
                            Name
                        </label>
                        <input type="text" class="form-control" id="fname" placeholder="Name" name="fname" value="{{old('fname')}}" />
                    </div>
                    <div class="form-group">
                        <label for="famount">
                            Amount
                        </label>
                        <input type="text" class="form-control" id="famount" placeholder="Amount" name="famount" value="{{old('famount')}}" />
                    </div>
                    <div class="form-group">
                        <label for="fdescription">
                            Description
                        </label>
                        <textarea class="form-control" id="fdescription" name="fdescription">{{old('fdescription')}}</textarea>
                    </div>
                    <div class="text-center">
                        @if(isset($plan))
                        <input type="hidden" name="plan_id" value="{{$plan->id}}"/>
                        @endif
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <button type="submit" class="btn btn-block btn-success">
                            <em>Add Detail</em>
                        </button>
                    </div>
                </form>
            </div>
            <div class="section col-md-12 plan_add_restrict">
                <form method="POST" action="plan/category" >
                    <div>
                        <h3>
                            <em>Add Category</em>
                        </h3>
                    </div>
                    <input type="text" class="form-control" id="cName" placeholder="New Category" name="cname"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <button type="submit" class="btn btn-block btn-success">
                        <em>Add new category</em>
                    </button>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <form method="POST" action="expense/delete">
                <div class="section col-md-12 expense_today">
                    <div>
                        <h3>
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            <em>Today Expense and Income</em>
                            <hr/>
                        </h3>
                    </div>
                    
                        <div>
                            <?php
                            $totalIncome  = 0;
                            $totalExpense = 0;
                            ?>
                            @if(isset($daily))
                            @foreach($daily->
                            finances()->
                            get() as $finance)
                            <?php $isType = false;
                            if ($finance->
                            type == 1) {
                            $totalIncome += $finance->
                            amount;
                            $isType = true;
                            } else {
                            $totalExpense += $finance->
                            amount;
                            }
                            ?>
                            <p class="bg-<?php if ($isType) {echo 'success';} else {echo 'danger';}?> financial">
                                <input type="checkbox" name="expense[]" value="{{$finance->id}}" />
                                <span class="label label-info">{{$finance->category->name}}</span> {{$finance->name}}
                                <span class="badge">
                                    <?php if ($isType) {
                                    echo '+';} else {
                                    echo '-';
                                    }
                                    ?>
                                    {{$finance->
                                    amount}}
                                </span>
                            </p>
                            @endforeach
                            @endif
                        </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <button type="submit" class="btn btn-block btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="section col-md-12 expense_summary">
                <div>
                    <div class="alert alert-warning" role="alert">
                        Total expense
                        <span class="badge">
                            -{{$totalExpense}}
                        </span>
                    </div>
                    <div class="alert alert-success" role="alert">
                        Total income
                        <span class="badge">
                            +{{$totalIncome}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
	$.fn.datepicker.defaults.format = "dd/mm/yyyy";
	$('#fdate').datepicker();
</script>
@endsection
