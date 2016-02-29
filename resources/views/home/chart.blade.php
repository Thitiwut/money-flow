@extends('layouts.app')
@section('content')
<div class="container text-center">
	<h1 class="text-info"><span class="glyphicon glyphicon-send" aria-hidden="true"><em>Progress</em></span></h1>
	  <div class="row text-center">
	   	<div><small><cite title="Source Title">Networth vs Saving money per month.</cite></small></div>
	   	
	   	  </div>
	<canvas id="plan" width="600" height="400"></canvas>
		<div><span class="label label-success">target</span>
		<span class="label label-warning">budget</span></div>
	<hr/>
	<h1 class="text-success"><span class="glyphicon glyphicon-object-align-bottom" aria-hidden="true"><em>Monthly</em></span>
</h1>
     <div class="row text-center">
	   	<div><small><cite title="Source Title">Income vs Expenses</cite></small></div>
		 </div>
	<canvas id="month" width="600" height="400"></canvas>
		<div><span class="label label-success">income</span>
		<span class="label label-danger">expense</span></div>
		<hr/>
</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script type="text/javascript">
	<?php if(Session::has('Auth') && Session::has('Plan')  && Session::get('Plan') != "") {?>
	$(document).ready(function(){
		var plan = $("#plan").get(0).getContext("2d");
		var month = [<?php $count = count($Month); for ($i=0; $i < $count; $i++){echo "'".$Month[$i]."'"; if($i+1 < $count)echo ',';} ?>]
		var limit = [<?php $count = count($Limit); for ($i=0; $i < $count; $i++){echo "'".$Limit[$i]."'"; if($i+1 < $count)echo ',';} ?>]
		var progress = [<?php $count = count($Progress); for ($i=0; $i < $count; $i++){echo "'".$Progress[$i]."'"; if($i+1 < $count)echo ',';} ?>]
		var data = {
		    labels: month,
		    datasets: [
		        {
		            label: "My First dataset",
		            fillColor: "rgba(38, 217, 172,0.2)",
		            strokeColor: "rgba(38, 217, 172,0.3)",
		            pointColor: "rgba(38, 217, 172,0.3)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(38, 217, 172,0.3)",
		            data: limit
		        },
		        {
		            label: "My Second dataset",
		            fillColor: "rgba(217,83,38,0.2)",
		            strokeColor: "rgba(217,83,38,0.3)",
		            pointColor: "rgba(217,83,38,0.3)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(217,83,38,0.3)",
		            data: progress
		        }
		    ]
		};
		var planChart = new Chart(plan).Line(data);
		/*Daily*/
		var monthElement = $("#month").get(0).getContext("2d");
		var days = [<?php for ($i=1; $i <= $Daily['Day']; $i++){echo "'".$i."'"; if($i < $Daily['Day'])echo ',';} ?>]
		var expense = [<?php $count = count($Daily["Expense"]); for ($i=0; $i < $count; $i++){echo "'".$Daily["Expense"][$i]."'"; if($i+1 < $count)echo ',';} ?>]
		var income = [<?php $count = count($Daily["Income"]); for ($i=0; $i < $count; $i++){echo "'".$Daily["Income"][$i]."'"; if($i+1 < $count)echo ',';} ?>]
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
		var monthChart = new Chart(monthElement).Bar(dataDaily);
	});
	<?php } ?>
</script>
@endsection
