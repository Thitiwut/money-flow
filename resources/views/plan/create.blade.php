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
    <div class="text-center">
        <h1>
            <span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
            <em>Plan</em>
        </h1>
    </div>
     <div class="container"><a href="plan/clear" onclick="return confirm('Do you want to create a new plan ?')? true: false;"  ><button class="btn btn-info">
      <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"><strong> Plan</strong></span></button></a>
     <hr/>
    </div>
    <div class="container">
        <div class="section col-md-6">
            <div>
                <h3>
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    <em>Detail</em>
                </h3>
            </div>

            <form method="POST" action="plan" >
                <div class="form-group">
                    <label for="email">
                        Name
                    </label>
                    <input type="text" class="form-control" id="pName" placeholder="Name" name="pname" value="<?php echo isset($plan) ? $plan->name : old('pname'); ?>" required/>
                </div>
                <div class="form-group">
                    <label for="pDescription">
                        Description
                    </label>
                    <textarea  type="text" class="form-control" id="pDescription" placeholder="Description" name="pdescription" required><?php echo isset($plan) ? $plan->description : old('pdescription'); ?></textarea>
                </div>
                   <div class="form-group">
                    <label for="pTarget">
                        Target Money
                    </label>
                    <input type="text" class="form-control" id="pTarget" placeholder="Target" name="ptarget" value="<?php echo isset($plan) ? $plan->target : old('ptarget'); ?>" required/>
                </div>
                 <div class="form-group">
                    <label for="pBudget">
                        Budget
                    </label>
                    <input type="text" class="form-control" id="pBudget" placeholder="Budget" name="pbudget" value="<?php echo isset($plan) ? $plan->original : old('pbudget'); ?>" required/>
                </div>
                <div class="form-group">
                    <label for="pMonth">
                        Duration
                    </label>
                    <input type="text" class="form-control" id="pMonth" placeholder="Per Month" name="pmonth" value="<?php echo isset($plan) ? $plan->period : old('pmonth'); ?>" required/>
                </div>


                   <div class="form-group has-warning">
                    <label for="pExpected">
                        Expected saving per month
                    </label>
                    <input type="number" class="form-control" id="pExpected" placeholder="Expected" name="pexpected" value="<?php echo isset($plan) ? $plan->expected : old('pexpected'); ?>" required/>
                </div>
                <div class="text-center">
                    <div class="col-md-6">
                        <button type="submit" onclick="return confirm('Are you want to save?')? true: false;" name="pSave" class="btn btn-block btn-success">
                            Save
                        </button>
                    </div>
                    <div class="col-md-6">
                        <input type="submit" onclick="return confirm('Are you sure to delete?')? true: false;" id="deleteForm" name="pdelete" class="btn btn-block btn-danger" value="Delete">
                    </div>
                </div>
                <input type="hidden" name="plan_id" value="<?php echo isset($plan) ? $plan->id : ''; ?>"/>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            </form>
        </div>
        <div class="section col-md-6 plan_add_restrict">
            <form method="POST" action="plan/category" >
                <div>
                    <h3>
                        <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                        <em>Add new Category</em>
                    </h3>
                </div>
                <input type="text" class="form-control" id="cName" placeholder="New Category" name="cname"/>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <button type="submit" onclick="return confirm('Add new category?')? true: false;" class="btn btn-block btn-success">
                    <em>Add new category</em>
                </button>
            </form>
        </div>
        <div class="col-md-6 no-padding">
            <div class="section col-md-12 plan_select_restrict">
                <form method="POST" action="plan/delete-restrict">
                    <div>
                        <h3><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                            <em>Limit and Restriction</em>
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
                        <button type="submit" onclick="return confirm('Delete?')? true: false;"class="btn btn-block btn-danger">
                            <em>Delete Limit</em>
                        </button>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>
            <div class="section col-md-12 plan_add_restrict">
                <div>
                    <h3>
                        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        <em>Add restriction and limit</em>
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
                        <button type="submit" onclick="return confirm('Add new limit ?')? true: false;" class="btn btn-block btn-success">
                            <em>Add new limit</em>
                        </button>
                    </div>
                    <input type="hidden" name="rplan" value="@if(isset($plan)){{$plan->id}}@endif"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#deleteForm").submit(function(e){
          e.preventDefault();
        });
        $("#pMonth").change(calculateExpected);
        $("#pTarget").change(calculateExpected);
        $("#pBudget").change(calculateExpected);
        function calculateExpected(){
            var period = $('#pMonth').val();
            var target = $('#pTarget').val();
            var budget = $('#pBudget').val();
            var min = (target-budget)/period;
            $('#pExpected').attr("min",min);
            $('#pExpected').val(min.toFixed(2));
        }
    });
</script>
@endsection
