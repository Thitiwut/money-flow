@extends('layouts.app')
@section('style')
<style>
    .section{
        padding-bottom: 20px;
        border-radius: 5px;
        border: 1px solid lightgrey;
    }
    .no-padding{padding-left: 0;padding-right: 0;}
</style>
@endsection
@section('content')
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
            Plan
        </h1>
    </div>
     <div class="container"><a href="plan/clear"><button class="btn btn-lg btn-success">Create Plan</button></a></div>
    <div class="container">
        <div class="section col-md-6">
            <div>
                <h3>
                    Detail
                </h3>
            </div>

            <form method="POST" action="plan" >
                <div class="form-group">
                    <label for="email">
                        Name
                    </label>
                    <input type="text" class="form-control" id="pName" placeholder="Name" name="pname" value="<?php echo isset($plan) ? $plan->name : old('pname'); ?>" />
                </div>
                <div class="form-group">
                    <label for="pDescription">
                        Description
                    </label>
                    <textarea  type="text" class="form-control" id="pDescription" placeholder="Description" name="pdescription" ><?php echo isset($plan) ? $plan->description : old('pdescription'); ?>
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="pExpected">
                        Expected saving per month
                    </label>
                    <input type="text" class="form-control" id="pExpected" placeholder="Expected" name="pexpected" value="<?php echo isset($plan) ? $plan->expected : old('pexpected'); ?>" />
                </div>
                <div class="form-group">
                    <label for="pTarget">
                        Target Money
                    </label>
                    <input type="text" class="form-control" id="pTarget" placeholder="Target" name="ptarget" value="<?php echo isset($plan) ? $plan->target : old('ptarget'); ?>" />
                </div>
                <div class="form-group">
                    <label for="pBudget">
                        Budget
                    </label>
                    <input type="text" class="form-control" id="pBudget" placeholder="Budget" name="pbudget" value="<?php echo isset($plan) ? $plan->budget : old('pbudget'); ?>" />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-block btn-default">
                        Save
                    </button>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            </form>
        </div>
        <div class="col-md-6 no-padding">
            <div class="section col-md-12 plan_select_restrict">
                <form method="POST" action="plan/delete-restrict">
                    <div>
                        <h3>
                            Limit and Restriction
                        </h3>
                    </div>
                    <div>

                            <ul class="list-group">
                                @if(isset($plan))
                                @foreach($plan->
                                restricts()->get() as $restrict)
                                <li class="list-group-item">
                                    <input type="checkbox" name="restrict[]" value="{{$restrict->id}}" /> {{$restrict->category->name}} - <span class="label label-success">
                                        {{$restrict->
                                        exceed}}
                                    </span> @if($restrict->for == 0) <span class="badge"> Daily </span> @else <span class="badge"> Monthly </span> @endif
                                </li>
                                @endforeach
                                @endif
                            </ul>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-block btn-default">
                            Delete Limit
                        </button>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>
            <div class="section col-md-12 plan_add_restrict">
                <div>
                    <h3>
                        Add restriction and limit
                    </h3>
                </div>
                <form method="POST" action="plan/restrict" >
                    <div class="radio-inline">
                        <label for="rtyped">
                            <input type="radio" id="rtyped" name="rtype" value="0" />
                            Daily
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label for="rtypem">
                            <input type="radio" id="rtypem" name="rtype" value="1" />
                            Monthly
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="rcategory">
                            Category
                        </label>
                        <select id="rcategory" name="rcategory" class="form-control">
                            <option>---- Please Select Category ----</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach

                            @if($user)
                            @if($uCategories = $user->
                            categories()->
                            get())
                            @foreach($uCategories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rlimit">
                            Limit
                        </label>
                        <input type="text" class="form-control" id="rlimit" placeholder="Limitation amount" name="rlimit"/>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-block btn-default">
                            Add new limit
                        </button>
                    </div>
                    <input type="hidden" name="rplan" value="@if(isset($plan)){{$plan->id}}@endif"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>
            <div class="section col-md-12 plan_add_restrict">
                <form method="POST" action="plan/category" >
                    <div>
                        <h3>
                            Add Category
                        </h3>
                    </div>
                    <input type="text" class="form-control" id="cName" placeholder="New Category" name="cname"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <button type="submit" class="btn btn-block btn-default">
                        Add new category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
