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
	<div class="text-center"><h1>Plan</h1></div>
	<div class="container">
		<div class="section col-md-6">
			<div><h3>Detail</h3></div>
			<div class="form-group">
				<label for="email">Name</label>
				<input type="text" class="form-control" id="pName" placeholder="Name" name="name">
			</div>
			<div class="form-group">
				<label for="pDescription">Description</label>
				<textarea  type="text" class="form-control" id="pDescription" placeholder="Description" name="descripton"></textarea>
			</div>
			<div class="form-group">
				<label for="pExpected">Expected saving per month</label>
				<input type="text" class="form-control" id="pExpected" placeholder="Expected" name="expected">
			</div>
			<div class="form-group">
				<label for="pTarget">Target Money</label>
				<input type="text" class="form-control" id="pTarget" placeholder="Target" name="target">
			</div>
			<div class="form-group">
				<label for="pBudget">Budget</label>
				<input type="text" class="form-control" id="pBudget" placeholder="Budget" name="budget">
			</div>
			<div class="text-center"> 
				<button type="submit" class="btn btn-block btn-default">Save</button>
			</div>
		</div>
		<div class="col-md-6 no-padding">
			<div class="section col-md-12 plan_select_restrict">
				<div><h3>Limit and Restriction</h3></div>
				<div>
					<ul>
						<li>Food & Drink</li>
						<li>Shopping</li>
					</ul>
				</div>
				<div class="text-center"> 
					<button type="submit" class="btn btn-block btn-default">Delete Limit</button>
				</div>
			</div>
			<div class="section col-md-12 plan_add_restrict">
				<div><h3>Add Limit</h3></div>
				<div>
					<div class="text-center col-md-6"> 
						<button type="submit" class="btn btn-block btn-default">Daily</button>
					</div>
					<div class="text-center col-md-6"> 
						<button type="submit" class="btn btn-block btn-default">Monthly</button>
					</div>
				</div>
				<div class="form-group">
					<label for="pBudget">Restrict</label>
					<select class="form-control">
						<option>Food & Drink</option>
						<option>Shopping</option>
					</select>
					OR
					<input type="text" class="form-control" id="pBudget" placeholder="Budget" name="budget">
					<button type="submit" class="btn btn-block btn-default">Add new restriction</button>
				</div>
				<div class="form-group">
					<label for="pBudget">Limit</label>
					<input type="text" class="form-control" id="pBudget" placeholder="Budget" name="budget">
				</div>	
				<div class="text-center"> 
					<button type="submit" class="btn btn-block btn-default">Create</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

