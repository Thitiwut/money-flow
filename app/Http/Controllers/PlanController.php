<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Log;
use Hash;
use function view;

class PlanController extends Controller {
	function getIndex(){
		return view('plan.create');
	}
}