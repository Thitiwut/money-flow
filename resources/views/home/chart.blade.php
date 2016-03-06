@extends('layouts.app')
@section('content')
<div class="text-center"><h1><em>@if(isset($Plan) && $Plan != null) {{$Plan->name}} @endif</em></h1></div>
<div class="container text-center">
	<h1 class="text-info"><span class="glyphicon glyphicon-send" aria-hidden="true"><em>Progress</em></span></h1>
	<div class="row text-center">
		<div><small><cite title="Source Title">Networth vs Saving money per month.</cite></small></div>

	</div>
	<div class="row">
	<div class="col-md-5"> 
	<canvas id="plan" width="600" height="400"></canvas>
</div>
	<div class="col-md-6"> 
			<div class="row"> 

		<div class="col-md-12">
		<a href="#" class="btn btn-success btn-xs"></a>Your expected saving money per month.
	</div>
	    <div class="col-md-12">
	    	<p></p>
	    </div>
	<div class="col-md-12">
		<a href="#" class="btn btn-warning btn-xs"></a>Your budget that you saving each month.</em></p>
		</div>
	</div>
</div>
<!-- </div>
	<hr/>
	<div class="row">
	<em><h1 class="text-success" id="demo">
	</h1></em>
	<div class="row text-center">
		<div>
			<small>
				<cite title="Source Title">Income vs Expenses</cite>
			</small>
		</div>
	</div>
	<div class="col-md-5"> 
	<canvas id="month" width="600" height="400"></canvas>
</div>
<div class="col-md-6">
	<div class="row"> 

		<div class="col-md-12">
		<a href="#" class="btn btn-success btn-xs"></a>your total income in each day.
	</div>
	    <div class="col-md-12">
	    	<p></p>
	    </div>
	<div class="col-md-12">
		<a href="#" class="btn btn-danger btn-xs"></a>your total expense in each day.
		</div>
	</div>
</div> -->
</div>
	<hr/>
	<h2 class="text-success"><span class="glyphicon glyphicon-cd" aria-hidden="true"><em>Expense&Income</em></span>
	</h2>
	<p></p>
	<h4 class="text-success">Based on Categories</h4>
	<div class="row text-center">
		<div>
			<small>
				<cite title="Source Title">Each category expense and income</cite>
			</small>
		</div>
	</div>
  <p></p>
	<div>
		Please Select Month
		<select id="monthSelector">
			<option value="">--Month--</option>
			@if(isset($MonthList))
			@foreach($MonthList as $month)
			<option value="{{$month->id}}"><?php echo date('F', strtotime($month->created_at)); ?></option>
			@endforeach
			@endif
		</select>
	</div>
	<div>
		<div class="col-md-6 text-center">
		<h3 class="text-success">Income: @if(isset($SumIncome)) {{$SumIncome}} @endif</h3>
		<canvas id="incomePie" width="300" height="300"></canvas>
		</div>
		<div class="col-md-6 text-center">
		<h3 class="text-danger">Expense: @if(isset($SumExpense)) {{$SumExpense}} @endif</h3>
		<canvas id="expensePie" width="300" height="300"></canvas>
		</div>
	</div>
	
	<div style="padding-top: 20px;">
		@if(isset($Category))
		<?php foreach($Category as $key => $cat){ ?>
		<span class="label label-success" style="background-color: #{{$cat["color"]}}">{{$key}}</span>
		<?php } ?>	
		@endif
	</div>
	
	<hr/>
</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script type="text/javascript">
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
	<?php if (Session::has('Auth') && Session::has('Plan') && Session::get('Plan') != "" && $Daily != null) {
		?>
		$(document).ready(function(){
			$('#monthSelector').val(parseQueryString('month'));
			$('#monthSelector').change(function(){
				window.location.href = BASEURL+'?month=' + $('#monthSelector').val();
			});
			var plan = $("#plan").get(0).getContext("2d");
			var month = [<?php $count = count($Month);for ($i = 0; $i < $count; $i++) {
				echo "'" . $Month[$i] . "'";if ($i + 1 < $count) {
					echo ',';
				}
			}
			?>]
			var limit = [<?php $count = count($Limit);for ($i = 0; $i < $count; $i++) {
				echo "'" . $Limit[$i] . "'";if ($i + 1 < $count) {
					echo ',';
				}
			}
			?>]
			var progress = [<?php $count = count($Progress);for ($i = 0; $i < $count; $i++) {
				echo "'" . $Progress[$i] . "'";if ($i + 1 < $count) {
					echo ',';
				}
			}
			?>]
			var data = {
				labels: month,
				datasets: [
				{
					label: "Limit",
					fillColor: "rgba(0, 255, 0,0)",
					strokeColor: "rgba(0, 255, 2,1)",
					pointColor: "rgba(2, 255, 2,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(0, 255, 0,1)",
					data: limit
				},
				{
					label: "Budget",
					fillColor: "rgba(255,100,0,0)",
					strokeColor: "rgba(255,100,0,1)",
					pointColor: "rgba(255,100,2,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(217,83,38,0.3)",
					data: progress
				}
				]
			};
			var planChart = new Chart(plan).Line(data,{bezierCurve : false,});
			/*Daily*/
			// var monthElement = $("#month").get(0).getContext("2d");
			var days = [<?php for ($i = 1; $i <= $Daily['Day']; $i++) {
				echo "'day" . $i . "'";if ($i < $Daily['Day']) {
					echo ',';
				}
			}
			?>]
			var expense = [<?php $count = count($Daily["Expense"]);for ($i = 0; $i < $count; $i++) {
				echo "'" . $Daily["Expense"][$i] . "'";if ($i + 1 < $count) {
					echo ',';
				}
			}
			?>]
			var income = [<?php $count = count($Daily["Income"]);for ($i = 0; $i < $count; $i++) {
				echo "'" . $Daily["Income"][$i] . "'";if ($i + 1 < $count) {
					echo ',';
				}
			}
			?>]
			var dataDaily = {
				labels: days,
				datasets: [
				{
					label: "My First dataset",
					fillColor: "rgba(255,0,0,1)",
					strokeColor: "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data: expense
				},
				{
					label: "My Second dataset",
					fillColor: "rgba(0,255,0,1)",
					strokeColor: "rgba(151,187,205,0.8)",
					highlightFill: "rgba(151,187,205,0.75)",
					highlightStroke: "rgba(151,187,205,1)",
					data: income
				}
				]
			};
			// var monthChart = new Chart(monthElement).Bar(dataDaily);
			/*Category*/
			<?php if(isset($Category)){ ?>
			var incomeElement = $("#incomePie").get(0).getContext("2d");
			var incomePie = [
			<?php foreach($Category as $key => $cat){ ?>
			{                                                               
				value: <?php echo $cat["income"]; ?>,
				color:"#<?php echo $cat["color"]; ?>",
				highlight: "#FF5A5E",
				label: <?php echo "'".$key."'"; ?>
			},
			<?php } ?>
			];
			var incomeChart = new Chart(incomeElement).Pie(incomePie);

			var expenseElement = $("#expensePie").get(0).getContext("2d");
			var expensePie = [
			<?php foreach($Category as $key => $cat){ ?>
			{
				value: <?php echo $cat["expense"]; ?>,
				color:"#<?php echo $cat["color"]; ?>",
				highlight: "#FF5A5E",
				label: <?php echo "'".$key."'"; ?>
			},
			<?php } ?>
			];
			var expenseChart = new Chart(expenseElement).Pie(expensePie);
			<?php } ?>
		});
<?php } ?>
	</script>
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

		// var d = new Date();
		// var n = month[d.getMonth()];
		// document.getElementById("demo").innerHTML = n;

	</script>
@endsection
