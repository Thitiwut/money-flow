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
	<div class="text-center"><h1>Expense and Income</h1></div>
	<div class="container">
		<div class="col-md-6">
			<div class="expense_add">
				<div><h3>Detail</h3></div>
				<div class="form-group">
					<label for="email">Date</label>
					<input type="date" class="form-control" id="eDate" placeholder="Date" name="date">
				</div>
				<label for="email">Type</label>
				<div class="form-group">
					<div class="text-center col-md-6"> 
						<button type="submit" class="btn btn-block btn-default">Expense</button>
					</div>
					<div class="text-center col-md-6"> 
						<button type="submit" class="btn btn-block btn-default">Income</button>
					</div>
				</div>
				<div class="form-group">
					<label for="pDescription">Category</label>
					<select class="form-control">
						<option>Food & Drink</option>
						<option>Shopping</option>
					</select>
				</div>
				<div class="form-group">
					<label for="pBudget">Amount</label>
					<input type="text" class="form-control" id="pBudget" placeholder="Budget" name="budget">
				</div>
				<div class="text-center"> 
					<button type="submit" class="btn btn-block btn-default">Add</button>
				</div>
			</div>
			<div class="section col-md-12 plan_add_restrict">
				<div><h3>Category</h3></div>
				<div class="form-group">
					<label for="pBudget">Name</label>
					<input type="text" class="form-control" id="pBudget" placeholder="Budget" name="budget">
				</div>	
				<div class="text-center"> 
					<button type="submit" class="btn btn-block btn-default">Create</button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="section col-md-12 expense_today">
				<div><h3>Today expense and income</h3></div>
				<div>
					<p class="bg-danger financial">Food <span class="badge">-40</span></p>
					<p class="bg-danger financial">drink <span class="badge">-30</span></p>
					<p class="bg-success financial">Salary <span class="badge">+500</span></p>
				</div>
			</div>
			<div class="section col-md-12 expense_summary">
				<div>
					<div class="alert alert-danger" role="alert">Total income <span class="badge">-70</span></div>
					<div class="alert alert-success" role="alert">Total income <span class="badge">+500</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

