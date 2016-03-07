@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="container">
     <div class="text-center">
          <h3><em>Report</em></h3>
     </div>
    <div>
        <div class="text-center">
            <blockquote>
              <p>Plan name:@if(isset($plan)) {{$plan->name}} @endif </p>
              <small><cite title="Source Title">@if(isset($plan)) {{$plan->description}} @endif</cite></small>
          </blockquote>
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
      <div class="container-fluid">
        <div class="row text-center">
            <div class="col-xs-4 col-md-4">
              <div class="panel panel-success">
  <div class="panel-heading"><em>Budget</em> </div>
    <div class="panel-body">
    @if(isset($plan)) {{$plan->original}} @endif </div> </div></div>
            <div class="col-xs-4 col-md-4">
              <div class="panel panel-warning">
  <div class="panel-heading"><em>Target</em>  </div>
    <div class="panel-body">
    @if(isset($plan)) {{$plan->target}} @endif </div></div></div>
            <div class="col-xs-4 col-md-4"><div class="panel panel-success">
<div class="panel-heading"><em>Current Balance</em>
</div>
  <div class="panel-body">
   @if(isset($plan)) {{$plan->budget}} @endif </div></div></div>
        <div class="row text-center">
            <div class="col-xs-6 col-md-4">
              <div class="panel panel-primary">
  <div class="panel-heading"><em>Total Income</em>  </div>
    <div class="panel-body">
       @if(isset($sumIncome)) {{$sumIncome}} @endif </div></div></div>
            <div class="col-xs-6 col-md-4">
              <div class="panel panel-primary">
  <div class="panel-heading"><em>
    Total Expense</em>
  </div>
    <div class="panel-body">@if(isset($sumExpense)) {{$sumExpense}} @endif </div></div></div>
            <div class="col-xs-6 col-md-4">
              <div class="panel panel-primary">
  <div class="panel-heading"><em>
    Net worth.</em>
  </div>
    <div class="panel-body"> @if(isset($sumIncome) && isset ($sumExpense)) {{$sumIncome - $sumExpense}} @endif </div></div></div>

    </div>
    <div class="row text-center">


      @if(isset($plan))
      @if($plan->target-$plan->budget <= 0)
      Status-<a href="#" class="btn btn-success">You have successfully this plan.</a>

      @endif
      <a href="#" class="btn btn-info">Status</a><a href="#" class="btn btn-danger">You have not done this plan yet.Go on keep doing.</a>
      @endif



</div>
<hr/>
    <form class="form-inline text-center">
        <div class="form-group">
            <label for="month">
                Month
            </label>
            <select  class="form-control" id="month" name="month">
                <option value="">
                    --Month--
                </option>
                <option value="0">
                    All
                </option>
                @if(isset($Month))
                @foreach($Month as $month)
                <option value="{{$month->id}}">
                    <?php echo date('F', strtotime($month->
        created_at)); ?>
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="category">
                Category
            </label>
            <select  class="form-control" id="category" name="category">
                <option value="">
                    --Category--
                </option>
                <option value="0">
                    All
                </option>
                @if(isset($Category))
                @foreach($Category as $category)
                <option value="{{$category->id}}">
                    {{$category->
                    name}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-default">
            Getlist
        </button>
    </form>
</div>

</div>
<hr/>
<div>
    <div style="overflow: hidden;">
        <table id="myTable" class="table table-striped table-hover ">
            <thead>
                <tr >
                    <th>
                        Plan Name
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Type
                    </th>
                    <th >
                        Category
                    </th>
                    <th>
                        Date
                    </th>
                      <!--   <th>
                            Plan
                        </th>-->
                    </tr >
                </thead>
                <tbody>
                    @if(isset($finances))
                    @foreach ($finances as $key =>
                    $finance)
                    <tr >
                        <td>
                            {{ $finance->
                            plan}}
                        </td>
                        <td>
                            {{ $finance->
                            name}}
                        </td>
                        <td >
                            {{ $finance->
                            amount}}
                        </td>
                        <td>
                            <?php echo ($finance->
        type == 0) ? "Expense" : "Income"; ?>
                        </td>
                        @if($finance->type == 0)
                        <td class="text-danger">
                            {{ $finance->
                            category }}
                        </td>
                        @endif
                        @if($finance->type == 1)
                        <td class="text-success">
                            {{ $finance->
                            category }}
                        </td>
                        @endif

                        <td>
                            {{ $finance->
                            created_at }}
                        </td>
                       <!-- <td>
                            {{ $finance->
                            plan }}
                        </td>-->
                    </tr>
                    @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
            </script>
<script>
    function parseQueryString(val) {
        var result = "Not found",
        tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
        }
        return result;
    }
    $(document).ready(function(){
        $('#month').val(parseQueryString('month'));
        $('#category').val(parseQueryString('category'));
    });
</script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
@endsection
