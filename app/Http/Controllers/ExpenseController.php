<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Log;
use Hash;
use function view;

class ExpenseController extends Controller {
	function getIndex(){
		return view('expense.create');
	}
}